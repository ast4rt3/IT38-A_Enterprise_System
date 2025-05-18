<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\LiveMapController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\CheckpointController;
use App\Http\Middleware\CheckRole;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    
    $user = auth()->user();
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isDriver()) {
        return redirect()->route('driver.dashboard');
    } else {
        return redirect()->route('user.dashboard');
    }
});

Route::get('/features', [FeatureController::class, 'index'])->name('features');
Route::get('/live-map', [LiveMapController::class, 'index'])->name('live-map');
Route::get('/reports', [ReportController::class, 'index'])->name('reports');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Guest routes (only accessible when not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    
    Route::get('/register/driver', [RegisteredUserController::class, 'createDriver'])->name('register.driver');
    Route::post('/register/driver', [RegisteredUserController::class, 'storeDriver'])->name('register.driver.submit');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', function () {
        auth()->logout();
        return redirect('/login');
    })->name('logout');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Default dashboard route - redirects based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isDriver()) {
            return redirect()->route('driver.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('dashboard');

    // Admin routes
    Route::middleware([CheckRole::class.':admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/routes/create', [AdminController::class, 'createRoute'])->name('routes.create');
        Route::post('/routes', [AdminController::class, 'storeRoute'])->name('routes.store');
        Route::get('/routes/{route}/edit', [AdminController::class, 'editRoute'])->name('routes.edit');
        Route::patch('/routes/{route}', [AdminController::class, 'updateRoute'])->name('routes.update');
        Route::delete('/routes/{route}', [AdminController::class, 'destroyRoute'])->name('routes.destroy');
    });

    // Route Assignment Routes
    Route::middleware([CheckRole::class.':admin'])->group(function () {
        Route::post('/routes/{route}/assign', [RouteController::class, 'assignDriver'])->name('admin.routes.assign');
        Route::post('/routes/{route}/unassign', [RouteController::class, 'unassignDriver'])->name('admin.routes.unassign');
    });

    // Driver routes
    Route::middleware([CheckRole::class.':driver'])->prefix('driver')->name('driver.')->group(function () {
        Route::get('/dashboard', [DriverController::class, 'dashboard'])->name('dashboard');
        Route::get('/routes', [DriverController::class, 'routes'])->name('routes');
        Route::post('/routes/{route}/update-status', [DriverController::class, 'updateRouteStatus'])->name('routes.update-status');
    });

    // User routes
    Route::middleware([CheckRole::class.':user'])->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('/routes/{route}', [UserController::class, 'viewRoute'])->name('routes.show');
    });

    // Checkpoint routes
    Route::get('/checkpoints', [CheckpointController::class, 'index'])->name('checkpoints.index');
    Route::post('/checkpoints', [CheckpointController::class, 'store'])->name('checkpoints.store');
    Route::put('/checkpoints/{checkpoint}', [CheckpointController::class, 'update'])->name('checkpoints.update');
    Route::delete('/checkpoints/{checkpoint}', [CheckpointController::class, 'destroy'])->name('checkpoints.destroy');
});

// Laravel Breeze/Auth scaffolding
require __DIR__.'/auth.php';
