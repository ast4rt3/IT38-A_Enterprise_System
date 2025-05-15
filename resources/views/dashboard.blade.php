<x-app-layout>

    <!-- Header with White Background -->
    <div class="flex items-center space-x-2 bg-white py-6 px-4">
                    <h1 style="font-size: 3rem; font-weight: 800;color:#895353;" class="text-[#895353] mb-2">
                    {{ __('Smart Waste Pick-Up') }}
                    </h1>
    </div>

    <div class="py-12 bg-green-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Landing Page Section -->
            <div class="bg-white p-10 rounded-lg shadow-lg font-sans">

                <!-- Title and Subtitle -->
                <div class="text-center mb-6">
                    <h1 style="font-size: 3rem; font-weight: 800;color:#895353;" class="text-[#895353] mb-2">
                    {{ __('Smart Waste Pick-Up') }}
                    </h1>
                    <h2 style="font-size: 2rem; font-weight: 400;;color:#895353;" class="text-[#895353] mb-2">
                    {{ __('Track. Optimize. Clean.') }}
                    </h2>

                    

                </div>

                <!-- Description -->
                <div class="text-center mb-12"
                style="color:#895353;">
                    <p class="text-lg text-[#895353] leading-relaxed">
                        Welcome to the Smart Waste Management System — a digital solution that revolutionizes how waste is tracked, collected, and managed.
                        Our platform leverages real-time data, optimized routing, and smart notifications to make waste collection faster, cleaner, and more efficient.
                    </p>
                </div>

                <!-- How it Works Section -->
<div class="text-center mb-12">
    <h3 class="text-3xl font-bold text-[#895353] mb-8">
        {{ __('How it works') }}
    </h3>
    <div class="flex flex-wrap justify-center items-center gap-6">

        <!-- Step 1 -->
        <div class="max-w-xs flex flex-col items-center">
            <img src="https://static.vecteezy.com/system/resources/previews/029/156/453/non_2x/admin-business-icon-businessman-business-people-male-avatar-profile-pictures-man-in-suit-for-your-web-site-design-logo-app-ui-solid-style-illustration-design-on-white-background-eps-10-vector.jpg" alt="Step 1" class="mb-4 rounded-full" style="width: 80px; height: 80px; object-fit: cover;">
            <p class="text-lg font-semibold text-[#895353] max-w-xs">
                Admin reviews bin levels and sets routes.
            </p>
        </div>

        <!-- Arrow -->
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#895353]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </div>

        <!-- Step 2 -->
        <div class="max-w-xs flex flex-col items-center">
            <img src="https://static.vecteezy.com/system/resources/previews/029/156/453/non_2x/admin-business-icon-businessman-business-people-male-avatar-profile-pictures-man-in-suit-for-your-web-site-design-logo-app-ui-solid-style-illustration-design-on-white-background-eps-10-vector.jpg" alt="Step 2" class="mb-4 rounded-full" style="width: 80px; height: 80px; object-fit: cover;">
            <p class="text-lg font-semibold text-[#895353] max-w-xs">
                Reports and analytics are generated for admins.
            </p>
        </div>

        <!-- Arrow -->
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#895353]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </div>

        <!-- Step 3 -->
        <div class="max-w-xs flex flex-col items-center">
            <img src="https://static.vecteezy.com/system/resources/previews/029/156/453/non_2x/admin-business-icon-businessman-business-people-male-avatar-profile-pictures-man-in-suit-for-your-web-site-design-logo-app-ui-solid-style-illustration-design-on-white-background-eps-10-vector.jpg" alt="Step 3" class="mb-4 rounded-full" style="width: 80px; height: 80px; object-fit: cover;">
            <p class="text-lg font-semibold text-[#895353] max-w-xs">
                Waste bins send status data to the system.
            </p>
        </div>

        <!-- Arrow -->
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#895353]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </div>

        <!-- Step 4 -->
        <div class="max-w-xs flex flex-col items-center">
            <img src="https://static.vecteezy.com/system/resources/previews/029/156/453/non_2x/admin-business-icon-businessman-business-people-male-avatar-profile-pictures-man-in-suit-for-your-web-site-design-logo-app-ui-solid-style-illustration-design-on-white-background-eps-10-vector.jpg" alt="Step 4" class="mb-4 rounded-full" style="width: 80px; height: 80px; object-fit: cover;">
            <p class="text-lg font-semibold text-[#895353] max-w-xs">
                Drivers follow optimized paths for pickup.
            </p>
        </div>

    </div>
</div>


            </div>
        </div>

    </div>
    
</x-app-layout>
