<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '09123456789',
            'region' => 'NCR',
            'province' => 'Metro Manila',
            'city' => 'Manila'
        ]);

        // Create Regular User
        User::create([
            'first_name' => 'Regular',
            'last_name' => 'User',
            'email' => 'users@test.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '09123456790',
            'region' => 'NCR',
            'province' => 'Metro Manila',
            'city' => 'Quezon City'
        ]);

        // Create Driver
        User::create([
            'first_name' => 'Driver',
            'last_name' => 'User',
            'email' => 'driver@test.com',
            'password' => Hash::make('password'),
            'role' => 'driver',
            'phone' => '09123456791',
            'license' => 'DL-123456',
            'region' => 'NCR',
            'province' => 'Metro Manila',
            'city' => 'Makati'
        ]);

        $this->call([
            TestUsersSeeder::class,
            TestRoutesSeeder::class,
        ]);
    }
}
