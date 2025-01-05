<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\EditorDashboardController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SubSubCategoryController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\MyJournalCollectionController;
use App\Http\Controllers\ReviewerController;
use App\Http\Controllers\ReviewerDashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserInterestController;
use App\Models\Category;
use App\Models\Journal;
use App\Models\UserInterest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', function () {
    return redirect()->route('auth.login.get');
})->name('login');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/about', function () {
    return view('about')->with('journals', Journal::all());
})->name('about');

Route::get('/user-interests', [UserController::class, 'interests'])->name('user.interests');


Route::prefix('journals')->group(function () {
    Route::match(['get', 'post'], '/', [JournalController::class, 'searchJournal'])->name('journals');
    Route::get('/view/{slug}', [JournalController::class, 'showJournal'])->name('journals.view');
    Route::match(['get', 'post'], '/like-journal/', [JournalController::class, 'likeJournal'])->name('journals.like')->middleware('auth');
    Route::match(['get', 'post'], '/dislike-journal/', [JournalController::class, 'dislikeJournal'])->name('journals.dislike')->middleware('auth');
    Route::match(['get', 'post'], '/add-to-collection/', [MyJournalCollectionController::class, 'store'])->name('journals.add-to-collection')->middleware('auth');
    Route::match(['get', 'post'], '/remove-from-collection/', [MyJournalCollectionController::class, 'removeFromCollection'])->name('journals.remove-from-collection')->middleware('auth');
});


Route::group(['prefix' => 'auth'], function () {
    Route::get('/login', [AuthController::class, 'getLogin'])->name('auth.login.get');
    Route::post('/login', [AuthController::class, 'postLogin'])->name('auth.login.post');

    Route::match(['get', 'post'], '/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot-password');

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
    Route::post('/activate', [RegistrationController::class, 'activate'])->name('auth.activate.post');

    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});


// Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
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

    // Manage Roles and permissions
    Route::group(['prefix' => 'settings'], function () {
        // Manage Roles
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', [RoleController::class, 'index'])->name('roles.index');
            Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
            Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
            Route::get('/{id}', [RoleController::class, 'show'])->name('roles.show');
            Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
            Route::post('/{id}/update', [RoleController::class, 'update'])->name('roles.update');
            Route::get('/{id}/delete', [RoleController::class, 'destroy'])->name('roles.destroy');
        });

        // Manage Permissions
        Route::group(['prefix' => 'permissions'], function () {
            Route::get('/', [RoleController::class, 'index'])->name('permissions.index');
            Route::get('/create', [RoleController::class, 'create'])->name('permissions.create');
            Route::post('/store', [RoleController::class, 'store'])->name('permissions.store');
            Route::get('/{id}', [RoleController::class, 'show'])->name('permissions.show');
            Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('permissions.edit');
            Route::post('/{id}/update', [RoleController::class, 'update'])->name('permissions.update');
            Route::get('/{id}/delete', [RoleController::class, 'destroy'])->name('permissions.destroy');
        });

        // Manage users
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [UserController::class, 'index'])->name('users.index');
            Route::get('/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/store', [UserController::class, 'store'])->name('users.store');
            Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::post('/{id}/update', [UserController::class, 'update'])->name('users.update');
            Route::delete('/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy');
        });
    });
});

//Editor Routes
Route::group(['prefix' => 'editor', 'middleware' => ['auth', 'editor']], function () {
    Route::get('/', [EditorDashboardController::class, 'index'])->name('editor.dashboard');

    Route::group(['prefix' => 'journals'], function () {
        Route::get('/preview/{uuid}/{slug}', [JournalController::class, 'previewJournal'])->name('editor.journals.preview');
        Route::get('/pending', [JournalController::class, 'pendingApproval'])->name('editor.journals.pendingApproval');
        Route::get('/approved', [JournalController::class, 'approvedJournals'])->name('editor.journals.approved');
        Route::get('/in-progress', [JournalController::class, 'inProgressJournals'])->name('editor.journals.inProgress');
        Route::get('/declined', [JournalController::class, 'rejectedJournals'])->name('editor.journals.rejected');
        Route::get('/reviewed', [JournalController::class, 'reviewedJournals'])->name('editor.journals.reviewed');
        Route::post('/approve-journal', [JournalController::class, 'approveJournal'])->name('editor.journals.approveJournal');

        // Manage  Journal Reveiwers
        Route::post('/reviewers/{journal_uuid}', [JournalController::class, 'SaveJournalReviewers'])->name('editor.journals.reviewers.save');

        // Accept or decline Journal
        Route::match(['get', 'post'], '/accept-journal', [JournalController::class, 'acceptJournal'])->name('reviewer.accept');
        Route::match(['get', 'post'], '/decline-journal', [JournalController::class, 'declineJournal'])->name('reviewer.decline');
    });
});

Route::group(['prefix' => 'reviewer', 'middleware' => ['auth', 'reviewer']], function () {
    Route::get('/', [ReviewerDashboardController::class, 'index'])->name('reviewer.dashboard');

    Route::group(['prefix' => 'journals'], function () {
        Route::get('/review/{uuid}/{slug}', [JournalController::class, 'reviewerPreviewJournal'])->name('reviewer.journals.preview');
        Route::get('/pending', [JournalController::class, 'reviewerPendingApproval'])->name('reviewer.journals.pendingApproval');
        Route::get('/approved', [JournalController::class, 'reviewerApprovedJournals'])->name('reviewer.journals.approved');
        Route::get('/declined', [JournalController::class, 'reviewerRejectedJournals'])->name('reviewer.journals.rejected');
        Route::get('/in-progress', [JournalController::class, 'reviewerInProgressJournals'])->name('reviewer.journals.inProgress');
        Route::post('/approve-journal', [JournalController::class, 'approveJournal'])->name('reviewer.journals.approveJournal');
        Route::post('/approve-journal-with-comment', [JournalController::class, 'approveJournalWithComment'])->name('reviewer.journals.approveJournalWithComment');
        /**!SECTION
         * Request change for journals
         */
        Route::post('/journals/{journalId}/request-change', [JournalController::class, 'requestChange'])
        ->name('journals.request-change');
    });
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'publisher']], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/submit-manuscript', [JournalController::class, 'creatManuscript'])->name('submit-manuscript');
    Route::post('/submit-manuscript', [JournalController::class, 'submitManuscript'])->name('submit-manuscript.post');
    Route::get('/settings/{uuid}', [UserController::class, 'edit'])->name('user.settings');
    Route::post('/settings/{uuid}', [UserController::class, 'update'])->name('user.settings.update');
    Route::get('/submissions', [JournalController::class, 'userSubmissions'])->name('user.submissions');
    Route::get('/download-journal/{uuid}', [DownloadController::class, 'downloadJournal'])->name('download-journal');

    /**!SECTION
     * Make changes and update to requests
     */
    Route::post('/journals/{journalId}/author-update', [JournalController::class, 'authorUpdate'])
        ->name('journals.author-update');



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

Route::get('/load-subcategories', [SubCategoryController::class, 'getSubCategoriesByID'])->name('load-subcategories');
Route::get('/interests', [UserInterestController::class, 'interests'])->name('interests');
Route::post('/interests', [UserInterestController::class, 'store'])->name('interests.store');


Route::get('migrate', function () {
    Artisan::call('migrate');
    return 'Migrated';
});

Route::get('seed', function () {
    Artisan::call('db:seed');
    return 'Seeded';
});


Route::get('clear', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return 'Cleared';
});

Route::get('storage-link', function () {
    Artisan::call('storage:link');
    return 'Linked';
});

Route::get('optimize', function () {
    Artisan::call('optimize');
    return 'Optimized';
});

Route::get('key-generate', function () {
    Artisan::call('key:generate');
});

