<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\booking;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        booking::factory() -> count (7) -> create();
    }
}
