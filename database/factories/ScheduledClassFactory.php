<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ScheduledClass>
 */
class ScheduledClassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'class_type_id' => rand(1,10), // Assuming class type IDs are between 1 and 10
            'instructor_id' => rand(15,24), // Assuming instructor IDs are between 15 and 24
            // Schedule classes between 1 day from now to 1 month from now
            'date_time' => $this->faker->dateTimeBetween('+1 days', '+1 month'),
        ];
    }
}
