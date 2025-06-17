<?php

require __DIR__.'/vendor/autoload.php';

// Initialize Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing file handling in DocumentConversionService:\n";

try {
    // Test what happens when we move vs copy a file
    $tempFile = tempnam(sys_get_temp_dir(), 'test');
    file_put_contents($tempFile, 'test content for file handling');
    
    echo "1. Testing file copy vs move behavior:\n";
    
    // Test copy behavior
    $copyDest = tempnam(sys_get_temp_dir(), 'copy');
    if (copy($tempFile, $copyDest)) {
        echo "   ✓ Copy successful\n";
        echo "   Original file exists: " . (file_exists($tempFile) ? "YES" : "NO") . "\n";
        echo "   Copy file exists: " . (file_exists($copyDest) ? "YES" : "NO") . "\n";
        unlink($copyDest);
    }
    
    // Test move behavior  
    $moveDest = tempnam(sys_get_temp_dir(), 'move');
    unlink($moveDest); // Remove the temp file so we can move to it
    if (rename($tempFile, $moveDest)) {
        echo "   ✓ Move successful\n";
        echo "   Original file exists: " . (file_exists($tempFile) ? "YES" : "NO") . "\n";
        echo "   Moved file exists: " . (file_exists($moveDest) ? "YES" : "NO") . "\n";
        unlink($moveDest);
    }
    
    echo "\n2. This demonstrates why the original error occurred:\n";
    echo "   - When using move(), the original file is no longer available\n";
    echo "   - When using copy(), the original file remains for fallback storage\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\nTest complete.\n";
