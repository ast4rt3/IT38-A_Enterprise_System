@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
<style>
#admin-map-info {
    display: none !important;
}
.leaflet-routing-container {
    display: none !important;
}
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <h1 class="text-2xl font-bold text-green-600">SmartWaste Admin</h1>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <button class="text-gray-600 hover:text-gray-900 cursor-pointer relative">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                </button>
                <div class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center text-white cursor-pointer">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center"> 
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Drivers</p>
                        <h4 class="text-2xl font-bold text-gray-800">{{ $drivers->count() }}</h4>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <i class="fas fa-route text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Active Routes</p>
                        <h4 class="text-2xl font-bold text-gray-800">{{ $routes->where('status', '!=', 'completed')->count() }}</h4>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pending Routes</p>
                        <h4 class="text-2xl font-bold text-gray-800">
                            {{ $routes->whereIn('status', ['pending', 'in_progress'])->count() }}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Completed Today</p>
                        <h4 class="text-2xl font-bold text-gray-800">{{ $routes->where('status', 'completed')->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column -->
            <div class="space-y-8">
                <!-- Map -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">Route Map Testing</h3>
                    </div>
                    <div class="relative h-96 bg-gray-100 rounded-b-xl overflow-hidden">
                        <div id="admin-map" style="height: 24rem; width: 100%; border-radius: 0 0 0.75rem 0.75rem;"></div>
                    </div>
                </div>

                <!-- Route Information Panel -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Route Details</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <i class="fas fa-route text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Distance</p>
                                <p id="admin-distance" class="text-lg font-semibold text-gray-800">-</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Estimated Duration</p>
                                <p id="admin-duration" class="text-lg font-semibold text-gray-800">-</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <h4 class="text-md font-semibold text-gray-700 mb-3">Route Stops</h4>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <ul id="admin-stops" class="space-y-2 text-sm text-gray-600"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-8">
                <!-- Active Routes Table -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">Active Routes</h3>
                        <a href="{{ route('admin.routes.create') }}" class="btn btn-primary bg-green-600 text-white px-4 py-2 rounded-lg">
                            <i class="fas fa-plus mr-2"></i> New Route
                        </a>
                    </div>
                    <div class="overflow-x-auto" style="max-height: 400px; overflow-y: auto;">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Driver</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($routes->where('status', '!=', 'completed') as $route)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">{{ $route->start_location }}</div>
                                            <div class="text-sm text-gray-500">{{ $route->end_location }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                {{ $route->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                   ($route->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 
                                                   'bg-gray-100 text-gray-800') }}">
                                                {{ ucfirst($route->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($route->driver)
                                                <div class="text-sm text-gray-900">
                                                    {{ $route->driver->first_name }} {{ $route->driver->last_name }}
                                                </div>
                                            @else
                                                <form action="{{ route('admin.routes.assign', $route->id) }}" method="POST" class="flex items-center space-x-2">
                                                    @csrf
                                                    <select name="driver_id" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                                        <option value="">Select Driver</option>
                                                        @foreach($drivers as $driver)
                                                            <option value="{{ $driver->id }}">{{ $driver->first_name }} {{ $driver->last_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="text-sm bg-green-600 text-white px-3 py-1 rounded-md hover:bg-green-700">
                                                        Assign
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.routes.edit', $route->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                            @if($route->driver)
                                                <form action="{{ route('admin.routes.unassign', $route->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Unassign</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No active routes found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Available Drivers -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Available Drivers</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($drivers as $driver)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $driver->first_name }} {{ $driver->last_name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $driver->email }}</div>
                                        <div class="text-sm text-gray-500">{{ $driver->phone }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $driver->city }}</div>
                                        <div class="text-sm text-gray-500">{{ $driver->province }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Available
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Demo: Use the first route for visualization
    @php $firstRoute = $routes->first(); @endphp
    // Demo coordinates (Manila area)
    const start = [14.5995, 120.9842];
    const checkpoints = [
        [14.6040, 120.9900],
        [14.6100, 120.9950],
        [14.6150, 121.0000]
    ];
    const end = [14.6200, 121.0050];

    const map = L.map('admin-map').setView(start, 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Build waypoints array
    const waypoints = [
        L.latLng(start[0], start[1]),
        ...checkpoints.map(cp => L.latLng(cp[0], cp[1])),
        L.latLng(end[0], end[1])
    ];

    let markers = [];
    function updateRouteLine() {
        if (routingControl) {
            routingControl.setWaypoints(markers.map(m => m.getLatLng()));
        }
    }
    waypoints.forEach((wp, i) => {
        const marker = L.marker(wp, { draggable: true }).addTo(map);
        marker.bindPopup(`Stop ${i + 1}`);
        marker.on('dblclick', function() {
            map.removeLayer(marker);
            markers = markers.filter(m => m !== marker);
            updateRouteLine();
        });
        marker.on('drag', updateRouteLine);
        markers.push(marker);
    });

    const routingControl = L.Routing.control({
        waypoints: waypoints,
        routeWhileDragging: true,
        showAlternatives: false,
        lineOptions: {
            styles: [{ color: 'blue', weight: 6 }]
        },
        createMarker: function(i, wp, nWps) {
            // Don't create default markers, we handle them above
            return null;
        }
    }).addTo(map);

    // Add a hint for marker deletion
    const mapInstructions = document.createElement('div');
    mapInstructions.className = 'map-instructions';
    mapInstructions.innerHTML = '<p class="text-sm text-gray-600">Double-click a marker to delete it.</p>';
    document.getElementById('admin-map').parentNode.appendChild(mapInstructions);

    routingControl.on('routesfound', function (e) {
        const route = e.routes[0];
        const summary = route.summary;
        
        // Update route information in the dedicated panel
        document.getElementById('admin-distance').textContent = 
            `${(summary.totalDistance / 1000).toFixed(2)} km`;
        document.getElementById('admin-duration').textContent = 
            `${(summary.totalTime / 60).toFixed(1)} minutes`;
        
        const stopsList = document.getElementById('admin-stops');
        stopsList.innerHTML = '';
        waypoints.forEach((wp, index) => {
            const li = document.createElement('li');
            li.className = 'flex items-center space-x-2';
            li.innerHTML = `
                <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs">${index + 1}</span>
                <span>Stop ${index + 1}: (${wp.lat.toFixed(4)}, ${wp.lng.toFixed(4)})</span>
            `;
            stopsList.appendChild(li);
        });
    });
});
</script>
@endpush

@endsection 