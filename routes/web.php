<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditorDashboardController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SubSubCategoryController;
use App\Http\Controllers\JournalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', function () {
    return redirect()->route('auth.login.get');
})->name('login');

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

    //Activation
    Route::match(['get', 'post'], '/activate-account', [RegistrationController::class, 'showActivationPage'])->name('auth.activate');
    Route::match(['get', 'post'], '/activate', [RegistrationController::class, 'activate'])->name('auth.activate.post');

    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});


// Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/{id}', [CategoryController::class, 'show'])->name('categories.show');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::post('/{id}/update', [CategoryController::class, 'update'])->name('categories.update');
        Route::get('/{id}/delete', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });


    Route::group(['prefix' => 'sub-categories'], function () {
        Route::get('/', [SubCategoryController::class, 'index'])->name('subcategories.index');
        Route::get('/create', [SubCategoryController::class, 'create'])->name('subcategories.create');
        Route::post('/store', [SubCategoryController::class, 'store'])->name('subcategories.store');
        Route::get('/{id}', [SubCategoryController::class, 'show'])->name('subcategories.show');
        Route::get('/{id}/edit', [SubCategoryController::class, 'edit'])->name('subcategories.edit');
        Route::post('/{id}/update', [SubCategoryController::class, 'update'])->name('subcategories.update');
        Route::delete('/{id}/delete', [SubCategoryController::class, 'destroy'])->name('subcategories.destroy');
    });

    Route::group(['prefix' => 'sub-sub-categories'], function () {
        Route::get('/', [SubSubCategoryController::class, 'index'])->name('sub-subcategories.index');
        Route::get('/create', [SubSubCategoryController::class, 'create'])->name('sub-subcategories.create');
        Route::post('/store', [SubSubCategoryController::class, 'store'])->name('sub-subcategories.store');
        Route::get('/{id}', [SubSubCategoryController::class, 'show'])->name('sub-subcategories.show');
        Route::get('/{id}/edit', [SubSubCategoryController::class, 'edit'])->name('sub-subcategories.edit');
        Route::post('/{id}/update', [SubSubCategoryController::class, 'update'])->name('sub-subcategories.update');
        Route::delete('/{id}/delete', [SubSubCategoryController::class, 'destroy'])->name('sub-subcategories.destroy');
    });
});

//Editor Routes
Route::group(['prefix' => 'editor', 'middleware' => 'auth'], function () {
    Route::get('/', [EditorDashboardController::class, 'index'])->name('editor.dashboard');
});

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Route::get('/', function () {
    //     return view('layouts.master');
    // })->name('dashboard');




    // Journal Routes
    Route::group(['prefix' => 'journals'], function () {
        Route::get('/', [JournalController::class, 'index'])->name('journals.index');
        Route::get('/create', [JournalController::class, 'create'])->name('journals.create');
        Route::post('/store', [JournalController::class, 'store'])->name('journals.store');
        Route::get('/{id}', [JournalController::class, 'show'])->name('journals.show');
        Route::get('/{id}/edit', [JournalController::class, 'edit'])->name('journals.edit');
        Route::post('/{id}/update', [JournalController::class, 'update'])->name('journals.update');
        Route::delete('/{id}/delete', [JournalController::class, 'destroy'])->name('journals.destroy');
    });
});
