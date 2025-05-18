@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
<style>
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
                    <h1 class="text-2xl font-bold text-green-600">Driver Dashboard</h1>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Map -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Current Route</h3>
                </div>
                <div class="relative h-96 bg-gray-100 rounded-b-xl overflow-hidden">
                    <div id="driver-map" style="height: 24rem; width: 100%; border-radius: 0 0 0.75rem 0.75rem;"></div>
                </div>
            </div>

            <!-- Route Information -->
            <div class="space-y-8">
                <!-- Current Route Details -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Route Details</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @if($currentRoute)
                            <div class="flex items-center space-x-4">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                    <i class="fas fa-route text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Route</p>
                                    <p class="text-lg font-semibold text-gray-800">
                                        {{ $currentRoute->start_location }} → {{ $currentRoute->end_location }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <i class="fas fa-clock text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Status</p>
                                    <p class="text-lg font-semibold text-gray-800">
                                        {{ ucfirst($currentRoute->status) }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-6">
                                <form action="{{ route('driver.routes.update-status', $currentRoute->id) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Update Status</label>
                                        <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                            <option value="in_progress" {{ $currentRoute->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="completed" {{ $currentRoute->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                                        Update Status
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">No active route assigned</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Route History -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Route History</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($completedRoutes as $route)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $route->start_location }}</div>
                                        <div class="text-sm text-gray-500">{{ $route->end_location }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $route->updated_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Completed
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
    @if($currentRoute)
    // Initialize map with current route
    const map = L.map('driver-map').setView([14.5995, 120.9842], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Demo coordinates (replace with actual route coordinates)
    const start = [14.5995, 120.9842];
    const checkpoints = [
        [14.6040, 120.9900],
        [14.6100, 120.9950],
        [14.6150, 121.0000]
    ];
    const end = [14.6200, 121.0050];

    const waypoints = [
        L.latLng(start[0], start[1]),
        ...checkpoints.map(cp => L.latLng(cp[0], cp[1])),
        L.latLng(end[0], end[1])
    ];

    const routingControl = L.Routing.control({
        waypoints: waypoints,
        routeWhileDragging: true,
        showAlternatives: false,
        lineOptions: {
            styles: [{ color: 'blue', weight: 6 }]
        },
        createMarker: function(i, wp, nWps) {
            const marker = L.marker(wp.latLng).bindPopup(`Stop ${i + 1}`);
            return marker;
        }
    }).addTo(map);
    @endif
});
</script>
@endpush

@endsection 