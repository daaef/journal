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
        // dd($file);

        // Generate unique file name
        $fileName = $name;
        // dd($fileName);
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

// African regions and their countries
if (!function_exists('africanRegions')) {
    /**
     * African Regions and their countries
     *
     * @return array
     */
    function africanRegions()
    {
        return [
            'Central Africa' => [
                'Angola',
                'Cameroon',
                'Central African Republic',
                'Chad',
                'Congo',
                'Democratic Republic of the Congo',
                'Equatorial Guinea',
                'Gabon',
                'São Tomé and Príncipe'
            ],
            'East Africa' => [
                'Burundi',
                'Comoros',
                'Djibouti',
                'Eritrea',
                'Ethiopia',
                'Kenya',
                'Madagascar',
                'Malawi',
                'Mauritius',
                'Mozambique',
                'Rwanda',
                'Seychelles',
                'Somalia',
                'South Sudan',
                'Tanzania',
                'Uganda',
                'Zambia',
                'Zimbabwe'
            ],
            'North Africa' => [
                'Algeria',
                'Egypt',
                'Libya',
                'Morocco',
                'Sudan',
                'Tunisia',
            ],
            'Southern Africa' => [
                'Botswana',
                'Eswatini',
                'Lesotho',
                'Namibia',
                'South Africa'
            ],
            'West Africa' => [
                'Benin',
                'Burkina Faso',
                'Cape Verde',
                'Gambia',
                'Ghana',
                'Guinea',
                'Guinea-Bissau',
                'Ivory Coast',
                'Liberia',
                'Mali',
                'Mauritania',
                'Niger',
                'Nigeria',
                'Senegal',
                'Sierra Leone',
                'Togo'
            ]
        ];
    }
}


function journalLanguages() {
    return [
        'American English',
        'British English',
        'French'
    ];
}
