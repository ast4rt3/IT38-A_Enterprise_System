<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        if ($user->role !== 'driver') {
            auth()->logout();
            return redirect()->route('login')->with('error', 'No driver profile found. Please contact admin.');
        }
        // Get current active route
        $currentRoute = Route::where('driver_id', $user->id)
            ->whereIn('status', ['assigned', 'in_progress'])
            ->latest()
            ->first();

        // Get completed routes
        $completedRoutes = Route::where('driver_id', $user->id)
            ->where('status', 'completed')
            ->latest()
            ->take(5)
            ->get();

        return view('driver.dashboard', compact('currentRoute', 'completedRoutes'));
    }

    public function updateRouteStatus(Request $request, Route $route)
    {
        $request->validate([
            'status' => 'required|in:in_progress,completed'
        ]);

        // Ensure the route belongs to the authenticated driver
        if ($route->driver_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action');
        }

        $route->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Route status updated successfully');
    }
} 