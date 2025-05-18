<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        // Real data from DB
        $totalBins = 145; // You can replace this with a real query if you track bins
        $activeDrivers = User::where('role', 'driver')->whereHas('routes', function($q) {
            $q->where('status', 'in_progress');
        })->count();
        $completedRoutes = Route::where('status', 'completed')->count();

        $collectionLogs = Route::with('driver')
            ->orderByDesc('updated_at')
            ->take(20)
            ->get()
            ->map(function($route) {
                return [
                    'date' => $route->updated_at->format('M d, Y'),
                    'driver' => $route->driver ? $route->driver->first_name . ' ' . $route->driver->last_name : 'Unassigned',
                    'route' => $route->start_location . ' → ' . $route->end_location,
                    'bins' => '-', // Replace with real bin count if available
                    'status' => ucfirst($route->status),
                ];
            });

        $completedRoutesList = Route::with('driver')
            ->where('status', 'completed')
            ->orderByDesc('updated_at')
            ->take(20)
            ->get();

        return view('reports', [
            'binsCollected' => $totalBins,
            'drivers' => $activeDrivers,
            'routes' => $completedRoutes,
            'logs' => $collectionLogs,
            'completedRoutesList' => $completedRoutesList,
        ]);
    }
}

