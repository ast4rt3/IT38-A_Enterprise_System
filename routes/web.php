<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\LiveMapController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ContactController;

// Logout route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Redirect root to login page
Route::get('/', function () {
    return redirect('/login');
});

// Login page route
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Home page route
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Corrected feature routes - use URL slugs, not file paths
Route::get('/features', [FeatureController::class, 'index'])->name('features');
Route::get('/live-map', [LiveMapController::class, 'index'])->name('live-map');
Route::get('/reports', [ReportController::class, 'index'])->name('reports');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Dashboard protected by auth and verified middleware
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated user profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
