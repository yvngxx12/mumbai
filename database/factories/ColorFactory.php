<?php

namespace Database\Factories;

use App\Models\Color;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Color>
 */
class ColorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hexes = ['#111111', '#f5f5f5', '#9ca3af', '#dc2626', '#4d7c0f', '#2563eb', '#d6c3a6', '#7f1d1d'];

        return [
            'name' => $this->faker->unique()->colorName(),
            'hex' => $this->faker->randomElement($hexes),
        ];
    }
}
