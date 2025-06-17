<?php

// Simple test script for UnoconvService on your AWS server
// Upload this file to your server and run: php test_unoconv_server.php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing UnoconvService on Server\n";
echo "================================\n\n";

try {
    // Test UnoconvService directly
    $unoconvService = new \App\Services\UnoconvService();
    
    echo "1. Testing UnoconvService availability:\n";
    $isAvailable = $unoconvService->isUnoconvAvailable();
    echo "   Available: " . ($isAvailable ? "✓ YES" : "✗ NO") . "\n";
    
    if ($isAvailable) {
        echo "2. Getting unoconv version:\n";
        $version = $unoconvService->getVersion();
        echo "   Version: " . ($version ?: "Unknown") . "\n";
        
        echo "3. Testing installation:\n";
        $testResult = $unoconvService->testInstallation();
        echo "   Test Result: " . ($testResult['success'] ? "✓ PASS" : "✗ FAIL") . "\n";
        echo "   Message: " . $testResult['message'] . "\n";
        if (isset($testResult['version'])) {
            echo "   Detected Version: " . $testResult['version'] . "\n";
        }
    }
    
    echo "\n4. Testing DocumentConversionService:\n";
    $documentService = new \App\Services\DocumentConversionService($unoconvService);
    echo "   DocumentConversionService: ✓ Available\n";
    
    echo "\n5. Manual command tests:\n";
    
    // Test unoconv command directly
    $commands = [
        'unoconv --version' => 'unoconv',
        'libreoffice --version' => 'LibreOffice', 
        'pandoc --version' => 'pandoc'
    ];
    
    foreach ($commands as $command => $name) {
        $output = shell_exec("$command 2>&1");
        if ($output && strpos($output, 'not found') === false && strpos($output, 'not recognized') === false) {
            echo "   $name: ✓ Available\n";
            if ($name === 'unoconv') {
                echo "     Output: " . trim(substr($output, 0, 100)) . "\n";
            }
        } else {
            echo "   $name: ✗ Not available\n";
        }
    }
    
    echo "\n6. Configuration check:\n";
    $config = config('document_conversion');
    if ($config) {
        echo "   Config loaded: ✓ YES\n";
        echo "   Timeout: " . ($config['timeout'] ?? 'Not set') . " seconds\n";
        echo "   Unoconv path: " . ($config['paths']['unoconv'] ?? 'System PATH') . "\n";
    } else {
        echo "   Config loaded: ✗ NO\n";
    }
    
    echo "\nTest Summary:\n";
    echo "=============\n";
    if ($isAvailable) {
        echo "✅ UnoconvService is working correctly!\n";
        echo "✅ Document conversion should work for manuscript submissions.\n";
    } else {
        echo "❌ UnoconvService is not working.\n";
        echo "❌ Check that unoconv is installed and in PATH.\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error testing UnoconvService: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nDone.\n";
