<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionItem>
 */
class TransactionItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::factory()->create();
        $quantity = fake()->numberBetween(1, 5);
        $price = $product->selling_price;
        $subtotal = (float) $price * $quantity;

        return [
            'transaction_id' => Transaction::factory(),
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $price,
            'subtotal' => $subtotal,
        ];
    }
}