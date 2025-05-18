<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Route;
use App\Models\User;

class TestRoutesSeeder extends Seeder
{
    public function run(): void
    {
        $driver = User::where('role', 'driver')->first();

        if ($driver) {
            // Create some test routes
            Route::create([
                'driver_id' => $driver->id,
                'start_location' => '123 Main St, City A',
                'end_location' => '456 Oak St, City B',
                'scheduled_time' => now()->addHours(2),
                'status' => 'pending'
            ]);

            Route::create([
                'driver_id' => $driver->id,
                'start_location' => '789 Pine St, City C',
                'end_location' => '321 Elm St, City D',
                'scheduled_time' => now()->addHours(4),
                'status' => 'in_progress'
            ]);

            Route::create([
                'driver_id' => $driver->id,
                'start_location' => '555 Maple St, City E',
                'end_location' => '888 Cedar St, City F',
                'scheduled_time' => now()->addHours(6),
                'status' => 'completed'
            ]);
        }
    }
} 