<?php

require __DIR__.'/vendor/autoload.php';

// Initialize Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Str;

echo "Testing filename generation logic:\n";

function testFilenameGeneration($title) {
    echo "\nTesting title: '$title'\n";
    
    // Simulate the logic from EloquentJournalRepository
    $titleSlug = $title ? Str::slug($title, '-') : '';
    if (empty($titleSlug)) {
        $titleSlug = 'manuscript-' . time() . '-' . Str::random(8);
    }
    $baseFileName = $titleSlug;
    $fileName = $baseFileName . '.pdf';
    
    // Check if the generated filename is valid
    $filenameWithoutExt = pathinfo($fileName, PATHINFO_FILENAME);
    if (empty($filenameWithoutExt)) {
        echo "  Original filename '$fileName' is invalid, using fallback\n";
        $fileName = 'manuscript-' . time() . '-' . Str::random(8) . '.pdf';
    }
    
    echo "  Final filename: '$fileName'\n";
    echo "  Filename without extension: '" . pathinfo($fileName, PATHINFO_FILENAME) . "'\n";
    
    return $fileName;
}

// Test various problematic titles
$testTitles = [
    'Normal Title',
    '',
    '   ',
    '!!!',
    '...',
    '###',
    'Title with spaces',
    'Title-with-dashes',
    'Title_with_underscores',
    'Título con acentos',
    '123456',
    '.hidden',
    null
];

foreach ($testTitles as $title) {
    testFilenameGeneration($title);
}

echo "\nDone.\n";
