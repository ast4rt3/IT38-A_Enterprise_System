<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
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
                <x-select id="suffix" name="suffix" class="mt-1 block w-full">
                    <option value="">Select Suffix</option>
                    <option value="Jr" {{ old('suffix') == 'Jr' ? 'selected' : '' }}>Jr.</option>
                    <option value="Sr" {{ old('suffix') == 'Sr' ? 'selected' : '' }}>Sr.</option>
                    <option value="II" {{ old('suffix') == 'II' ? 'selected' : '' }}>II</option>
                    <option value="III" {{ old('suffix') == 'III' ? 'selected' : '' }}>III</option>
                </x-select>
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
                <select id="region" name="region" class="mt-1 block w-full" required>
                    <option value="">Select Region</option>
                </select>
                <x-input-error :messages="$errors->get('region')" class="mt-2" />
            </div>

            <!-- Province -->
            <div>
                <x-input-label for="province" :value="__('Province')" />
                <select id="province" name="province" class="mt-1 block w-full" required>
                    <option value="">Select Province</option>
                </select>
                <x-input-error :messages="$errors->get('province')" class="mt-2" />
            </div>

            <!-- City -->
            <div>
                <x-input-label for="city" :value="__('City / Municipality')" />
                <select id="city" name="city" class="mt-1 block w-full" required>
                    <option value="">Select City</option>
                </select>
                <x-input-error :messages="$errors->get('city')" class="mt-2" />
            </div>

            <!-- Driver Checkbox (Full Width) -->
            <div class="col-span-1 md:col-span-2">
                <label for="is_driver" class="block text-sm text-gray-700">{{ __('Are you registering as a driver?') }}</label>
                <label class="flex items-center mt-1">
                    <input type="checkbox" id="is_driver" name="is_driver" class="mr-2" value="1">
                    {{ __('Yes, I am a driver') }}
                </label>
            </div>

            <!-- Driver License -->
            <div id="driver-license" class="col-span-1 md:col-span-2 hidden">
                <x-input-label for="license" :value="__('Driver License Number')" />
                <x-text-input id="license" class="mt-1 block w-full" type="text" name="license" :value="old('license')" autocomplete="new-license" />
                <x-input-error :messages="$errors->get('license')" class="mt-2" />
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

    <script>
        document.getElementById('is_driver').addEventListener('change', function () {
            const licenseField = document.getElementById('driver-license');
            licenseField.classList.toggle('hidden', !this.checked);
        });
    </script>

    
</x-guest-layout>
