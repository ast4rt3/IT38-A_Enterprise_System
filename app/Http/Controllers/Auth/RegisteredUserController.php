<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    'phone' => ['required', 'string', 'max:20'],
    'password' => ['required', 'confirmed', Rules\Password::defaults()],
    'is_driver' => ['nullable', 'boolean'],
    'license' => ['required_if:is_driver,1', 'nullable', 'string', 'max:50'],
    'region' => ['required', 'string'],
    'province' => ['required', 'string'],
    'city' => ['required', 'string'],
]);


        $user = User::create([
    'first_name' => $request->first_name,
    'last_name' => $request->last_name,
    'middle_initial' => $request->middle_initial,
    'suffix' => $request->suffix,
    'email' => $request->email,
    'phone' => $request->phone,
    'is_driver' => $request->boolean('is_driver'),
    'license' => $request->license,
    'region' => $request->region,
    'province' => $request->province,
    'city' => $request->city,
    'password' => Hash::make($request->password),
]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
