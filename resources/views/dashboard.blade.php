<x-app-layout>

        <!-- Header with White Background -->
        <div class="flex items-center space-x-2 bg-white py-4">
            <h2 class="font-semibold text-xl text-green-800 leading-tight">
                {{ __('SmartWaste Pickup') }}
            </h2>
        </div>


    <div class="py-12 bg-green-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Landing Page Section -->
            <div class="bg-white p-8 rounded-lg shadow-lg">

                <!-- Title and Subtitle -->
                <div class="text-center mb-1">
                     <h1 class="text-lg text-bold text-[#895353]">{{ __('Smart Waste Pick-Up') }}</h1>
                     <p class="text-3xl font-semibold text-[#895353]">{{ __('Track. Optimize. Clean.') }}</p>
                    </div>


                <!-- Description -->
                <div class="text-center mb-12">
                    <p class="text-lg text-[#895353]">
                        Welcome to the Smart Waste Management System — a digital solution that revolutionizes how waste is tracked, collected, and managed. 
                        Our platform leverages real-time data, optimized routing, and smart notifications to make waste collection faster, cleaner, and more efficient.
                    </p>
                </div>

                <!-- How it Works Section -->
                <div class="text-center mb-12">
                    <h3 class="text-2xl font-bold text-[#895353] mb-4">{{ __('How it works') }}</h3>
                    <div class="flex justify-center space-x-8">
                        <!-- Step 1: Admin reviews -->
                        <div class="text-center">
                            <img src="https://via.placeholder.com/80" alt="Step 1" class="mx-auto mb-4">
                            <p class="text-lg text-[#895353] font-semibold">Admin reviews bin levels and sets routes.</p>
                        </div>
                        <!-- Step 2: Reports -->
                        <div class="text-center">
                            <img src="https://via.placeholder.com/80" alt="Step 2" class="mx-auto mb-4">
                            <p class="text-lg text-[#895353] font-semibold">Reports and analytics are generated for admins.</p>
                        </div>
                        <!-- Step 3: Waste bins -->
                        <div class="text-center">
                            <img src="https://via.placeholder.com/80" alt="Step 3" class="mx-auto mb-4">
                            <p class="text-lg text-[#895353] font-semibold">Waste bins send status data to the system.</p>
                        </div>
                        <!-- Step 4: Drivers -->
                        <div class="text-center">
                            <img src="https://via.placeholder.com/80" alt="Step 4" class="mx-auto mb-4">
                            <p class="text-lg text-[#895353] font-semibold">Drivers follow optimized paths for pickup.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
