<?php

namespace Database\Factories;

use App\Booking;
use App\Ride;
use App\Terminal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $rides = Ride::all()->pluck('id');
        $terminals = Terminal::all()->pluck('id');



        return [
            'booking_code' => mt_rand(0000000000, 9999999999),
            'ride_id' => $rides->random(),
            'start_terminal_id' => $terminals->random(),
            'end_terminal_id' => $terminals->random(),
            'pax' => mt_rand(1, 5),
            'aboard' => mt_rand(0, 1),
            'status' => 'new',
            'travel_date' => $this->faker->dateTimeBetween('now', '+3 months'),
        ];
    }
}
