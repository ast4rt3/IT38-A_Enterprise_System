@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-10 px-6 md:px-10">
    <h1 class="text-4xl font-bold text-green-700 mb-8">Reports Dashboard</h1>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl shadow-md text-center">
            <h2 class="text-lg font-semibold text-gray-600">Total Bins Collected</h2>
            <p class="text-5xl font-bold text-green-500 mt-2">{{ $binsCollected }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-md text-center">
            <h2 class="text-lg font-semibold text-gray-600">Active Drivers</h2>
            <p class="text-5xl font-bold text-green-500 mt-2">{{ $drivers }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-md text-center">
            <h2 class="text-lg font-semibold text-gray-600">Routes Completed</h2>
            <p class="text-5xl font-bold text-green-500 mt-2">{{ $routes }}</p>
        </div>
    </div>

    {{-- Collection Logs Table --}}
    <div class="bg-white rounded-2xl shadow-md p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Collection Logs</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border border-gray-300 rounded-lg overflow-hidden">
                <thead class="bg-green-100 text-left text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 border border-gray-200">Date</th>
                        <th class="px-4 py-3 border border-gray-200">Driver</th>
                        <th class="px-4 py-3 border border-gray-200">Route</th>
                        <th class="px-4 py-3 border border-gray-200">Bins</th>
                        <th class="px-4 py-3 border border-gray-200">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach ($logs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border border-gray-200">{{ $log['date'] }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $log['driver'] }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $log['route'] }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $log['bins'] }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $log['status'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Completed Routes History --}}
    <div class="bg-white rounded-2xl shadow-md p-6 mt-10">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Completed Routes History</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border border-gray-300 rounded-lg overflow-hidden">
                <thead class="bg-green-50 text-left text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 border border-gray-200">Date</th>
                        <th class="px-4 py-3 border border-gray-200">Driver</th>
                        <th class="px-4 py-3 border border-gray-200">Route</th>
                        <th class="px-4 py-3 border border-gray-200">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($completedRoutesList as $route)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border border-gray-200">{{ $route->updated_at->format('M d, Y') }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $route->driver ? $route->driver->first_name . ' ' . $route->driver->last_name : 'Unassigned' }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $route->start_location }} → {{ $route->end_location }}</td>
                        <td class="px-4 py-2 border border-gray-200">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center text-gray-400">No completed routes found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
