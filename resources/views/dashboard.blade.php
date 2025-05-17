@extends('layouts.app')
@push('styles')
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

        // Second Map - Routing with Checkpoints
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
                const marker = L.marker(wp.latLng).bindPopup(`Stop ${i + 1}`);
                marker.on('click', function () {
                    if (confirm(`Remove Stop ${i + 1}?`)) {
                        const newWaypoints = routingControl.getWaypoints().filter((w, index) => index !== i);
                        routingControl.setWaypoints(newWaypoints);
                    }
                });
                return marker;
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
    }, function (error) {
        alert("Geolocation error: " + error.message);
    });

    // Map Fullscreen logic
    const mapFsBtn = document.getElementById('fullscreen-map-btn');
    const mapFsOverlay = document.getElementById('map2-fullscreen');
    const exitMapFsBtn = document.getElementById('exit-fullscreen-map-btn');

    mapFsBtn?.addEventListener('click', function () {
        mapFsOverlay.classList.remove('hidden');
    });
    exitMapFsBtn?.addEventListener('click', function () {
        mapFsOverlay.classList.add('hidden');
    });

    // Fullscreen logic for Request Collection
    const reqFsBtn = document.getElementById('fullscreen-request-btn');
    const reqFsOverlay = document.getElementById('request-fullscreen');
    const exitReqFsBtn = document.getElementById('exit-fullscreen-request-btn');

    reqFsBtn?.addEventListener('click', function () {
        reqFsOverlay.classList.remove('hidden');
        document.getElementById('distance-fs').textContent = document.getElementById('distance').textContent;
        document.getElementById('duration-fs').textContent = document.getElementById('duration').textContent;
        document.getElementById('stops-fs').innerHTML = document.getElementById('stops').innerHTML;
    });

    exitReqFsBtn?.addEventListener('click', function () {
        reqFsOverlay.classList.add('hidden');
    });
});
</script>
@endpush
<style>
#map, #map2 {
    height: 300%;
    width: 80%;
    background-color: springgreen;
    border-radius: 8px;
    margin-left: 20px;
    margin-top: 80px;
    align-items: center;
}
.leaflet-routing-container {
    max-width: 200px;
    max-height: 400px;
    overflow-y: auto;
    background-color: rgba(255, 255, 255, 0.9);
    pointer-events: auto;
    z-index: 1000;
}
.leaflet-routing-alternatives-container {}
</style>
@php
    $role = request('role', 'user');
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
            <div class="bg-gray-100 rounded-full p-1 flex">
                <a href="?role=user" class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap cursor-pointer {{ $role === 'user' ? 'bg-green-500 text-white' : 'text-gray-700' }}">
                    Driver
                </a>
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
    <main class="w-full px-0 py-10" style="margin-left: 150px;">
        @if($role === 'user')
        <div class="space-y-8">
            <!-- Hero Section ... (keep your hero and status sections as is) ... -->

            <!-- Map and Request Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Map -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm">
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Route Map</h3>
                    </div>
                    <div class="relative h-[32rem] bg-gray-100 rounded-b-xl overflow-hidden" id="map2-container">
                        <div id="map2" class="w-full h-full" style="min-height: 32rem; border-radius: 0 0 0.75rem 0.75rem;"></div>
                        <!-- Fullscreen overlay (hidden by default) -->
                        <div id="map2-fullscreen" class="fixed inset-0 bg-white z-50 hidden flex flex-col">
                            <div class="flex justify-between items-center p-4 border-b">
                                <h3 class="text-lg font-semibold text-gray-800">Route Map (Fullscreen)</h3>
                                <button id="exit-fullscreen-map-btn" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded whitespace-nowrap cursor-pointer flex items-center">
                                    <i class="fas fa-compress mr-1"></i> Exit Fullscreen
                                </button>
                            </div>
                            <div class="flex-1 relative bg-gray-100">
                                <div id="map2-fs" class="absolute inset-0 w-full h-full" style="min-height: 100vh;"></div>
                            </div>
                            <div class="bg-white p-4 border-t">
                                <h3 class="text-lg font-semibold text-green-700 mb-1">Route Summary</h3>
                                <p id="distance-fs"></p>
                                <p id="duration-fs"></p>
                                <ul id="stops-fs" class="list-disc list-inside text-sm mt-2"></ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Request Collection -->
                <div class="bg-white rounded-xl shadow-sm p-6 relative">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Request Collection</h3>
                        <button id="fullscreen-request-btn" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded whitespace-nowrap cursor-pointer flex items-center">
                            <i class="fas fa-expand mr-1"></i> Fullscreen
                        </button>
                    </div>
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Waste Type</label>
                            <div class="grid grid-cols-2 gap-3">
                                <button type="button" class="flex items-center justify-center p-3 rounded-lg border border-green-500 bg-green-50 cursor-pointer">
                                    <i class="fas fa-trash-alt mr-2 text-green-600"></i>
                                    <span class="font-medium">General</span>
                                </button>
                                <button type="button" class="flex items-center justify-center p-3 rounded-lg border border-blue-500 bg-blue-50 cursor-pointer">
                                    <i class="fas fa-recycle mr-2 text-blue-600"></i>
                                    <span class="font-medium">Recycle</span>
                                </button>
                                <button type="button" class="flex items-center justify-center p-3 rounded-lg border border-yellow-500 bg-yellow-50 cursor-pointer">
                                    <i class="fas fa-leaf mr-2 text-yellow-600"></i>
                                    <span class="font-medium">Organic</span>
                                </button>
                                <button type="button" class="flex items-center justify-center p-3 rounded-lg border border-red-500 bg-red-50 cursor-pointer">
                                    <i class="fas fa-radiation-alt mr-2 text-red-600"></i>
                                    <span class="font-medium">Hazardous</span>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pickup Date</label>
                            <input type="date" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 text-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pickup Time</label>
                            <div class="relative">
                                <select class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 text-sm appearance-none cursor-pointer">
                                    <option>Morning (8:00 AM - 12:00 PM)</option>
                                    <option>Afternoon (12:00 PM - 4:00 PM)</option>
                                    <option>Evening (4:00 PM - 8:00 PM)</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-medium hover:bg-green-700 transition-colors whitespace-nowrap cursor-pointer">
                            Request Pickup
                        </button>
                    </form>
                    <p id="distance"></p>
                    <p id="duration"></p>
                    <ul id="stops" class="list-disc list-inside text-sm mt-2"></ul>
                </div>
                <!-- Fullscreen overlay for Request Collection (hidden by default) -->
                <div id="request-fullscreen" class="fixed inset-0 bg-white z-50 hidden flex flex-col">
                    <div class="flex justify-between items-center p-4 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Request Collection (Fullscreen)</h3>
                        <button id="exit-fullscreen-request-btn" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded whitespace-nowrap cursor-pointer flex items-center">
                            <i class="fas fa-compress mr-1"></i> Exit Fullscreen
                        </button>
                    </div>
                    <div class="flex-1 overflow-y-auto p-6">
                        <form class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Waste Type</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <button type="button" class="flex items-center justify-center p-3 rounded-lg border border-green-500 bg-green-50 cursor-pointer">
                                        <i class="fas fa-trash-alt mr-2 text-green-600"></i>
                                        <span class="font-medium">General</span>
                                    </button>
                                    <button type="button" class="flex items-center justify-center p-3 rounded-lg border border-blue-500 bg-blue-50 cursor-pointer">
                                        <i class="fas fa-recycle mr-2 text-blue-600"></i>
                                        <span class="font-medium">Recycle</span>
                                    </button>
                                    <button type="button" class="flex items-center justify-center p-3 rounded-lg border border-yellow-500 bg-yellow-50 cursor-pointer">
                                        <i class="fas fa-leaf mr-2 text-yellow-600"></i>
                                        <span class="font-medium">Organic</span>
                                    </button>
                                    <button type="button" class="flex items-center justify-center p-3 rounded-lg border border-red-500 bg-red-50 cursor-pointer">
                                        <i class="fas fa-radiation-alt mr-2 text-red-600"></i>
                                        <span class="font-medium">Hazardous</span>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pickup Date</label>
                                <input type="date" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 text-sm" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pickup Time</label>
                                <div class="relative">
                                    <select class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 text-sm appearance-none cursor-pointer">
                                        <option>Morning (8:00 AM - 12:00 PM)</option>
                                        <option>Afternoon (12:00 PM - 4:00 PM)</option>
                                        <option>Evening (4:00 PM - 8:00 PM)</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-medium hover:bg-green-700 transition-colors whitespace-nowrap cursor-pointer">
                                Request Pickup
                            </button>
                        </form>
                        <p id="distance-fs"></p>
                        <p id="duration-fs"></p>
                        <ul id="stops-fs" class="list-disc list-inside text-sm mt-2"></ul>
                    </div>
                </div>
            </div>   
                    <!-- Request Collection -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Request Collection</h3>
                        <form class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Waste Type</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <button type="button" class="flex items-center justify-center p-3 rounded-lg border border-green-500 bg-green-50 cursor-pointer">
                                        <i class="fas fa-trash-alt mr-2 text-green-600"></i>
                                        <span class="font-medium">General</span>
                                    </button>
                                    <button type="button" class="flex items-center justify-center p-3 rounded-lg border border-blue-500 bg-blue-50 cursor-pointer">
                                        <i class="fas fa-recycle mr-2 text-blue-600"></i>
                                        <span class="font-medium">Recycle</span>
                                    </button>
                                    <button type="button" class="flex items-center justify-center p-3 rounded-lg border border-yellow-500 bg-yellow-50 cursor-pointer">
                                        <i class="fas fa-leaf mr-2 text-yellow-600"></i>
                                        <span class="font-medium">Organic</span>
                                    </button>
                                    <button type="button" class="flex items-center justify-center p-3 rounded-lg border border-red-500 bg-red-50 cursor-pointer">
                                        <i class="fas fa-radiation-alt mr-2 text-red-600"></i>
                                        <span class="font-medium">Hazardous</span>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pickup Date</label>
                                <input type="date" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 text-sm" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pickup Time</label>
                                <div class="relative">
                                    <select class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 text-sm appearance-none cursor-pointer">
                                        <option>Morning (8:00 AM - 12:00 PM)</option>
                                        <option>Afternoon (12:00 PM - 4:00 PM)</option>
                                        <option>Evening (4:00 PM - 8:00 PM)</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-medium hover:bg-green-700 transition-colors whitespace-nowrap cursor-pointer">
                                Request Pickup
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Collection History -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Collections</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Weight</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Receipt</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">May 15, 2025</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fas fa-recycle text-blue-500 mr-2"></i>
                                            <span class="text-sm text-gray-900">Recycle</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">4.2 kg</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <button class="text-blue-600 hover:text-blue-800 cursor-pointer">
                                            <i class="fas fa-download"></i> Download
                                        </button>
                                    </td>
                                </tr>
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            {{-- Driver Dashboard --}}
            <div class="space-y-8">
                <!-- Date and Status -->
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $date }}</h2>
                    <div class="flex items-center space-x-2">
                        <span class="h-3 w-3 bg-green-500 rounded-full"></span>
                        <span class="text-sm font-medium text-gray-600">On Duty</span>
                    </div>
                </div>
                <!-- Driver Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
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
                <!-- Map and Schedule -->
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <!-- Map -->
                    <div class="lg:col-span-3 bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="p-4 border-b border-gray-100 flex justify-between items-center">
    <h3 class="text-lg font-semibold text-gray-800">Route Map</h3>
    <button id="fullscreen-map-btn" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded whitespace-nowrap cursor-pointer flex items-center">
        <i class="fas fa-expand mr-1"></i> Fullscreen
    </button>
</div>
                                <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded whitespace-nowrap cursor-pointer">
                                    <i class="fas fa-directions mr-1"></i> Navigate
                                </button>
                            </div>
                        </div>
                        <div class="relative h-[500px] bg-gray-100">
                            <img src="https://readdy.ai/api/search-image?query=Detailed%20city%20map%20view%20showing%20streets%2C%20buildings%2C%20and%20optimized%20route%20for%20waste%20collection%20trucks%20with%20turn-by-turn%20navigation%2C%20highlighted%20collection%20points%2C%20and%20status%20indicators%2C%20professional%20UI%20design%20with%20clean%20layout&width=900&height=500&seq=3&orientation=landscape"
                                alt="Driver route map"
                                class="w-full h-full object-cover object-top" />
                            <div class="absolute bottom-4 right-4 bg-white rounded-lg shadow-md p-3">
                                <div class="flex items-center space-x-4">
                                    <button class="text-gray-600 hover:text-gray-900 cursor-pointer">
                                        <i class="fas fa-plus-circle text-xl"></i>
                                    </button>
                                    <button class="text-gray-600 hover:text-gray-900 cursor-pointer">
                                        <i class="fas fa-minus-circle text-xl"></i>
                                    </button>
                                    <button class="text-gray-600 hover:text-gray-900 cursor-pointer">
                                        <i class="fas fa-location-arrow text-xl"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Schedule -->
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Todays Schedule</h3>
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
        @endif
    </main>
   
</div>
@endsection