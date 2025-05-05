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
