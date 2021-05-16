<?php

namespace Database\Factories;

use App\EmployeeRide;
use App\User;
use App\Ride;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeRideFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmployeeRide::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $rides = Ride::all()->pluck('id');
        $conductors = User::role('conductor')->pluck('id');
        $drivers = User::role('driver')->pluck('id');
        

        return [
            'ride_code' => mt_rand(0000000000,9999999999),
            'ride_id' => $rides->random(),
            'conductor_id' => $conductors->random(),
            'driver_id' => $drivers->random(),
            'travel_date' => $this->faker->dateTimeBetween('now', '+6 months'),
        ];
    }
}
