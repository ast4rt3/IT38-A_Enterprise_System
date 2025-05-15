<div class="flex h-screen bg-green-50">
  <!-- Sidebar -->
  <nav class="bg-green-300 w-20 h-full border-r border-green-400 flex flex-col">
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 bg-green-400 border-b border-green-400">
      <a href="{{ route('dashboard') }}">
        <x-application-logo class="block h-9 w-auto fill-current text-white" />
      </a>
    </div>

    <div class="flex flex-col flex-1 space-y-2 p-2">
  <!-- Dashboard (Home icon) -->
  <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex justify-center items-center h-14 w-full rounded-lg text-green-800 hover:bg-green-400 hover:text-white transition">
    <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24" stroke="none" xmlns="http://www.w3.org/2000/svg" >
      <path d="M3 12l9-9 9 9v9a3 3 0 01-3 3h-12a3 3 0 01-3-3v-9z" />
    </svg>
  </x-nav-link>

  <!-- Features (Star icon) -->
  <x-nav-link :href="route('features')" :active="request()->routeIs('features')" class="flex justify-center items-center h-14 w-full rounded-lg text-green-800 hover:bg-green-400 hover:text-white transition">
    <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24" stroke="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M12 17.27l5.18 3.73-1.64-6.81L20 9.24l-6.91-.59L12 2 10.91 8.65 4 9.24l4.46 4.95-1.64 6.81z" />
    </svg>
  </x-nav-link>

  <!-- Live Map (Map Pin icon) -->
  <x-nav-link :href="route('live-map')" :active="request()->routeIs('live-map')" class="flex justify-center items-center h-14 w-full rounded-lg text-green-800 hover:bg-green-400 hover:text-white transition">
    <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24" stroke="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M12 2a7 7 0 00-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 00-7-7zM12 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z" />
    </svg>
  </x-nav-link>

  <!-- Reports (Document icon) -->
  <x-nav-link :href="route('reports')" :active="request()->routeIs('reports')" class="flex justify-center items-center h-14 w-full rounded-lg text-green-800 hover:bg-green-400 hover:text-white transition">
    <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24" stroke="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M6 2h9l5 5v13a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2zM14 3.5V9h5" />
    </svg>
  </x-nav-link>

  <!-- Contact (Chat bubble icon) -->
  <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')" class="flex justify-center items-center h-14 w-full rounded-lg text-green-800 hover:bg-green-400 hover:text-white transition">
    <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24" stroke="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M21 6a2 2 0 00-2-2H5a2 2 0 00-2 2v12l4-4h12a2 2 0 002-2V6z" />
    </svg>
  </x-nav-link>
</div>


    <!-- Authentication Links (Dropdown) -->
    <div class="p-4 border-t border-green-400">
      <x-dropdown align="right" width="48">
        <!-- Trigger -->
        <x-slot name="trigger">
          <button
            class="flex items-center justify-center w-full h-14 text-green-800 hover:text-green-600 focus:outline-none focus:text-green-600 transition bg-green-100 rounded-lg"
            aria-label="User menu"
          >
            <div>{{ Auth::user()->name }}</div>
            <div class="ml-1">
              <svg class="fill-current h-5 w-5" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414L10 13.414 5.293 8.707a1 1 0 010-1.414z"
                  clip-rule="evenodd" />
              </svg>
            </div>
          </button>
        </x-slot>

        <!-- Dropdown Content -->
        <x-slot name="content">
          <x-dropdown-link :href="route('profile.edit')" class="text-green-800 hover:bg-green-300 px-4 py-2">
            {{ __('Profile') }}
          </x-dropdown-link>

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
              class="text-green-800 hover:bg-green-300 px-4 py-2">
              {{ __('Log Out') }}
            </x-dropdown-link>
          </form>
        </x-slot>
      </x-dropdown>
    </div>
  </nav>

  <!-- Main Content Area -->
  <div class="flex-1 bg-green-100 py-6 px-4 sm:px-6 lg:px-8">
    {{ $slot }}
  </div>
</div>
