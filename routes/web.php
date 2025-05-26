<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TalkProposalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('talk-proposals', TalkProposalController::class);

// Reviews
Route::post('talk-proposals/{talkProposal}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Reviewer Dashboard (with filters, search)
Route::get('reviewer/dashboard', [DashboardController::class, 'index'])->name('reviewer.dashboard');
