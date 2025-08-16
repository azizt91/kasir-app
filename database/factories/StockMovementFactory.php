<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockMovement>
 */
class StockMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'type' => fake()->randomElement(['in', 'out']),
            'quantity' => fake()->numberBetween(1, 50),
            'reference_type' => null,
            'reference_id' => null,
            'notes' => fake()->sentence(),
            'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}