<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditorDashboardController extends Controller
{
    public function index(){
        return view('dashboard.editor.dashboard');
    }
}
