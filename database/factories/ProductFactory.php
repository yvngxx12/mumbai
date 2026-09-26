<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['Básica', 'Oversize', 'Boxy', 'Pesada'];

        return [
            'name' => $this->faker->unique()->words(2, true),
            'slug' => $this->faker->unique()->slug(2),
            'description' => $this->faker->paragraph(),
            'type' => $this->faker->randomElement($types),
            'price' => $this->faker->randomFloat(2, 14000, 30000),
            'image' => 'images/products/placeholder.svg',
            'stock' => $this->faker->numberBetween(0, 60),
        ];
    }
}
