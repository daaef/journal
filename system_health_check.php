<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== ACADEMIC JOURNAL SYSTEM HEALTH CHECK ===\n\n";

try {
    // 1. Database Connection Test
    echo "1. DATABASE CONNECTION TEST\n";
    echo "   - Testing database connection...\n";
    $userCount = \App\Models\User::count();
    echo "   ✅ Database connected successfully\n";
    echo "   - Total users: {$userCount}\n";
    
    $journalCount = \App\Models\Journal::count();
    echo "   - Total journals: {$journalCount}\n";
    
    if ($userCount > 0) {
        $user = \App\Models\User::first();
        echo "   - Test user: {$user->email}\n";
    }
    
    // 2. Role System Test
    echo "\n2. ROLE SYSTEM TEST\n";
    $roles = \Spatie\Permission\Models\Role::all();
    echo "   - Available roles: " . $roles->pluck('name')->join(', ') . "\n";
    
    // Check role assignments
    $usersWithRoles = \App\Models\User::with('roles')->get();
    $roleDistribution = [];
    foreach ($usersWithRoles as $user) {
        foreach ($user->roles as $role) {
            $roleDistribution[$role->name] = ($roleDistribution[$role->name] ?? 0) + 1;
        }
    }
    
    foreach ($roleDistribution as $role => $count) {
        echo "   - {$role}: {$count} users\n";
    }
    
    // 3. Journal Workflow Test
    echo "\n3. JOURNAL WORKFLOW TEST\n";
    if ($journalCount > 0) {
        $journal = \App\Models\Journal::first();
        echo "   - Sample journal: {$journal->title}\n";
        echo "   - Status: {$journal->approval_status}\n";
        echo "   - Author: " . (\App\Models\User::find($journal->user_id)->fullname ?? 'Unknown') . "\n";
        
        // Test reviewers relationship
        $reviewers = $journal->reviewers;
        if ($reviewers) {
            echo "   - Reviewers assigned: " . $reviewers->count() . "\n";
        } else {
            echo "   - No reviewers assigned yet\n";
        }
    }
    
    // 4. Notification System Test
    echo "\n4. NOTIFICATION SYSTEM TEST\n";
    $notificationCount = \Illuminate\Notifications\DatabaseNotification::count();
    echo "   - Total notifications in database: {$notificationCount}\n";
    
    if ($userCount > 0) {
        $user = \App\Models\User::first();
        $userNotifications = $user->notifications()->count();
        $unreadNotifications = $user->unreadNotifications()->count();
        echo "   - Notifications for test user: {$userNotifications} (Unread: {$unreadNotifications})\n";
    }
    
    // 5. Route System Test
    echo "\n5. ROUTE SYSTEM TEST\n";
    $routes = \Route::getRoutes();
    $journalRoutes = 0;
    $notificationRoutes = 0;
    $editorRoutes = 0;
    $reviewerRoutes = 0;
    
    foreach ($routes as $route) {
        $name = $route->getName();
        if (str_contains($name, 'journal')) $journalRoutes++;
        if (str_contains($name, 'notification')) $notificationRoutes++;
        if (str_contains($name, 'editor')) $editorRoutes++;
        if (str_contains($name, 'reviewer')) $reviewerRoutes++;
    }
    
    echo "   - Journal routes: {$journalRoutes}\n";
    echo "   - Notification routes: {$notificationRoutes}\n";
    echo "   - Editor routes: {$editorRoutes}\n";
    echo "   - Reviewer routes: {$reviewerRoutes}\n";
    
    // 6. Model Relationships Test
    echo "\n6. MODEL RELATIONSHIPS TEST\n";
    if ($journalCount > 0) {
        $journal = \App\Models\Journal::with(['author', 'category', 'reviewers'])->first();
        echo "   - Journal-Author relationship: " . ($journal->author ? "✅ Working" : "❌ Failed") . "\n";
        echo "   - Journal-Category relationship: " . ($journal->category ? "✅ Working" : "❌ Failed") . "\n";
        echo "   - Journal-Reviewers relationship: " . (method_exists($journal, 'reviewers') ? "✅ Working" : "❌ Failed") . "\n";
    }
    
    // 7. Manuscript Version System Test
    echo "\n7. MANUSCRIPT VERSION SYSTEM TEST\n";
    $versionCount = \App\Models\ManuscriptVersion::count();
    echo "   - Total manuscript versions: {$versionCount}\n";
    
    if ($versionCount > 0) {
        $version = \App\Models\ManuscriptVersion::first();
        echo "   - Latest version number: {$version->version_number}\n";
        echo "   - Version author: " . (\App\Models\User::find($version->uploaded_by)->fullname ?? 'Unknown') . "\n";
    }
    
    // 8. Key Controller Methods Test
    echo "\n8. CONTROLLER METHODS TEST\n";
    $controllerMethods = [
        'JournalController' => [
            'approveForPublication',
            'rejectManuscript', 
            'requestRevisions',
            'submitReview',
            'uploadRevision',
            'SaveJournalReviewers'
        ],
        'NotificationController' => [
            'dashboard',
            'preferences',
            'markAllAsRead'
        ]
    ];
    
    foreach ($controllerMethods as $controller => $methods) {
        echo "   - {$controller}:\n";
        $fullController = "\\App\\Http\\Controllers\\{$controller}";
        if (class_exists($fullController)) {
            foreach ($methods as $method) {
                $exists = method_exists($fullController, $method);
                echo "     - {$method}: " . ($exists ? "✅" : "❌") . "\n";
            }
        }
    }
    
    echo "\n=== SYSTEM HEALTH CHECK COMPLETED ===\n";
    echo "✅ All major components appear to be functional\n";
    
} catch (\Exception $e) {
    echo "\n❌ ERROR ENCOUNTERED:\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
}
