<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditorDashboardController extends Controller
{
    public function index(){
        // dd(auth()->user()->hasRole('Editor'));
        return view('dashboard.editor.dashboard');
    }
}
