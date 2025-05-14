<div class="flex h-screen bg-green-50">
    <!-- Sidebar -->
    <nav class="bg-green-300 w-64 h-full border-r border-green-400">
        <div class="flex items-center p-4 bg-green-400">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-9 w-auto fill-current text-white" />
            </a>
        </div>

        <!-- Navigation Links -->
        <div class="flex flex-col p-4 space-y-4">
            <!-- Home (Dashboard) -->
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-green-800 hover:text-white">
                {{ __('Home') }}
            </x-nav-link>

            <!-- Features -->
            <x-nav-link :href="route('features')" :active="request()->routeIs('features')" class="text-green-800 hover:text-white">
                {{ __('Features') }}
            </x-nav-link>

            <!-- Live Map -->
            <x-nav-link :href="route('live-map')" :active="request()->routeIs('live-map')" class="text-green-800 hover:text-white">
                {{ __('Live Map') }}
            </x-nav-link>

            <!-- Reports -->
            <x-nav-link :href="route('reports')" :active="request()->routeIs('reports')" class="text-green-800 hover:text-white">
                {{ __('Reports') }}
            </x-nav-link>

            <!-- Contact -->
            <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')" class="text-green-800 hover:text-white">
                {{ __('Contact') }}
            </x-nav-link>
        </div>

        <!-- Authentication Links -->
        <div class="mt-auto p-4">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-green-700 bg-green-200 hover:bg-green-300 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ Auth::user()->name }}</div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')" class="text-green-800 hover:bg-green-300">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-green-800 hover:bg-green-300">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="flex-1 bg-green-100 py-6 px-4 sm:px-6 lg:px-8">
        <!-- Main content goes here -->
        {{ $slot }}
    </div>
</div>
