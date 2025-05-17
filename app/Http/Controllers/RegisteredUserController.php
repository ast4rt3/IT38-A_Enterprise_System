<?php


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // <-- Add this import

class RegisteredUserController extends Controller
{
    public function createDriver()
    {
        return view('auth.register-driver');
    }

    public function storeDriver(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'region' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'password' => 'required|confirmed|min:8',
            'license' => 'required|string|max:255',
        ]);

        // Store the driver (user)
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'suffix' => $request->suffix,
            'email' => $request->email,
            'phone' => $request->phone,
            'region' => $request->region,
            'province' => $request->province,
            'city' => $request->city,
            'license' => $request->license,
            'password' => Hash::make($request->password),
            'role' => 'driver', // if you're using roles
        ]);
    }
}