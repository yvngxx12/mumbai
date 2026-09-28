<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $unitPrice = $this->faker->randomFloat(2, 14000, 30000);

        return [
            'order_number' => config('shop.brand').'-'.$this->faker->unique()->numberBetween(1000, 99999),
            'customer_name' => $this->faker->name(),
            'customer_phone' => '11'.$this->faker->numerify('########'),
            'product_id' => Product::factory(),
            'product_name' => $this->faker->word(),
            'color_name' => 'Negro',
            'size_name' => 'M',
            'unit_price' => $unitPrice,
            'deposit' => round($unitPrice / 2, 2),
            'status' => OrderStatus::Pending,
        ];
    }

    /**
     * Confirmar el pedido (pago acreditado).
     */
    public function confirmed(): static
    {
        return $this->state(fn (): array => ['status' => OrderStatus::Confirmed]);
    }

    /**
     * Cancelar el pedido.
     */
    public function cancelled(): static
    {
        return $this->state(fn (): array => ['status' => OrderStatus::Cancelled]);
    }
}
