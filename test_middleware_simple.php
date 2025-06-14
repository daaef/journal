<?php

echo "=== TESTING MIDDLEWARE FUNCTIONALITY ===\n\n";

// Test middleware files exist and are accessible
$middlewareFiles = [
    'AdminMiddleware' => 'app/Http/Middleware/AdminMiddleware.php',
    'EditorMiddleware' => 'app/Http/Middleware/EditorMiddleware.php',
    'ReviewerMiddleware' => 'app/Http/Middleware/ReviewerMiddleware.php'
];

foreach ($middlewareFiles as $name => $file) {
    if (file_exists($file)) {
        echo "✓ {$name}: File exists at {$file}\n";

        // Check if the file contains the authentication fix
        $content = file_get_contents($file);
        if (strpos($content, 'Auth::check()') !== false || strpos($content, 'auth()->check()') !== false) {
            echo "  ✓ Contains authentication check\n";
        } else {
            echo "  ⚠️ May be missing authentication check\n";
        }

        if (strpos($content, 'abort(403)') !== false || strpos($content, 'redirect') !== false) {
            echo "  ✓ Contains proper error handling\n";
        } else {
            echo "  ⚠️ May be missing error handling\n";
        }
    } else {
        echo "❌ {$name}: File missing at {$file}\n";
    }
    echo "\n";
}

echo "=== TESTING VIEW FILES ===\n\n";

$viewFiles = [
    'Login' => 'resources/views/auth/login.blade.php',
    'Register' => 'resources/views/auth/register.blade.php',
    'Forgot Password' => 'resources/views/auth/forgot.blade.php'
];

foreach ($viewFiles as $name => $file) {
    if (file_exists($file)) {
        echo "✓ {$name}: File exists at {$file}\n";

        // Check for common issues
        $content = file_get_contents($file);
        if (strpos($content, '@csrf') !== false) {
            echo "  ✓ Contains CSRF protection\n";
        } else {
            echo "  ⚠️ May be missing CSRF protection\n";
        }

        if (strpos($content, '@endif') !== false) {
            // Check if @endif is used incorrectly in CSS classes
            $lines = explode("\n", $content);
            foreach ($lines as $lineNum => $line) {
                if (strpos($line, 'class="') !== false && strpos($line, '@endif') !== false) {
                    echo "  ⚠️ Potential CSS syntax error on line " . ($lineNum + 1) . "\n";
                }
            }
        }
    } else {
        echo "❌ {$name}: File missing at {$file}\n";
    }
    echo "\n";
}

echo "Test completed!\n";
