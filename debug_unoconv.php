<?php

// Debug script for UnoconvService issues
// Run this to diagnose Process-related problems

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "UnoconvService Debug Script\n";
echo "===========================\n\n";

try {
    // Test 1: Check if we can load the config
    echo "1. Testing configuration loading:\n";
    $config = config('document_conversion');
    if ($config) {
        echo "   ✓ Config loaded successfully\n";
        echo "   Timeout: " . ($config['timeout'] ?? 'Not set') . "\n";
        echo "   Unoconv path: " . ($config['paths']['unoconv'] ?? 'System PATH') . "\n";
    } else {
        echo "   ✗ Config not loaded\n";
    }
    
    echo "\n2. Testing UnoconvService instantiation:\n";
    $service = new \App\Services\UnoconvService();
    echo "   ✓ UnoconvService created successfully\n";
    
    echo "\n3. Testing unoconv path resolution:\n";
    $unoconvPath = config('document_conversion.paths.unoconv', 'unoconv');
    if (empty($unoconvPath)) {
        $unoconvPath = 'unoconv';
    }
    echo "   Resolved path: '$unoconvPath'\n";
    
    echo "\n4. Testing Symfony Process with unoconv:\n";
    try {
        $process = new \Symfony\Component\Process\Process([$unoconvPath, '--version']);
        echo "   ✓ Process created successfully\n";
        
        $process->run();
        if ($process->isSuccessful()) {
            echo "   ✓ Process executed successfully\n";
            echo "   Output: " . trim($process->getOutput()) . "\n";
        } else {
            echo "   ✗ Process failed\n";
            echo "   Error: " . $process->getErrorOutput() . "\n";
        }
    } catch (Exception $e) {
        echo "   ✗ Process creation/execution failed: " . $e->getMessage() . "\n";
    }
    
    echo "\n5. Testing UnoconvService methods:\n";
    
    $isAvailable = $service->isUnoconvAvailable();
    echo "   isUnoconvAvailable(): " . ($isAvailable ? "✓ TRUE" : "✗ FALSE") . "\n";
    
    $version = $service->getVersion();
    echo "   getVersion(): " . ($version ?: "null") . "\n";
    
    $testResult = $service->testInstallation();
    echo "   testInstallation(): " . ($testResult['success'] ? "✓ PASS" : "✗ FAIL") . "\n";
    echo "   Message: " . $testResult['message'] . "\n";
    
    echo "\n6. Testing manual shell commands:\n";
    $commands = [
        'unoconv --version',
        'which unoconv',
        'whereis unoconv'
    ];
    
    foreach ($commands as $cmd) {
        $output = shell_exec("$cmd 2>&1");
        echo "   $cmd: ";
        if ($output && strpos($output, 'not found') === false && strpos($output, 'not recognized') === false) {
            echo "✓ " . trim(substr($output, 0, 50)) . "\n";
        } else {
            echo "✗ " . trim($output ?: 'No output') . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Fatal error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nDebug completed.\n";
