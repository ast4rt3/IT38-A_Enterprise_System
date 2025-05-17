<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SmartWaste') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-b from-green-100 to-green-50 text-gray-800">
    <div class="min-h-screen flex flex-col items-center justify-center py-6 px-4 sm:px-6 lg:px-8">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-green-600" />
            </a>
        </div>

        <div class="w-full max-w-md mt-6 px-6 py-8 bg-white shadow-lg rounded-2xl">
            {{ $slot }}
        </div>
    </div>

    <footer class="mt-12 border-t pt-6 text-sm text-gray-600 bg-white w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:justify-between items-center space-y-4 md:space-y-0 text-center">
                <div class="md:text-left w-full md:w-1/3">
                    <strong>Smart Waste Management System</strong><br>
                    Making Cities Cleaner & Greener
                </div>

                <div class="w-full md:w-1/3">
                    <p>Contact Us: <a href="mailto:support@smartwaste.com" class="text-indigo-600 hover:underline">support@smartwaste.com</a> | +63 000 000 0000</p>
                </div>

                <div class="md:text-right w-full md:w-1/3">
                    <a href="#" class="hover:underline mr-2">Privacy Policy</a> |
                    <a href="#" class="hover:underline mx-2">Terms of Service</a> |
                    <a href="#" class="hover:underline ml-2">Reports</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
