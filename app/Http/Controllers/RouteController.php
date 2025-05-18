<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Driver;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function assignDriver(Request $request, Route $route)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id'
        ]);

        $route->update([
            'driver_id' => $request->driver_id,
            'status' => 'assigned'
        ]);

        return redirect()->back()->with('success', 'Driver assigned successfully');
    }

    public function unassignDriver(Route $route)
    {
        $route->update([
            'driver_id' => null,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Driver unassigned successfully');
    }
} 