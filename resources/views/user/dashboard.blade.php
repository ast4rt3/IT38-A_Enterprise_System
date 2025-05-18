@extends('layouts.app')

@section('content')
    {{-- Debug Alert - Fixed at top --}}
    <div id="debugAlert" class="fixed top-20 left-0 right-0 z-50 hidden">
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-4 rounded shadow-lg" role="alert">
            <div class="flex justify-between items-center">
                <p class="font-bold text-lg">Debug Information</p>
                <button onclick="document.getElementById('debugAlert').classList.add('hidden')" class="text-red-700 hover:text-red-900">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
            <p id="debugMessage" class="mt-2"></p>
        </div>
    </div>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Collection Points') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Add New Checkpoint Button --}}
            <div class="mb-8">
                <button onclick="openAddCheckpointModal()" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                    Add New Collection Point
                </button>
            </div>

            {{-- Collection Map --}}
            <div class="mb-8 bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Collection Points Map</h3>
                    <div id="map" class="h-96 rounded-lg"></div>
                </div>
            </div>

            {{-- Debug Alert --}}
            <div id="debugAlert" class="mb-4 hidden">
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                    <p class="font-bold">Debug Information</p>
                    <p id="debugMessage"></p>
                </div>
            </div>

            {{-- Checkpoints Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($checkpoints as $checkpoint)
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $checkpoint->name }}</h3>
                            <span class="px-3 py-1 text-sm rounded-full 
                                @if($checkpoint->status === 'completed') bg-green-100 text-green-800
                                @elseif($checkpoint->status === 'in_progress') bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($checkpoint->status) }}
                            </span>
                        </div>
                        
                        <div class="space-y-2 text-gray-600">
                            <p><span class="font-medium">Description:</span> {{ $checkpoint->description }}</p>
                            <p><span class="font-medium">Schedule:</span> {{ ucfirst($checkpoint->schedule) }}</p>
                            <p><span class="font-medium">Last Collection:</span> 
                                {{ $checkpoint->last_collection ? $checkpoint->last_collection->format('M d, Y') : 'Never' }}
                            </p>
                            <p><span class="font-medium">Next Collection:</span> 
                                {{ $checkpoint->next_collection ? $checkpoint->next_collection->format('M d, Y') : 'Not scheduled' }}
                            </p>
                        </div>

                        <div class="mt-4 flex space-x-3">
                            <button onclick="editCheckpoint({{ $checkpoint->id }})" 
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Edit Details
                            </button>
                            <button onclick="viewHistory({{ $checkpoint->id }})" 
                                    class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                                View History
                            </button>
                            <button onclick="focusOnMarker({{ $checkpoint->id }})" 
                                    class="text-green-600 hover:text-green-800 text-sm font-medium">
                                Show on Map
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-xl shadow-md p-8 text-center">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">No Collection Points Yet</h3>
                        <p class="text-gray-600 mb-4">Add your first collection point to start tracking waste collection.</p>
                        <button onclick="openAddCheckpointModal()" 
                                class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                            Add Collection Point
                        </button>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Add/Edit Checkpoint Modal --}}
    <div id="checkpointModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Add New Collection Point</h3>
                <form id="checkpointForm" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Location Name
                        </label>
                        <input type="text" id="name" name="name" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                            Description
                        </label>
                        <textarea id="description" name="description" required
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="schedule">
                            Collection Schedule
                        </label>
                        <select id="schedule" name="schedule" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="biweekly">Bi-weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Select Location on Map
                        </label>
                        <div id="modalMap" class="h-64 rounded-lg"></div>
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal()"
                                class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" rel="stylesheet">
    <script>
        let map, modalMap;
        let marker;
        let isAddingNewPoint = false;
        let markers = {};

        // Initialize main map
        function initMap() {
            map = L.map('map').setView([14.5995, 120.9842], 13); // Manila coordinates
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Add markers for existing checkpoints
            @foreach($checkpoints as $checkpoint)
                const popupContent = `
                    <div class="p-2">
                        <h3 class="font-bold text-lg">${@json($checkpoint->name)}</h3>
                        <p class="text-gray-600">${@json($checkpoint->description)}</p>
                        <p class="text-sm mt-2">
                            <span class="font-medium">Schedule:</span> ${@json(ucfirst($checkpoint->schedule))}<br>
                            <span class="font-medium">Status:</span> ${@json(ucfirst($checkpoint->status))}<br>
                            <span class="font-medium">Last Collection:</span> ${@json($checkpoint->last_collection ? $checkpoint->last_collection->format('M d, Y') : 'Never')}<br>
                            <span class="font-medium">Next Collection:</span> ${@json($checkpoint->next_collection ? $checkpoint->next_collection->format('M d, Y') : 'Not scheduled')}
                        </p>
                    </div>
                `;
                
                markers[@json($checkpoint->id)] = L.marker([@json($checkpoint->latitude), @json($checkpoint->longitude)])
                    .addTo(map)
                    .bindPopup(popupContent);
            @endforeach
        }

        // Initialize modal map
        function initModalMap() {
            modalMap = L.map('modalMap').setView([14.5995, 120.9842], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(modalMap);

            // Add click handler for adding new points
            modalMap.on('click', function(e) {
                if (isAddingNewPoint) {
                    if (marker) {
                        modalMap.removeLayer(marker);
                    }
                    marker = L.marker(e.latlng).addTo(modalMap);
                    document.getElementById('latitude').value = e.latlng.lat;
                    document.getElementById('longitude').value = e.latlng.lng;
                }
            });
        }

        function focusOnMarker(checkpointId) {
            if (markers[checkpointId]) {
                map.setView(markers[checkpointId].getLatLng(), 15);
                markers[checkpointId].openPopup();
            }
        }

        function openAddCheckpointModal() {
            document.getElementById('modalTitle').textContent = 'Add New Collection Point';
            document.getElementById('checkpointForm').reset();
            document.getElementById('checkpointModal').classList.remove('hidden');
            isAddingNewPoint = true;
            
            // Initialize modal map if not already initialized
            if (!modalMap) {
                setTimeout(initModalMap, 100);
            }
        }

        function editCheckpoint(id) {
            document.getElementById('modalTitle').textContent = 'Edit Collection Point';
            // Fetch checkpoint data and populate form
            document.getElementById('checkpointModal').classList.remove('hidden');
            isAddingNewPoint = false;
        }

        function viewHistory(id) {
            // Implement history view
        }

        function closeModal() {
            document.getElementById('checkpointModal').classList.add('hidden');
            if (marker) {
                modalMap.removeLayer(marker);
                marker = null;
            }
            isAddingNewPoint = false;
        }

        function showDebugInfo(title, data) {
            const debugAlert = document.getElementById('debugAlert');
            const debugMessage = document.getElementById('debugMessage');
            
            // Make sure the debug alert is visible
            debugAlert.classList.remove('hidden');
            
            // Format the data for display
            let formattedData = data;
            if (typeof data === 'object') {
                formattedData = JSON.stringify(data, null, 2);
            }
            
            // Update the debug message with timestamp
            const timestamp = new Date().toLocaleTimeString();
            debugMessage.innerHTML = `
                <div class="text-sm text-gray-500 mb-2">[${timestamp}]</div>
                <strong>${title}</strong><br>
                <pre class="mt-2 p-2 bg-gray-100 rounded overflow-x-auto">${formattedData}</pre>
            `;
        }

        // Initialize everything when the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the main map
            initMap();

            // Set up form submission handler
            const form = document.getElementById('checkpointForm');
            if (form) {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    try {
                        const formData = new FormData(this);
                        const data = Object.fromEntries(formData);
                        
                        // Debug: Show the data being sent
                        console.log('Sending data:', data);
                        showDebugInfo('Sending data:', data);
                        
                        const response = await fetch('/checkpoints', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(data)
                        });

                        // Debug: Show response status
                        console.log('Response status:', response.status);
                        showDebugInfo('Response status:', response.status);
                        
                        const responseData = await response.json();
                        
                        // Debug: Show response data
                        console.log('Response data:', responseData);
                        showDebugInfo('Response data:', responseData);
                        
                        if (responseData.success) {
                            console.log('Success! Reloading page...');
                            showDebugInfo('Success! Reloading page...');
                            // Close modal before reloading
                            closeModal();
                            // Add a small delay before reloading to show the success message
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            console.error('Error:', responseData.message || 'Unknown error occurred');
                            showDebugInfo('Error:', responseData.message || 'Unknown error occurred');
                            alert('Error: ' + (responseData.message || 'Unknown error occurred'));
                        }
                    } catch (error) {
                        // Debug: Show error details
                        console.error('Error details:', error);
                        showDebugInfo('Error details:', error);
                        alert('An error occurred while saving the collection point. Check the debug information for details.');
                    }
                });
            } else {
                console.error('Form element not found!');
            }
        });
    </script>
    @endpush
@endsection