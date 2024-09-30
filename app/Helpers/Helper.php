<?php

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
