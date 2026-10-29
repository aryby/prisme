<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CallForPapersController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PaperController as AdminPaperController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

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
Route::view('/program', 'program')->name('program'); // Static view for program page :::

// New navbar pages (placeholders for now)
Route::view('/committees', 'committees')->name('committees');
Route::view('/speakers', 'speakers')->name('speakers');
Route::view('/calls', 'calls')->name('calls');
Route::view('/registration', 'registration')->name('registration');
Route::view('/publication', 'publication')->name('publication');
Route::view('/dates-news', 'dates-news')->name('dates-news');
Route::view('/attendees', 'attendees')->name('attendees');
Route::view('/history', 'history')->name('history');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/registration', [App\Http\Controllers\RegistrationController::class, 'index'])->name('registration');
Route::post('/registration', [App\Http\Controllers\RegistrationController::class, 'store'])->name('registration.store');
