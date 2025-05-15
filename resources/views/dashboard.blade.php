@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-100 to-green-50 py-3 px-6 sm:px-12 lg:px-20">
  <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-2xl p-14 font-sans">

    <!-- Header -->
    <header class="text-center mb-9">
      <h1 class="text-5xl font-extrabold text-[#895353] mb-3 tracking-tight">
        {{ __('Smart Waste Pick-Up') }}
      </h1>
      <p class="text-xl text-[#895353]/90 font-semibold tracking-wide">
        {{ __('Track. Optimize. Clean.') }}
      </p>
    </header>

    <!-- Description -->
    <p class="text-center text-[#895353]/90 max-w-4xl mx-auto mb-20 leading-relaxed text-lg">
      Welcome to the Smart Waste Management System — a digital solution that revolutionizes how waste is tracked, collected, and managed.
      Our platform leverages real-time data, optimized routing, and smart notifications to make waste collection faster, cleaner, and more efficient.
    </p>

    <!-- How It Works Section -->
    <section>
      <h2 class="text-center text-3xl font-bold text-[#895353] mb-12">
        {{ __('How it works') }}
      </h2>

      <div class="grid gap-12 sm:grid-cols-2 md:grid-cols-4 justify-between">

        @php
          $steps = [
            [
              'icon' => '📊',
              'title' => 'Admin reviews bin levels and sets routes.',
              'color' => 'bg-rose-100 text-rose-600',
            ],
            [
              'icon' => '📈',
              'title' => 'Reports and analytics are generated for admins.',
              'color' => 'bg-green-100 text-green-600',
            ],
            [
              'icon' => '📡',
              'title' => 'Waste bins send status data to the system.',
              'color' => 'bg-blue-100 text-blue-600',
            ],
            [
              'icon' => '🚚',
              'title' => 'Drivers follow optimized paths for pickup.',
              'color' => 'bg-yellow-100 text-yellow-600',
            ],
          ];
        @endphp

        @foreach ($steps as $step)
        <div
          class="flex flex-col items-center bg-white rounded-xl p-8 shadow-md hover:shadow-xl transition-shadow duration-300 cursor-default max-w-xs text-center mx-auto"
        >
          <div
            class="text-5xl mb-6 rounded-full w-20 h-20 flex items-center justify-center {{ $step['color'] }} drop-shadow-lg"
          >
            {{ $step['icon'] }}
          </div>
          <p class="text-[#895353] font-semibold text-lg leading-snug">
            {{ $step['title'] }}
          </p>
        </div>
        @endforeach

      </div>
    </section>

  </div>
</div>
@endsection
