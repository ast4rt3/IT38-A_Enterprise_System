<x-guest-layout>
    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 0.375rem;
            margin-top: 1rem;
        }
        .leaflet-container {
            z-index: 1;
        }
    </style>
    @endpush

    <form method="POST" action="{{ route('register') }}" class="mt-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- First Name -->
            <div>
                <x-input-label for="first_name" :value="__('First Name')" />
                <x-text-input id="first_name" class="mt-1 block w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="given-name" />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>

            <!-- Last Name -->
            <div>
                <x-input-label for="last_name" :value="__('Last Name')" />
                <x-text-input id="last_name" class="mt-1 block w-full" type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name" />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>

            <!-- Suffix -->
            <div>
                <x-input-label for="suffix" :value="__('Suffix (Optional)')" />
                <select id="suffix" name="suffix" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">Select Suffix</option>
                    <option value="Jr" {{ old('suffix') == 'Jr' ? 'selected' : '' }}>Jr.</option>
                    <option value="Sr" {{ old('suffix') == 'Sr' ? 'selected' : '' }}>Sr.</option>
                    <option value="II" {{ old('suffix') == 'II' ? 'selected' : '' }}>II</option>
                    <option value="III" {{ old('suffix') == 'III' ? 'selected' : '' }}>III</option>
                </select>
                <x-input-error :messages="$errors->get('suffix')" class="mt-2" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Phone -->
            <div>
                <x-input-label for="phone" :value="__('Phone Number')" />
                <x-text-input id="phone" class="mt-1 block w-full" type="tel" name="phone" :value="old('phone')" required autocomplete="tel" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <!-- Region -->
            <div>
                <x-input-label for="region" :value="__('Region')" />
                <select id="region" name="region" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="">Select Region</option>
                </select>
                <x-input-error :messages="$errors->get('region')" class="mt-2" />
            </div>

            <!-- Province -->
            <div>
                <x-input-label for="province" :value="__('Province')" />
                <select id="province" name="province" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="">Select Province</option>
                </select>
                <x-input-error :messages="$errors->get('province')" class="mt-2" />
            </div>

            <!-- City -->
            <div>
                <x-input-label for="city" :value="__('City / Municipality')" />
                <select id="city" name="city" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="">Select City</option>
                </select>
                <x-input-error :messages="$errors->get('city')" class="mt-2" />
            </div>

            <div class="col-span-1 md:col-span-2">
                <p class="text-sm text-gray-700 mb-2">{{ __('Are you registering as a driver?') }}</p>
                <a href="{{ route('register.driver') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                    {{ __('Register as Driver') }}
                </a>
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="mt-1 block w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Location Selection -->
            <div class="col-span-1 md:col-span-2">
                <x-input-label :value="__('Select Your Location')" />
                <div id="map"></div>
                <input type="hidden" id="latitude" name="latitude" required>
                <input type="hidden" id="longitude" name="longitude" required>
                <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize map
            const map = L.map('map').setView([14.5995, 120.9842], 13); // Manila coordinates
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            let marker;
            let userMarker;
            let checkpoints = [];

            // Function to get coordinates from address
            async function getCoordinates(region, province, city) {
                const address = `${city}, ${province}, ${region}, Philippines`;
                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`);
                    const data = await response.json();
                    if (data && data[0]) {
                        return {
                            lat: parseFloat(data[0].lat),
                            lng: parseFloat(data[0].lon)
                        };
                    }
                } catch (error) {
                    console.error('Error getting coordinates:', error);
                }
                return null;
            }

            // Function to get nearby checkpoints
            async function getNearbyCheckpoints(lat, lng) {
                // Clear existing checkpoints
                checkpoints.forEach(marker => map.removeLayer(marker));
                checkpoints = [];

                // In a real application, this would be an API call to your backend
                // For now, we'll create some dummy checkpoints around the user's location
                const dummyCheckpoints = [
                    { lat: lat + 0.01, lng: lng + 0.01, name: 'Checkpoint 1' },
                    { lat: lat - 0.01, lng: lng - 0.01, name: 'Checkpoint 2' },
                    { lat: lat + 0.01, lng: lng - 0.01, name: 'Checkpoint 3' },
                    { lat: lat - 0.01, lng: lng + 0.01, name: 'Checkpoint 4' }
                ];

                // Add checkpoints to map
                dummyCheckpoints.forEach(point => {
                    const checkpointMarker = L.marker([point.lat, point.lng])
                        .addTo(map)
                        .bindPopup(`<b>${point.name}</b>`);
                    checkpoints.push(checkpointMarker);
                });

                // Fit map to show all markers
                const bounds = L.latLngBounds([
                    [lat, lng],
                    ...dummyCheckpoints.map(p => [p.lat, p.lng])
                ]);
                map.fitBounds(bounds, { padding: [50, 50] });
            }

            // Handle location selection when region/province/city changes
            async function updateLocation() {
                const region = document.getElementById('region').value;
                const province = document.getElementById('province').value;
                const city = document.getElementById('city').value;

                if (region && province && city) {
                    const coords = await getCoordinates(region, province, city);
                    if (coords) {
                        // Update user marker
                        if (userMarker) {
                            map.removeLayer(userMarker);
                        }
                        userMarker = L.marker([coords.lat, coords.lng])
                            .addTo(map)
                            .bindPopup('Your Location')
                            .openPopup();

                        // Update hidden inputs
                        document.getElementById('latitude').value = coords.lat;
                        document.getElementById('longitude').value = coords.lng;

                        // Get nearby checkpoints
                        await getNearbyCheckpoints(coords.lat, coords.lng);
                    }
                }
            }

            // Add event listeners for location changes
            document.getElementById('region').addEventListener('change', updateLocation);
            document.getElementById('province').addEventListener('change', updateLocation);
            document.getElementById('city').addEventListener('change', updateLocation);

            // Add click handler for manual location selection
            map.on('click', function(e) {
                if (userMarker) {
                    map.removeLayer(userMarker);
                }
                userMarker = L.marker(e.latlng)
                    .addTo(map)
                    .bindPopup('Your Location')
                    .openPopup();
                document.getElementById('latitude').value = e.latlng.lat;
                document.getElementById('longitude').value = e.latlng.lng;
                getNearbyCheckpoints(e.latlng.lat, e.latlng.lng);
            });
        });
    </script>
    @endpush
</x-guest-layout>
