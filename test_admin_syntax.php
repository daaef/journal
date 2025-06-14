<?php

require_once 'vendor/autoload.php';

// Test if we can load the admin dashboard controller
try {
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    
    $request = Illuminate\Http\Request::create('/admin', 'GET');
    
    echo "Testing admin route...\n";
    
    // This should trigger the same error if there's a syntax issue
    $response = $kernel->handle($request);
    
    echo "Admin route test passed!\n";
    echo "Response status: " . $response->getStatusCode() . "\n";
    
} catch (Exception $e) {
    echo "Error found:\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
