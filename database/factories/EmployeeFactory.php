<?php

namespace Database\Factories;

use App\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'employee_no' => $this->faker->uuid,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'contact' => $this->faker->name,
            'address' => $this->faker->address,
        ];
    }
}
