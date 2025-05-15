@section('content')
<style>
    #map {
        height: 100vh;
        width: 100%;
    }
</style>

<div class="flex h-screen w-full">
    {{-- Sidebar --}}
    <div class="w-[70px] bg-green-300 p-2 flex flex-col items-center">
        <h1 class="text-[10px] text-center mt-2 rotate-90 whitespace-nowrap">Live Map View</h1>
        <!-- Icons -->
    </div>

    {{-- Map Area --}}
    <div class="flex-1 bg-green-50">
        <div id="map"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
            },
            function (error) {
                alert("Geolocation error: " + error.message);
            }
        );
    });
</script>
@endpush
