<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Document Conversion Settings
    |--------------------------------------------------------------------------
    |
    | This file contains configuration settings for document conversion
    | capabilities in the JAPR journal system.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Conversion Method Preference
    |--------------------------------------------------------------------------
    |
    | The order in which conversion methods should be attempted.
    | Available methods: 'unoconv', 'libreoffice', 'pandoc'
    |
    */
    'method_preference' => [
        'unoconv',      // Primary method - fast and reliable
        'libreoffice',  // Legacy method - most compatible
        'pandoc'        // Fallback method
    ],

    /*
    |--------------------------------------------------------------------------
    | Command Paths
    |--------------------------------------------------------------------------
    |
    | Custom paths to conversion tools. Leave null to use system PATH.
    |
    */
    'paths' => [
        'unoconv' => env('UNOCONV_PATH', null),
        'libreoffice' => env('LIBREOFFICE_PATH', null),
        'pandoc' => env('PANDOC_PATH', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Conversion Settings
    |--------------------------------------------------------------------------
    |
    | Settings that control conversion behavior.
    |
    */
    'timeout' => env('CONVERSION_TIMEOUT', 120), // seconds
    'max_file_size' => env('CONVERSION_MAX_FILE_SIZE', 10240), // KB (10MB default)
    'temp_directory' => storage_path('app/temp'),
    'output_directory' => storage_path('app/public/journals'),

    /*
    |--------------------------------------------------------------------------
    | Supported File Types
    |--------------------------------------------------------------------------
    |
    | File extensions that are supported for conversion to PDF.
    |
    */
    'supported_extensions' => [
        'doc',
        'docx',
        'odt',
        'rtf',
        'txt'
    ],

    /*
    |--------------------------------------------------------------------------
    | Fallback Behavior
    |--------------------------------------------------------------------------
    |
    | What to do when conversion fails.
    | Options: 'store_original', 'reject', 'retry'
    |
    */
    'fallback_behavior' => env('CONVERSION_FALLBACK', 'store_original'),

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | Log conversion attempts and results for debugging.
    |
    */
    'log_conversions' => env('LOG_CONVERSIONS', true),
    'log_level' => env('CONVERSION_LOG_LEVEL', 'info'), // debug, info, warning, error
];
