<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\TestCaseController;
use App\Http\Controllers\TestProtocolController;
use App\Http\Controllers\TestResultController;
use App\Http\Controllers\AttachmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('projects.index');
});

Route::get('/dashboard', function () {
    return redirect()->route('projects.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Projects routes
    Route::resource('projects', ProjectController::class);
    
    // Requirements routes (nested under projects)
    Route::resource('projects.requirements', RequirementController::class)->scoped();
    Route::delete('projects/{project}/requirements/{requirement}/attachments/{attachment}', [RequirementController::class, 'deleteAttachment'])
        ->name('projects.requirements.attachments.destroy');
    
    // Attachment routes
    Route::get('attachments/{attachment}/download', [AttachmentController::class, 'download'])
        ->name('attachments.download');
    Route::delete('attachments/{attachment}', [AttachmentController::class, 'destroy'])
        ->name('attachments.destroy');
    
    // Download all attachments for a requirement
    Route::get('requirements/{requirement}/attachments/download-all', [AttachmentController::class, 'downloadAll'])
        ->name('requirements.attachments.download-all');
    
    // Test Cases routes (nested under projects)
    Route::resource('projects.test-cases', TestCaseController::class)->scoped();
    
    // Test Protocols routes (nested under projects)
    Route::resource('projects.test-protocols', TestProtocolController::class)->scoped()->except(['create', 'edit', 'update']);
    
    // Test Protocol execution route (standalone)
    Route::get('test-protocols/{testProtocol}', [TestProtocolController::class, 'show'])->name('test-protocols.show');
    
    // Test Results routes
    Route::patch('test-results/{testResult}', [TestResultController::class, 'update'])->name('test-results.update');
});

require __DIR__.'/auth.php';
