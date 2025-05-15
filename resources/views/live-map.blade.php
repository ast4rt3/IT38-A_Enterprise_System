@extends('layouts.app')

@section('content')
<style>
main {
    height: 100vh;  
    width: calc(100% - 300px);
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding: 10px;
}

#map, #map2 {
    height: 45vh;
    width: 200%;
    background-color: springgreen;
    border-radius: 8px;
    margin-left: 270px;
    margin-top: 30px;
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
    </main>
</div>
@endsection

@push('styles')
<link
  rel="stylesheet"
  href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
  crossorigin=""
/>
<link 
  rel="stylesheet" 
  href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css"
/>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" crossorigin=""></script>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // First map - user location
    const mapElement = document.getElementById('map');
    if (!mapElement) {
        console.error("No #map div found.");
        return;
    }

    navigator.geolocation.getCurrentPosition(
        function (position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            const map = L.map('map').setView([lat, lng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map)
                .bindPopup('You are here.')
                .openPopup();

            // Second map - routing
            const map2 = L.map('map2').setView([lat, lng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map2);

            // Define two points for routing (you can replace with dynamic points)
            const start = L.latLng(lat, lng);
            const end = L.latLng(lat + 0.02, lng + 0.02); // small offset for demo

            L.Routing.control({
                waypoints: [
                    start,
                    end
                ],
                routeWhileDragging: true,
                showAlternatives: true,
                altLineOptions: {
                    styles: [
                        {color: 'black', opacity: 0.15, weight: 9},
                        {color: 'white', opacity: 0.8, weight: 6},
                        {color: 'blue', opacity: 0.5, weight: 2}
                    ]
                }
            }).addTo(map2);

        },
        function (error) {
            alert("Geolocation error: " + error.message);
        }
    );
});
</script>
@endpush
