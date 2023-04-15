<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'suite' => $this -> faker -> randomElement(['Deluxe', 'Standard']),
            'status' => $this -> faker -> randomElement(['Booked', 'Available']),
        ];
    }
}
