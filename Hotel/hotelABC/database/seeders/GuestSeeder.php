<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\guest;

class GuestSeeder extends Seeder
{
    public function run(): void
    {
        guest::factory() -> count (5) -> create();
    }
}
