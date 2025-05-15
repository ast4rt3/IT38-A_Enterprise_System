<x-app-layout>

  <!-- Header -->
  <div class="flex items-center justify-center bg-white py-6 border-b border-green-300 shadow-sm">
    <h2 class="text-3xl font-extrabold text-green-900 tracking-wider uppercase drop-shadow-md">
      {{ __('Features') }}
    </h2>
  </div>

  <div class="min-h-screen bg-gradient-to-b from-green-100 to-green-50 py-20 px-6 sm:px-12 lg:px-20">
    <div class="max-w-7xl mx-auto">

      <h1 class="text-center text-5xl font-extrabold text-green-900 mb-12 tracking-tight drop-shadow-lg">
        Smart Waste Management System
      </h1>
      <p class="max-w-3xl mx-auto text-center text-xl text-green-800 mb-16 leading-relaxed font-light">
        Revolutionize waste collection with real-time bin monitoring, optimized routes, and actionable insights for cleaner communities.
      </p>

      <!-- Card grid -->
      <div class="grid gap-12 sm:grid-cols-2 lg:grid-cols-4">

        <!-- Card 1 -->
        <div class="bg-gradient-to-tr from-green-200 via-green-300 to-green-400 rounded-3xl shadow-lg p-8 flex flex-col items-center text-center transition-transform hover:scale-105">
          <div class="bg-white rounded-full p-6 mb-6 shadow-inner">
            <svg class="h-16 w-16 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 0a2 2 0 100-4 2 2 0 000 4zm-6-8h.01M3 6h18M4 10h16M4 14h16" />
            </svg>
          </div>
          <h3 class="text-2xl font-extrabold text-green-900 mb-2 drop-shadow-sm">Real-time Bin Monitoring</h3>
          <p class="text-green-900 font-medium leading-relaxed">
            Sensors provide live fill-level data so pickups happen right on time—no overflow, no missed bins.
          </p>
        </div>

        <!-- Card 2 -->
        <div class="bg-gradient-to-tr from-green-300 via-green-400 to-green-500 rounded-3xl shadow-lg p-8 flex flex-col items-center text-center transition-transform hover:scale-105">
          <div class="bg-white rounded-full p-6 mb-6 shadow-inner">
            <svg class="h-16 w-16 text-green-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6a2 2 0 012-2h4a2 2 0 012 2v6m-6 0h6" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 11h16" />
            </svg>
          </div>
          <h3 class="text-2xl font-extrabold text-green-900 mb-2 drop-shadow-sm">Smart Route Optimization</h3>
          <p class="text-green-900 font-medium leading-relaxed">
            Data-driven routes save fuel and time while guaranteeing timely pickups every day.
          </p>
        </div>

        <!-- Card 3 -->
        <div class="bg-gradient-to-tr from-green-200 via-green-300 to-green-400 rounded-3xl shadow-lg p-8 flex flex-col items-center text-center transition-transform hover:scale-105">
          <div class="bg-white rounded-full p-6 mb-6 shadow-inner">
            <svg class="h-16 w-16 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-7 7-5-5" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h3 class="text-2xl font-extrabold text-green-900 mb-2 drop-shadow-sm">Detailed Reporting & Analytics</h3>
          <p class="text-green-900 font-medium leading-relaxed">
            Insightful reports to track pickup trends and improve waste management decisions.
          </p>
        </div>

        <!-- Card 4 -->
        <div class="bg-gradient-to-tr from-green-300 via-green-400 to-green-500 rounded-3xl shadow-lg p-8 flex flex-col items-center text-center transition-transform hover:scale-105">
          <div class="bg-white rounded-full p-6 mb-6 shadow-inner">
            <svg class="h-16 w-16 text-green-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 17l-2-2m0 0l2-2m-2 2h6m4 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h3 class="text-2xl font-extrabold text-green-900 mb-2 drop-shadow-sm">Driver-Friendly Interface</h3>
          <p class="text-green-900 font-medium leading-relaxed">
            Dynamic, easy-to-use routes help drivers stay efficient and accurate on every pickup.
          </p>
        </div>

      </div>
    </div>
  </div>

</x-app-layout>
