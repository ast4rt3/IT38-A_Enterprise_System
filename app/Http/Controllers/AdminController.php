<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $routes = Route::with(['driver'])->get();
        $drivers = User::where('role', 'driver')->get();
        return view('admin.dashboard', compact('routes', 'drivers'));
    }

    public function createRoute()
    {
        $drivers = User::where('role', 'driver')->get();
        return view('admin.routes.create', compact('drivers'));
    }

    public function storeRoute(Request $request)
    {
        // Decode waypoints JSON string to array before validation
        $request->merge([
            'waypoints' => json_decode($request->input('waypoints'), true)
        ]);

        $validated = $request->validate([
            'start_location' => 'required|string|max:255',
            'end_location' => 'required|string|max:255',
            'start_lat' => 'required|numeric',
            'start_lng' => 'required|numeric',
            'end_lat' => 'required|numeric',
            'end_lng' => 'required|numeric',
            'waypoints' => 'required|array|min:2',
            'waypoints.*.lat' => 'required|numeric',
            'waypoints.*.lng' => 'required|numeric',
            'driver_id' => 'required|exists:users,id,role,driver',
        ]);

        $validated['status'] = 'in_progress';
        $validated['scheduled_time'] = now()->format('Y-m-d H:i:s');

        Route::create($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Route created and assigned successfully');
    }

    public function editRoute(Route $route)
    {
        return view('admin.routes.edit', compact('route'));
    }

    public function updateRoute(Request $request, Route $route)
    {
        $validated = $request->validate([
            'start_location' => 'required|string|max:255',
            'end_location' => 'required|string|max:255',
            'start_lat' => 'required|numeric',
            'start_lng' => 'required|numeric',
            'end_lat' => 'required|numeric',
            'end_lng' => 'required|numeric',
            'status' => 'required|in:pending,assigned,in_progress,completed',
        ]);

        $route->update($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Route updated successfully');
    }

    public function destroyRoute(Route $route)
    {
        $route->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Route deleted successfully.');
    }
} 