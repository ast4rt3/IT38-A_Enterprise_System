@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
<style>
    .leaflet-routing-container {
        display: none !important;
    }
    #map {
        height: 400px;
        width: 100%;
        border-radius: 0.5rem;
    }
    .map-container {
        position: relative;
    }
    .map-instructions {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 1000;
        background: white;
        padding: 10px;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
</style>
@endpush

@section('content')
<div class="w-full mx-auto px-12 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">Create New Route</h2>

        @if(session('success'))
            <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-200">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-4 p-4 rounded bg-red-100 text-red-800 border border-red-200">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.routes.store') }}" method="POST" id="routeForm">
            @csrf
            
            <div class="mb-6">
                <div class="map-container mb-4">
                    <div class="map-instructions">
                        <p class="text-sm text-gray-600">Click on the map to add stops. First is start, last is end. Drag to adjust. Double-click a marker to remove it.</p>
                    </div>
                    <div id="map"></div>
                </div>
            </div>

            <input type="hidden" name="start_location" id="start_location" required>
            <input type="hidden" name="end_location" id="end_location" required>
            <input type="hidden" name="start_lat" id="start_lat" required>
            <input type="hidden" name="start_lng" id="start_lng" required>
            <input type="hidden" name="end_lat" id="end_lat" required>
            <input type="hidden" name="end_lng" id="end_lng" required>
            <input type="hidden" name="waypoints" id="waypoints_input" required>

            <div class="mt-4">
                <label for="driver_id" class="block text-sm font-medium text-gray-700">Assign to Driver <span class="text-red-500">*</span></label>
                @if($drivers->count() > 0)
                    <select name="driver_id" id="driver_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="">-- Select Driver --</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}">{{ $driver->first_name }} {{ $driver->last_name }}</option>
                        @endforeach
                    </select>
                @else
                    <div class="text-red-500 text-sm mt-2">No drivers found. Please add drivers first.</div>
                @endif
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <a href="{{ route('admin.dashboard') }}" 
                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Create Route
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const map = L.map('map').setView([14.5995, 120.9842], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    let markers = [];
    let polyline = null;
    let routingControl = null;

    function updatePolyline() {
        if (polyline) map.removeLayer(polyline);
        if (routingControl) map.removeControl(routingControl);
        if (markers.length >= 2) {
            const latlngs = markers.map(m => m.getLatLng());
            routingControl = L.Routing.control({
                waypoints: latlngs,
                routeWhileDragging: false,
                showAlternatives: false,
                addWaypoints: false,
                draggableWaypoints: false,
                lineOptions: { styles: [{ color: 'blue', weight: 6 }] },
                createMarker: function() { return null; }
            }).addTo(map);
        }
    }

    function updateHiddenFields() {
        if (markers.length >= 2) {
            const start = markers[0].getLatLng();
            const end = markers[markers.length - 1].getLatLng();
            document.getElementById('start_lat').value = start.lat;
            document.getElementById('start_lng').value = start.lng;
            document.getElementById('end_lat').value = end.lat;
            document.getElementById('end_lng').value = end.lng;
            // Reverse geocode start
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${start.lat}&lon=${start.lng}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('start_location').value = data.display_name;
                });
            // Reverse geocode end
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${end.lat}&lon=${end.lng}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('end_location').value = data.display_name;
                });
            // Save all waypoints
            const waypoints = markers.map(m => m.getLatLng());
            document.getElementById('waypoints_input').value = JSON.stringify(waypoints);
        }
    }

    map.on('click', function(e) {
        const marker = L.marker(e.latlng, { draggable: true }).addTo(map);
        markers.push(marker);
        marker.on('drag', function() {
            updatePolyline();
            updateHiddenFields();
        });
        marker.on('dblclick', function() {
            map.removeLayer(marker);
            markers = markers.filter(m => m !== marker);
            updatePolyline();
            updateHiddenFields();
        });
        updatePolyline();
        updateHiddenFields();
    });

    document.getElementById('routeForm').addEventListener('submit', function(e) {
        if (markers.length < 2) {
            e.preventDefault();
            alert('Please add at least a start and end point on the map.');
        } else {
            // Convert waypoints to array of objects for backend
            const waypoints = markers.map(m => m.getLatLng());
            document.getElementById('waypoints_input').value = JSON.stringify(waypoints);
        }
    });
});
</script>
@endpush

@endsection 