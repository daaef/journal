<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Journal;

// Check if authenticationCode Function exists
if (!function_exists('authenticationCode')) {
    /**
     * Generate Random Code
     *
     * @param int $length
     * @return string
     */
    function authenticationCode($length = 6)
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


function checkJournalInMyCollection($journal_id, $user_id) {
    $journalExists = DB::table('my_journal_collections')->where('journal_id', $journal_id)->where('user_id', $user_id)->exists();
    return $journalExists;
}

function downloadJournal($journal_id) {
    $journal = Journal::where('uuid',$journal_id)->first();

    if ($journal) {
        $path = $journal->journal_url;
        $name = $journal->title . $journal->journal_format;
        return response()->download(storage_path('app/public/' . $path), $name);
    }
}
