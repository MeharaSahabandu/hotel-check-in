<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        room::factory() -> count (5) -> create();
    }
}