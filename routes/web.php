<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
//    return redirect()->route('auth.login.get');
});


Route::group(['prefix' => 'auth'], function () {
    Route::get('/login', [AuthController::class, 'getLogin'])->name('auth.login.get');
    Route::post('/login', [AuthController::class, 'postLogin'])->name('auth.login.post');

    Route::match(['get', 'post'], '/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot-password');
    Route::get('/forgot-password-sent', [AuthController::class, 'forgotPasswordSent'])->name('auth.forgot-password-success.get');

    Route::match(['get', 'post'], '/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset-password');
    Route::get('/success_reset_request', function () {
        return view('auth.success_reset_request');
    })->name('auth.success_reset_request.get');

    Route::get('/success_activation', function () {
        return view('auth.success_activation');
    })->name('auth.success_activation.get');

    Route::get('/success_reset', function () {
        return view('auth.success_reset');
    })->name('auth.success_reset.get');

    Route::get('/register', [RegistrationController::class, 'getRegister'])->name('auth.register.get');
    Route::post('/register', [RegistrationController::class, 'store'])->name('auth.register.post');

    // Google authentication
    Route::prefix('google')->group(function () {
        Route::get('redirect', [GoogleController::class, 'redirectToGoogle'])->name('auth.google.redirect');
        Route::get('callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');
    });
});

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', function () {
        return view('layouts.master');
    })->name('dashboard');

    Route::group(['prefix' => 'categoris'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/{id}', [CategoryController::class, 'show'])->name('categories.show');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::post('/{id}/update', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/{id}/delete', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });
});
