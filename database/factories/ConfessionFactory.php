<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Confession>
 */
class ConfessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'recipient_name' => $this->faker->firstName,
            'message' => $this->faker->realText(100), // atau custom kalimat
            'sender_name' => $this->faker->firstName,
        ];
    }
}
