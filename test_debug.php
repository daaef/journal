<?php

echo "Starting debug test...\n";

try {
    require_once 'vendor/autoload.php';
    echo "✅ Autoload successful\n";

    // Load Laravel
    $app = require_once 'bootstrap/app.php';
    echo "✅ Laravel app loaded\n";

    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    echo "✅ Kernel created\n";

    $kernel->bootstrap();
    echo "✅ Kernel bootstrapped\n";

    $userCount = App\Models\User::count();
    echo "✅ Found {$userCount} users\n";

    $author = App\Models\User::role('Author')->first();
    if ($author) {
        echo "✅ Found author: {$author->fullname}\n";
    } else {
        echo "❌ No author found\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n";
    echo $e->getTraceAsString() . "\n";
}

echo "Debug test completed.\n";
