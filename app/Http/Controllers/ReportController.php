<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Example mock data (replace with actual DB queries)
        $totalBins = 145;
        $activeDrivers = 12;
        $completedRoutes = 89;

        $collectionLogs = [
            [
                'date' => 'May 14, 2025',
                'driver' => 'Law Heras',
                'route' => 'Route A',
                'bins' => 3,
                'status' => 'Completed',
            ],

        ];

        return view('reports', [
            'binsCollected' => $totalBins,
            'drivers' => $activeDrivers,
            'routes' => $completedRoutes,
            'logs' => $collectionLogs
        ]);
    }
}

