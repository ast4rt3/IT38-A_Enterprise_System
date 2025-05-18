<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Checkpoint;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
    'first_name' => ['required', 'string', 'max:255'],
    'last_name' => ['required', 'string', 'max:255'],
    'middle_initial' => ['nullable', 'string', 'max:1'],
    'suffix' => ['nullable', 'string', 'max:10'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
    'phone' => ['required', 'string', 'max:20'],
            'region' => ['required', 'string', 'max:100'],
            'province' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
    'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'license' => ['nullable', 'string', 'max:50'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
]);

        $user = User::create([
    'first_name' => $request->first_name,
    'last_name' => $request->last_name,
    'middle_initial' => $request->middle_initial,
    'suffix' => $request->suffix,
    'email' => $request->email,
    'phone' => $request->phone,
    'region' => $request->region,
    'province' => $request->province,
    'city' => $request->city,
            'license' => $request->license,
    'password' => Hash::make($request->password),
            'role' => 'user', // or 'driver' if this is a driver registration
        ]);

        // Create a default checkpoint for the user
        Checkpoint::create([
            'user_id' => $user->id,
            'name' => $user->first_name . "'s Location",
            'address' => 'User Registration Location',
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => 'pending',
            'schedule' => 'weekly',
]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
