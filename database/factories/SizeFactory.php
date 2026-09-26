<?php

namespace Database\Factories;

use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Size>
 */
class SizeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $names = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];

        return [
            'name' => $this->faker->unique()->randomElement($names),
            'sort' => $this->faker->unique()->numberBetween(0, 10),
        ];
    }
}
