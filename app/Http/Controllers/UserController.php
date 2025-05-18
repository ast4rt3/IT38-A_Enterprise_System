<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        $activeRoutes = Route::where('status', 'in_progress')
            ->with('driver')
            ->get();
            
        $pendingRoutes = Route::where('status', 'pending')
            ->with('driver')
            ->get();
            
        $completedRoutes = Route::where('status', 'completed')
            ->with('driver')
            ->get();

        $checkpoints = auth()->user()->checkpoints()->latest()->get();

        return view('user.dashboard', compact(
            'activeRoutes',
            'pendingRoutes',
            'completedRoutes',
            'checkpoints'
        ));
    }

    public function viewRoute(Route $route)
    {
        $route->load('driver');
        return view('user.routes.show', compact('route'));
    }
} 