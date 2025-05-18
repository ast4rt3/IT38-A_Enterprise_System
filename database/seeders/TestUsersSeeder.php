<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '1234567890',
            'region' => 'Test Region',
            'province' => 'Test Province',
            'city' => 'Test City'
        ]);

        // Create Driver
        User::create([
            'first_name' => 'Driver',
            'last_name' => 'User',
            'email' => 'driver@test.com',
            'password' => Hash::make('password123'),
            'role' => 'driver',
            'phone' => '1234567891',
            'region' => 'Test Region',
            'province' => 'Test Province',
            'city' => 'Test City',
            'license' => 'DRIVER123'
        ]);

        // Create Regular User
        User::create([
            'first_name' => 'Regular',
            'last_name' => 'User',
            'email' => 'user@test.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'phone' => '1234567892',
            'region' => 'Test Region',
            'province' => 'Test Province',
            'city' => 'Test City'
        ]);
    }
} 