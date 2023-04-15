<?php

namespace Database\Seeders;

use App\Models\package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        package::insert([
            [
                'package_type' => 1,
                'suite_type' => 'Standard', 
                'stay_type' => 'FB',
                'price_per_night' => 25000,
                'tax' => 0.1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'package_type' => 2,
                'suite_type' => 'Standard', 
                'stay_type' => 'BB',
                'price_per_night' => 15000,
                'tax' => 0.1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'package_type' => 3,
                'suite_type' => 'Deluxe', 
                'stay_type' => 'FB',
                'price_per_night' => 40000,
                'tax' => 0.1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'package_type' => 4,
                'suite_type' => 'Deluxe', 
                'stay_type' => 'BB',
                'price_per_night' => 25000,
                'tax' => 0.1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
