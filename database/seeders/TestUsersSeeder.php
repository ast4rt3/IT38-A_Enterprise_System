<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Create or Update Admin
        User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '1234567890',
                'region' => 'Test Region',
                'province' => 'Test Province',
                'city' => 'Test City'
            ]
        );

        // Create or Update Driver
        User::updateOrCreate(
            ['email' => 'driver@test.com'],
            [
                'first_name' => 'Driver',
                'last_name' => 'User',
                'password' => Hash::make('password123'),
                'role' => 'driver',
                'phone' => '1234567891',
                'region' => 'Test Region',
                'province' => 'Test Province',
                'city' => 'Test City',
                'license' => 'DRIVER123'
            ]
        );

        // Create or Update Regular User
        User::updateOrCreate(
            ['email' => 'user@test.com'],
            [
                'first_name' => 'Regular',
                'last_name' => 'User',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'phone' => '1234567892',
                'region' => 'Test Region',
                'province' => 'Test Province',
                'city' => 'Test City'
            ]
        );
    }
} 