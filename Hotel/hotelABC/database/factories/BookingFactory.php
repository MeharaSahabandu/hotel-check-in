<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $booking_room_id = $this ->faker-> numberBetween (1,5);
        $booking_guest_id = $this ->faker-> numberBetween (1,5);

        if($booking_room_id ==1 || $booking_room_id == 2 || $booking_room_id ==4){
            $booking_package_type = $this -> faker -> numberBetween(1,2);
        } else{
            $booking_package_type = $this -> faker -> numberBetween(3,4);
        }

        $checkIN = $this -> faker -> dateTimeBetween($startDay='-1 days', $endDay='now', $timezone=null);
        $checkOut = $this -> faker -> dateTimeBetween ($startDay='+2 days', $endDay='+5 days', $timezone=null);
        
        return [
            'guest_id' => $booking_guest_id,
            'room_id' =>$booking_room_id,
            'package_type' =>$booking_package_type,
            'check_in' => $checkIN,
            'check_out' => $checkOut,
        ];
    }
}
