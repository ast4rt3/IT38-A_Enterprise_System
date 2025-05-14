<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login'); // Correct redirect path for logout
})->name('logout');

// Ensure you only have one route for '/' (root)
Route::get('/', function () {
    return redirect('/login'); // Redirect root to login page
});

// Route for the login page
Route::get('/login', function () {
    return view('auth.login'); // Route to Login page
});

// Dashboard (Home)
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// Features
Route::get('/features', [FeatureController::class, 'index'])->name('features');

// Live Map
Route::get('/live-map', [LiveMapController::class, 'index'])->name('live-map');

// Reports
Route::get('/reports', [ReportController::class, 'index'])->name('reports');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Route for the dashboard page, protected by auth and verified middleware
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
