<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportTemplateController;
use Illuminate\Support\Facades\Route;

// DASHBOARD
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// USER ROUTES
Route::middleware('auth')->group(function() {
    // List jobs
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
    // Job detail
    Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');
    // Apply job
    Route::post('/apply', [ApplicationController::class, 'store'])->name('applications.store');
});

// PROFILE ROUTES
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ADMIN ROUTES
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(function() {

    // Job management
    Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{id}/edit', [JobController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{id}', [JobController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->name('jobs.destroy');

    // Applicants management
    Route::get('/jobs/{job_id}/applicants', [JobController::class, 'applicants'])->name('jobs.applicants');
    Route::post('/applications/{id}/status', [ApplicationController::class, 'updateStatus'])
        ->name('applications.updateStatus');

    // Export applicants
    Route::get('/export/{job_id}', [ExportController::class, 'export'])->name('export.applicants');

    // Download import template
    Route::get('/import/template', [ImportTemplateController::class, 'downloadTemplate'])
        ->name('import.template');
});

require __DIR__.'/auth.php';

