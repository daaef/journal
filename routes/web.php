<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('layouts.master');
    return redirect()->route('auth.login.get');
});


Route::group(['prefix' => 'auth'], function () {
    Route::get('/login', [AuthController::class, 'getLogin'])->name('auth.login.get');
    Route::post('/login', [AuthController::class, 'postLogin'])->name('auth.login.post');
    // Route::get('/logout', 'AuthController@logout')->name('logout');

    Route::get('/register', [RegistrationController::class, 'getRegister'])->name('auth.register.get');
    Route::post('/register', [RegistrationController::class, 'store'])->name('auth.register.post');
});

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', function() {
        return view('layouts.master');
    })->name('dashboard');
});


