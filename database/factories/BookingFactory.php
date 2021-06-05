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
        $rides = Ride::all();
        $ride_ids = $rides->pluck('id');

        $ride = $ride_ids->random();
        $route = Ride::find($ride)->route;
        $number_of_terminals = $route->terminals->count();
        $first_order = mt_rand(0, $number_of_terminals - 2);
        $last_order = 0;
        while ($first_order > $last_order) {
            $last_order = mt_rand(1, $number_of_terminals - 1);
        }

        $start = $route->terminals->where('pivot.order', 0)->pluck('id')->first();
        $end = $route->terminals->where('pivot.order', mt_rand(1, $number_of_terminals - 1))->pluck('id')->first();

        return [
            'booking_code' => mt_rand(0000000000, 9999999999),
            'ride_id' => $ride,
            'start_terminal_id' => $start,
            'end_terminal_id' => $end,
            'pax' => mt_rand(1, 5),
            'aboard' => 0,
            'status' => 'new',
            'travel_date' => $this->faker->dateTimeBetween('+2 days', '+3 months'),
        ];
    }
}
