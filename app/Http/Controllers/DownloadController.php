<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function downloadJournal($uuid)
    {
        if (!auth()->check()) {
            $notification = array(
                'message' => 'You need to login to download the journal.',
                'alert-type' => 'error'
            );

            // User is not authenticated, redirect to login page
            return redirect()->route('login')->with($notification);
        }
        return downloadJournal($uuid);
    }
}
// 
