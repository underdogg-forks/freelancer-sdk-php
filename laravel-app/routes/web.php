<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FreelancerController;

Route::get('/', function () {
    return view('freelancer.dashboard');
})->name('freelancer.dashboard');

// Freelancer API routes
Route::prefix('freelancer')->group(function () {
    
    // ========================================
    // PROJECT ROUTES (Implemented)
    // ========================================
    Route::get('/projects', [FreelancerController::class, 'listProjects'])->name('freelancer.projects.list');
    Route::get('/projects/search', [FreelancerController::class, 'searchProjects'])->name('freelancer.projects.search');
    Route::post('/projects', [FreelancerController::class, 'createProject'])->name('freelancer.projects.create');
    
    // Project type variations (Not yet implemented - require SDK extensions)
    Route::post('/projects/hireme', [FreelancerController::class, 'createHiremeProject'])->name('freelancer.projects.create-hireme');
    Route::post('/projects/hourly', [FreelancerController::class, 'createHourlyProject'])->name('freelancer.projects.create-hourly');
    Route::post('/projects/local', [FreelancerController::class, 'createLocalProject'])->name('freelancer.projects.create-local');
    
    // ========================================
    // BID ROUTES
    // ========================================
    Route::get('/bids', [FreelancerController::class, 'getBids'])->name('freelancer.bids.list');
    Route::post('/projects/{projectId}/bids', [FreelancerController::class, 'placeBid'])->name('freelancer.bids.place');
    
    // Bid management (Not yet implemented - require SDK resources)
    Route::post('/projects/{projectId}/bids/{bidId}/accept', [FreelancerController::class, 'acceptBid'])->name('freelancer.bids.accept');
    Route::post('/projects/{projectId}/bids/{bidId}/award', [FreelancerController::class, 'awardBid'])->name('freelancer.bids.award');
    Route::delete('/bids/{bidId}/retract', [FreelancerController::class, 'retractBid'])->name('freelancer.bids.retract');
    Route::delete('/bids/{bidId}/revoke', [FreelancerController::class, 'revokeBid'])->name('freelancer.bids.revoke');
    Route::post('/bids/{bidId}/highlight', [FreelancerController::class, 'highlightBid'])->name('freelancer.bids.highlight');
    
    // ========================================
    // USER ROUTES (Not yet implemented)
    // ========================================
    Route::get('/users', [FreelancerController::class, 'getUsers'])->name('freelancer.users.list');
    Route::get('/users/self', [FreelancerController::class, 'getSelf'])->name('freelancer.users.self');
    Route::get('/users/search', [FreelancerController::class, 'searchFreelancers'])->name('freelancer.users.search');
    Route::post('/users/jobs', [FreelancerController::class, 'addUserJobs'])->name('freelancer.users.jobs.add');
    Route::put('/users/jobs', [FreelancerController::class, 'setUserJobs'])->name('freelancer.users.jobs.set');
    Route::delete('/users/jobs', [FreelancerController::class, 'deleteUserJobs'])->name('freelancer.users.jobs.delete');
    Route::get('/portfolios', [FreelancerController::class, 'getPortfolios'])->name('freelancer.portfolios.list');
    Route::get('/reputations', [FreelancerController::class, 'getReputations'])->name('freelancer.reputations.list');
    
    // ========================================
    // MILESTONE ROUTES (Not yet implemented)
    // ========================================
    Route::get('/milestones', [FreelancerController::class, 'getMilestones'])->name('freelancer.milestones.list');
    Route::get('/milestones/{milestoneId}', [FreelancerController::class, 'getMilestone'])->name('freelancer.milestones.get');
    Route::post('/milestones', [FreelancerController::class, 'createMilestone'])->name('freelancer.milestones.create');
    Route::post('/milestones/request', [FreelancerController::class, 'createMilestoneRequest'])->name('freelancer.milestones.request');
    Route::post('/milestones/{milestoneId}/accept', [FreelancerController::class, 'acceptMilestoneRequest'])->name('freelancer.milestones.accept');
    Route::post('/milestones/{milestoneId}/reject', [FreelancerController::class, 'rejectMilestoneRequest'])->name('freelancer.milestones.reject');
    Route::delete('/milestones/{milestoneId}/request', [FreelancerController::class, 'deleteMilestoneRequest'])->name('freelancer.milestones.delete-request');
    Route::post('/milestones/{milestoneId}/release', [FreelancerController::class, 'releaseMilestone'])->name('freelancer.milestones.release');
    Route::post('/milestones/{milestoneId}/request-release', [FreelancerController::class, 'requestReleaseMilestone'])->name('freelancer.milestones.request-release');
    Route::post('/milestones/{milestoneId}/cancel', [FreelancerController::class, 'cancelMilestone'])->name('freelancer.milestones.cancel');
    
    // ========================================
    // MESSAGING ROUTES (Not yet implemented)
    // ========================================
    Route::get('/threads', [FreelancerController::class, 'getThreads'])->name('freelancer.threads.list');
    Route::get('/messages', [FreelancerController::class, 'getMessages'])->name('freelancer.messages.list');
    Route::get('/messages/search', [FreelancerController::class, 'searchMessages'])->name('freelancer.messages.search');
    Route::post('/messages', [FreelancerController::class, 'createMessage'])->name('freelancer.messages.create');
    Route::post('/projects/{projectId}/messages', [FreelancerController::class, 'createMessageProjectThread'])->name('freelancer.messages.create-project-thread');
    Route::post('/messages/attachment', [FreelancerController::class, 'createMessageWithAttachment'])->name('freelancer.messages.create-attachment');
    
    // ========================================
    // REVIEW ROUTES (Not yet implemented)
    // ========================================
    Route::post('/reviews/employer', [FreelancerController::class, 'createEmployerReview'])->name('freelancer.reviews.employer');
    Route::post('/reviews/freelancer', [FreelancerController::class, 'createFreelancerReview'])->name('freelancer.reviews.freelancer');
    
    // ========================================
    // CONTEST ROUTES (Not yet implemented)
    // ========================================
    Route::post('/contests', [FreelancerController::class, 'createContest'])->name('freelancer.contests.create');
    
    // ========================================
    // JOB CATEGORIES ROUTES (Not yet implemented)
    // ========================================
    Route::get('/jobs', [FreelancerController::class, 'getJobs'])->name('freelancer.jobs.list');
    
    // ========================================
    // TRACK ROUTES (Not yet implemented)
    // ========================================
    Route::post('/tracks', [FreelancerController::class, 'createTrack'])->name('freelancer.tracks.create');
    Route::get('/tracks/{trackId}', [FreelancerController::class, 'getTrack'])->name('freelancer.tracks.get');
    Route::put('/tracks/{trackId}', [FreelancerController::class, 'updateTrack'])->name('freelancer.tracks.update');
});

