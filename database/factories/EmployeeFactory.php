<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstname' => fake()->word(),
            'surname' => fake()->word(),
            'dob' => fake()->date(),
            'contact_email' => fake()->email(),
            'contact_phone' => "0123546512",
            'contact_address' => fake()->randomDigit() . " " . fake()->word() . " " . "Street",
            'status' => true,
            'active' => true
        ];
    }
}
