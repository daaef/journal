<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

use App\Models\Journal;
use App\Models\User;

echo "=== REVIEWER ASSIGNMENT SYSTEM STATUS ===\n\n";

try {
    // Get journals
    $journals = Journal::all();
    echo "📋 Journals: " . $journals->count() . "\n";

    foreach ($journals as $journal) {
        echo "  • {$journal->title} (UUID: {$journal->uuid})\n";
        $reviewers = $journal->reviewers()->with('user')->get();
        echo "    Assigned reviewers: {$reviewers->count()}\n";
        foreach ($reviewers as $reviewer) {
            echo "      - {$reviewer->user->fullname}\n";
        }
    }

    // Get Associate Editors
    $editors = User::role('Associate Editor')->get();
    echo "\n👥 Associate Editors: " . $editors->count() . "\n";
    foreach ($editors as $editor) {
        echo "  • {$editor->fullname} ({$editor->email})\n";
    }

    echo "\n🔗 Test URLs:\n";
    echo "  • Main site: http://journal.test\n";
    if ($journals->count() > 0) {
        $firstJournal = $journals->first();
        echo "  • Journal preview: http://journal.test/editor/journals/preview/{$firstJournal->uuid}\n";
    }

    echo "\n✅ System ready for reviewer assignment testing!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
