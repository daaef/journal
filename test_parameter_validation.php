<?php

require __DIR__.'/vendor/autoload.php';

// Initialize Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing parameter validation:\n";

// Test the validation logic directly
function testValidation($targetPath, $fileName) {
    echo "Testing: targetPath='$targetPath', fileName='$fileName'\n";
    
    if (empty($targetPath)) {
        echo "  Result: Target path is empty\n";
        return false;
    }
    
    if (empty($fileName)) {
        echo "  Result: File name is empty\n";
        return false;
    }
    
    echo "  Result: Parameters valid\n";
    return true;
}

// Test various edge cases
testValidation('journals', 'test.pdf');
testValidation('', 'test.pdf');
testValidation('journals', '');
testValidation('journals', '.pdf');
testValidation('journals', 'test');

// Test pathinfo behavior
echo "\nTesting pathinfo behavior:\n";
$testFilenames = ['test.pdf', '.pdf', '', 'test', 'test.doc.pdf'];

foreach ($testFilenames as $filename) {
    $pathinfo = pathinfo($filename, PATHINFO_FILENAME);
    echo "pathinfo('$filename', PATHINFO_FILENAME) = '$pathinfo'\n";
    $pdfName = $pathinfo . '.pdf';
    echo "  Would generate: '$pdfName'\n";
}

echo "\nDone.\n";
