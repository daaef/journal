<?php

use Illuminate\Support\Facades\Storage;

// Check if GenerateCode Function exists
if (!function_exists('generateCode')) {
    /**
     * Generate Random Code
     *
     * @param int $length
     * @return string
     */
    function generateCode($length = 6)
    {
        // Check if length is valid
        if ($length < 1) {
            $length = 6;
        }

        // Generate random code with specified length
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= random_int(0, 9);
        }

        return $code;
    }
}


// Generate file upload function
if (!function_exists('uploadFile')) {
    /**
     * Upload File
     *
     * @param string $file
     * @param string $name
     * @param string $path
     * @param string $disk
     * @return string
     */
    function uploadFile($file, $name, $path, $disk = 'public')
    {
        // Check if file is valid
        if (!$file->isValid()) {
            return null;
        }

        // Generate unique file name
        $fileName = $name . '_' . $file->getClientOriginalName();

        // Create the directory if it doesn't exist
        if (!Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->makeDirectory($path);
        }

        // Store file to specified path
        $storedPath = $file->storeAs($path, $fileName, $disk);

        // Get the full path of the stored file
        $fullPath = Storage::disk($disk)->path($storedPath);

        return $fullPath;
    }
}

// Generate file delete function
if (!function_exists('deleteFile')) {
    /**
     * Delete File
     *
     * @param string $fileName
     * @param string $path
     * @param string $disk
     * @return bool
     */
    function deleteFile($fileName, $path, $disk = 'public')
    {
        // Check if file name is valid
        if (!$fileName) {
            return false;
        }

        // Delete file from specified path
        return Storage::disk($disk)->delete($path . '/' . $fileName);
    }
}

