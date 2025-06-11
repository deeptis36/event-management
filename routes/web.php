<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TalkProposalController;
use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Auth\LoginController;


// Show login form
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Handle login submission
Route::post('/login', [LoginController::class, 'login']);

// (Optional) Logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/',  [LoginController::class, 'showLoginForm']);

Route::resource('talk-proposals', TalkProposalController::class);

// Reviews
Route::post('talk-proposals/{talkProposal}/reviews', [ReviewController::class, 'store'])->name('reviews.store');




Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/reviewer/dashboard', [DashboardController::class, 'reviewer'])->name('reviewer.dashboard');
    Route::get('/speaker/dashboard', [DashboardController::class, 'speaker'])->name('speaker.dashboard');

    // admin/ Home / Dashboard
    Route::get('admin-dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('admin-talk-proposals', [TalkProposalController::class, 'index'])->name('admin.talk-proposals.index');
    Route::get('/proposals/create', [TalkProposalController::class, 'create'])->name('proposals.create');

    // Proposals
    Route::get('/proposals', [TalkProposalController::class, 'index'])->name('proposals.index');
    Route::post('admin/store-proposals', [TalkProposalController::class, 'store'])->name('admin.talk-proposals.store');
    Route::put('admin/update-proposals', [TalkProposalController::class, 'store'])->name('admin.talk-proposals.update');
    Route::get('/proposals/{proposal}', [TalkProposalController::class, 'show'])->name('proposals.show');
    Route::get('admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('admin/reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('reviews/create/{talkProposal}', [ReviewController::class, 'create'])->name('reviews.create');
        Route::post('reviews/store/{talkProposal}', [ReviewController::class, 'store'])->name('review.store');

    });
});

// Reviews

// Events

// Users (Admin View)
