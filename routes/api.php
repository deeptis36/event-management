<?php

use Illuminate\Routing\Route;

Route::get('reviewers', [Api\ReviewerController::class, 'index']);
Route::get('talk-proposals/{talkProposal}/reviews', [Api\ReviewController::class, 'index']);
Route::get('talk-proposals/statistics', [Api\TalkProposalStatisticsController::class, 'index']);
