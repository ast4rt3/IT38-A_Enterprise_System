@extends('layouts.app')
@push('styles')
```
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
@endpush
@section('content')
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    navigator.geolocation.getCurrentPosition(function (position) {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;

        // Map for driver route
        const map2 = L.map('map2').setView([lat, lng], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map2);

        const checkpoints = [
            { name: "Bin 1", coords: [lat + 0.002, lng + 0.001] },
            { name: "Bin 2", coords: [lat + 0.004, lng + 0.002] },
            { name: "Bin 3", coords: [lat + 0.006, lng + 0.001] },
            { name: "Bin 4", coords: [lat + 0.0075, lng - 0.0015] }
        ];

        const waypoints = [
            L.latLng(lat, lng),
            ...checkpoints.map(cp => L.latLng(cp.coords[0], cp.coords[1]))
        ];

        const routingControl = L.Routing.control({
            waypoints: waypoints,
            routeWhileDragging: false,
            showAlternatives: false,
            lineOptions: {
                styles: [{ color: 'green', weight: 9 }]
            },
            createMarker: function(i, wp, nWps) {
                return L.marker(wp.latLng, { interactive: false }).bindPopup(checkpoints[i-1] ? checkpoints[i-1].name : 'Start');
            }
        }).addTo(map2);

        routingControl.on('routesfound', function (e) {
            const route = e.routes[0];
            const summary = route.summary;

            document.getElementById('distance').textContent =
                `Total distance: ${(summary.totalDistance / 1000).toFixed(2)} km`;

            document.getElementById('duration').textContent =
                `Estimated time: ${(summary.totalTime / 60).toFixed(1)} minutes`;

            const stopsList = document.getElementById('stops');
            stopsList.innerHTML = '';
            waypoints.forEach((wp, index) => {
                const li = document.createElement('li');
                li.textContent = `Stop ${index + 1}: (${wp.lat.toFixed(4)}, ${wp.lng.toFixed(4)})`;
                stopsList.appendChild(li);
            });
        });

        // Fullscreen logic
        const mapFsBtn = document.getElementById('fullscreen-map-btn');
        const mapFsOverlay = document.getElementById('map2-fullscreen');
        const exitMapFsBtn = document.getElementById('exit-fullscreen-map-btn');

        mapFsBtn?.addEventListener('click', function () {
            mapFsOverlay.classList.remove('hidden');
            setTimeout(() => map2.invalidateSize(), 200);
        });
        exitMapFsBtn?.addEventListener('click', function () {
            mapFsOverlay.classList.add('hidden');
        });
    }, function (error) {
        alert("Geolocation error: " + error.message);
    });
});
</script>
@endpush
<style>
#map2 {
    height: 32rem;
    width: 100%;
    background-color: springgreen;
    border-radius: 8px;
    margin-top: 20px;
}
.leaflet-routing-container {
    max-width: 200px;
    max-height: 400px;
    overflow-y: auto;
    background-color: rgba(255, 255, 255, 0.9);
    pointer-events: auto;
    z-index: 1000;
}
</style>
@php
    $date = \Carbon\Carbon::now()->isoFormat('dddd, MMMM D, YYYY');
@endphp

<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <h1 class="text-2xl font-bold text-green-600">SmartWaste</h1>
                </div>
            </div>
            <div class="flex items-center space-x-4 relative">
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
    <main class="w-full px-0 py-10" style="margin-left: 90px;">
        <div class="space-y-8">
            <!-- Date and Status -->
            <div class="flex justify-between items-center" >
                <h2 class="text-xl font-semibold text-gray-800">{{ $date }}</h2>
                <div class="flex items-center space-x-2">
                    <span class="h-3 w-3 bg-green-500 rounded-full"></span>
                    <span class="text-sm font-medium text-gray-600">On Duty</span>
                </div>
            </div>

            <!-- Map and Schedule -->
            <div class="grid grid-cols-4 lg:grid-cols-5 gap-2">
                <!-- Map -->
                <div class="lg:col-span-3 bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">Route Map</h3>
                    </div>
                    <div class="relative h-[32rem] bg-gray-100 rounded-b-xl overflow-hidden" id="map2-container">
                        <div id="map2" class="w-full h-full" style="min-height: 32rem; border-radius: 0 0 0.75rem 0.75rem;"></div>

                    <div class="bg-white p-4 border-t">
                        <h3 class="text-lg font-semibold text-green-700 mb-1">Route Summary</h3>
                        <p id="distance"></p>
                        <p id="duration"></p>
                        <ul id="stops" class="list-disc list-inside text-sm mt-2"></ul>
                    </div>
                </div>
                <!-- Today's Schedule -->
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Today's Schedule</h3>
                    <div class="space-y-4 max-h-[452px] overflow-y-auto">
                        <!-- Example schedule items, repeat as needed -->
                        <div class="border-l-4 border-green-500 pl-3 py-2">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-gray-800">123 Green Street</p>
                                    <p class="text-sm text-gray-500">John Smith</p>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                            </div>
                            <div class="flex items-center mt-2 text-sm text-gray-600">
                                <i class="fas fa-recycle text-blue-500 mr-2"></i>
                                <span>Recycle</span>
                                <span class="mx-2">•</span>
                                <span>8:30 AM</span>
                            </div>
                            <div class="flex justify-end mt-2 space-x-2">
                                <button class="bg-blue-600 text-white px-3 py-1 rounded text-xs flex items-center">
                                    <i class="fas fa-directions mr-1"></i> Navigate
                                </button>
                                <button class="bg-green-600 text-white px-3 py-1 rounded text-xs flex items-center">
                                    <i class="fas fa-check mr-1"></i> Mark Complete
                                </button>
                            </div>
                        </div>
                        <!-- Add more schedule items as needed -->
                    </div>
                </div>
            </div>
            <!-- Customer Details -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Current Customer Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="flex items-start">
                            <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-4">
                                <i class="fas fa-user text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-medium text-gray-800">Michael Brown</h4>
                                <p class="text-gray-600">Customer ID: #MB78945</p>
                                <p class="text-gray-600">
                                    <i class="fas fa-phone-alt mr-2 text-blue-500"></i>
                                    (555) 123-4567
                                </p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-medium text-gray-800 mb-2">Collection Notes</h4>
                            <p class="text-gray-600 text-sm">
                                Bins are located at the side of the house. Customer has requested to text before arrival. Special handling required for glass recycling.
                            </p>
                        </div>
                        <div class="flex justify-end mt-4 space-x-3">
                            <button class="bg-blue-600 text-white px-4 py-2 rounded whitespace-nowrap cursor-pointer">
                                <i class="fas fa-phone-alt mr-2"></i> Call
                            </button>
                            <button class="bg-green-600 text-white px-4 py-2 rounded whitespace-nowrap cursor-pointer">
                                <i class="fas fa-check mr-2"></i> Mark Complete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                    <!-- Driver Stats -->
<div class="w-full px-3" style="margin-left:60px;width: 80%;">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-route text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Routes</p>
                    <h4 class="text-2xl font-bold text-gray-800">12</h4>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Completed</p>
                    <h4 class="text-2xl font-bold text-gray-800">5</h4>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pending</p>
                    <h4 class="text-2xl font-bold text-gray-800">7</h4>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                    <i class="fas fa-weight text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Collected Today</p>
                    <h4 class="text-2xl font-bold text-gray-800">342 kg</h4>
                </div>
            </div>
        </div>
    </div>
</div>
    </main>
</div>
@endsection