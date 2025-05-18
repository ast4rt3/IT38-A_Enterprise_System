@extends('layouts.app')

@section('content')
<style>
main {
    height: 200vh;  
    width: calc(100% - 300px);
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding: 10px;
}

#map, #map2 {
    height: 300%;
    width: 200%;
    background-color: springgreen;
    border-radius: 8px;
    margin-left: 20px;
    margin-top: 80px;
}
/* Limit or hide the routing alternatives panel */
.leaflet-routing-container {
    max-width: 300px;       /* Restrict its size */
    max-height: 400px;
    overflow-y: auto;
    background-color: rgba(255, 255, 255, 0.9); /* optional */
    pointer-events: auto;
    z-index: 1000;
}

/* OPTIONAL: If you want to remove it completely */
.leaflet-routing-alternatives-container {
    
}

</style>

<div class="flex h-screen w-full bg-green-50">

    {{-- User Info Panel --}}
    <aside class="w-[300px] bg-white p-9 shadow-lg flex flex-col gap-6">
        <h2 class="text-2xl font-semibold text-green-700 mb-4">User Information</h2>

        <div>
            <p><strong>Name:</strong> {{ auth()->user()->first_name }} {{ auth()->user()->last_name }} {{ auth()->user()->suffix }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
            <p><strong>Phone:</strong> {{ auth()->user()->phone }}</p>
        </div>

        <div>
            <h3 class="text-lg font-semibold mt-4">Account Details</h3>
            <p><strong>ID:</strong> {{ auth()->user()->id}}</p>
            <p><strong>Role:</strong> {{ auth()->user()->role ?? 'Driver' }}</p>
            <p><strong>License:</strong> {{ auth()->user()->license }}</p>
            <p><strong>Member since:</strong> {{ auth()->user()->created_at->format('M d, Y') }}</p>
        </div>

        <div>
            <h3 class="text-lg font-semibold mt-4">User Location</h3>
            <p><strong>Location:</strong> {{ auth()->user()->city }}, {{ auth()->user()->province }}, {{ auth()->user()->region }}</p>
        </div>
    </aside>

    {{-- Map Area --}}
<main class="flex-1">
    <div id="map"></div>
    <div id="map2"></div>
    <div id="map2-info" class="mt-4 ml-[270px] bg-white rounded shadow p-4 w-[80%]">
        <h3 class="text-lg font-semibold text-green-700 mb-1">Route Summary</h3>
        <p id="distance"></p>
        <p id="duration"></p>
        <ul id="stops" class="list-disc list-inside text-sm mt-2"></ul>
    </div>
</main>




</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
<style>
.leaflet-routing-container {
    max-width: 300px;
    max-height: 400px;
    overflow-y: auto;
    background-color: rgba(255, 255, 255, 0.9);
    pointer-events: auto;
    z-index: 1000;
}
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    navigator.geolocation.getCurrentPosition(function (position) {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;

        // First Map - User's Location
        const map = L.map('map').setView([lat, lng], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker([lat, lng])
            .addTo(map)
            .bindPopup('You are here')
            .openPopup();

        // Checkpoints (bin locations)
        const checkpoints = [
            { name: "Bin 1", coords: [lat + 0.002, lng + 0.001] },
            { name: "Bin 2", coords: [lat + 0.004, lng + 0.002] },
            { name: "Bin 3", coords: [lat + 0.006, lng + 0.001] },
            { name: "Bin 4", coords: [lat + 0.0075, lng - 0.0015] }
        ];

        checkpoints.forEach(cp => {
            L.marker(cp.coords).addTo(map).bindPopup(`${cp.name}<br>Status: Pending`);
        });

        // Second Map - Routing with Checkpoints
        const map2 = L.map('map2').setView([lat, lng], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map2);

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
            // Remove waypoint
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
    stopsList.innerHTML = ''; // Clear previous
    waypoints.forEach((wp, index) => {
        const li = document.createElement('li');
        li.textContent = `Stop ${index + 1}: (${wp.lat.toFixed(4)}, ${wp.lng.toFixed(4)})`;
        stopsList.appendChild(li);
    });
});


    }, function (error) {
        alert("Geolocation error: " + error.message);
    });
});
</script>
@endpush
