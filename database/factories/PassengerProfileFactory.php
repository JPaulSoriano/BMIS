<?php

namespace Database\Factories;

use App\PassengerProfile;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class PassengerProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PassengerProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'middle_name' => $this->faker->lastName,
            'contact' => $this->faker->name,
            'address' => $this->faker->address,
        ];
    }
}