<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function downloadJournal($uuid)
    {

        return downloadJournal($uuid);
    }
}
