<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <img src="https://cdn-icons-png.flaticon.com/512/4273/4273781.png" alt="Eco Icon" class="w-6 h-6">
            <h2 class="font-semibold text-xl text-green-800 leading-tight">
                {{ __('Eco Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-green-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-green-100 border border-green-300 overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-8 text-green-900 text-lg font-medium">
                    🌱 {{ __("You're logged in") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
