<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\PaperPreviewController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Author\CertificateDownloadController;
use App\Http\Controllers\Author\PaperDownloadController as AuthorPaperDownloadController;
use App\Http\Controllers\CallForPapersController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Reviewer\PaperDownloadController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Placeholder controllers using single-action closures for simple static pages

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Existing pages
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/call-for-papers', [CallForPapersController::class, 'index'])->name('call-for-papers');
Route::view('/author-instructions', 'author-instructions')->name('author-instructions');
Route::view('/important-dates', 'important-dates')->name('important-dates');
Route::get('/committee', [CommitteeController::class, 'index'])->name('committee');
Route::get('/submission', [SubmissionController::class, 'index'])->name('submission');
Route::post('/submission', [SubmissionController::class, 'store'])->name('submission.store');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');
Route::view('/venue', 'venue')->name('venue');
Route::view('/program', 'program')->name('program'); // Static view for program page :::

// New navbar pages (placeholders for now)
Route::view('/committees', 'committees')->name('committees');
Route::view('/speakers', 'speakers')->name('speakers');
Route::view('/calls', 'calls')->name('calls');
Route::view('/publication', 'publication')->name('publication');
Route::view('/dates-news', 'dates-news')->name('dates-news');
Route::view('/attendees', 'attendees')->name('attendees');
Route::view('/history', 'history')->name('history');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/forgot-password', [PasswordResetController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])
    ->middleware('throttle:6,1')
    ->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])
    ->middleware('throttle:6,1')
    ->name('password.update');
Route::redirect('/admin/login', '/login');
Route::redirect('/author', '/author/login');
Route::redirect('/author/login', '/login');
Route::redirect('/author/dashboard/login', '/login');
Route::redirect('/author/logout', '/author/dashboard/logout');
Route::post('/logout', function () {
    Auth::logout();

    return redirect('/');
})->name('logout');

Route::get('/reviewer/reviews/{review}/paper', PaperDownloadController::class)
    ->middleware('auth')
    ->name('reviewer.reviews.paper');

Route::get('/author/papers/{paper}/pdf', AuthorPaperDownloadController::class)
    ->middleware('auth')
    ->name('author.papers.pdf');

Route::get('/author/papers/{paper}/certificate', CertificateDownloadController::class)
    ->middleware('auth')
    ->name('author.papers.certificate');

Route::get('/admin/papers/{paper}/pdf', PaperPreviewController::class)
    ->middleware('auth')
    ->name('admin.papers.pdf');

// Email verification routes
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [VerificationController::class, 'send'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');
