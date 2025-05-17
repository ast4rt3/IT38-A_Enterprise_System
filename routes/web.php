<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\LiveMapController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login
Route::get('/', fn () => redirect('/login'));

// Login page
Route::get('/login', fn () => view('auth.login'))->name('login');

// Driver registration submission
Route::get('/register/driver', [RegisteredUserController::class, 'createDriver'])->name('register.driver');
Route::post('/register/driver', [RegisteredUserController::class, 'storeDriver'])->name('register.driver.submit');


// Logout route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Public/guest-accessible pages
Route::get('/features', [FeatureController::class, 'index'])->name('features');
Route::get('/live-map', [LiveMapController::class, 'index'])->name('live-map');
Route::get('/reports', [ReportController::class, 'index'])->name('reports');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Home page
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Dashboard (auth + verified)
Route::get('/dashboard', fn () => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Laravel Breeze/Auth scaffolding
require __DIR__.'/auth.php';
