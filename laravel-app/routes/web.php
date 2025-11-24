<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FreelancerController;

Route::get('/', function () {
    return view('freelancer.dashboard');
})->name('freelancer.dashboard');

// Freelancer API routes
Route::prefix('freelancer')->group(function () {
    Route::get('/projects', [FreelancerController::class, 'listProjects'])->name('freelancer.projects.list');
    Route::get('/projects/search', [FreelancerController::class, 'searchProjects'])->name('freelancer.projects.search');
    Route::post('/projects', [FreelancerController::class, 'createProject'])->name('freelancer.projects.create');
    Route::get('/bids', [FreelancerController::class, 'getBids'])->name('freelancer.bids.list');
    Route::post('/projects/{projectId}/bids', [FreelancerController::class, 'placeBid'])->name('freelancer.bids.place');
});

