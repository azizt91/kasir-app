<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
        $products = [
            'Indomie Goreng',
            'Aqua 600ml',
            'Teh Botol Sosro',
            'Beras Premium 5kg',
            'Minyak Goreng 1L',
            'Gula Pasir 1kg',
            'Kopi ABC Susu',
            'Sabun Mandi Lifebuoy',
            'Pasta Gigi Pepsodent',
            'Shampoo Pantene',
            'Deterjen Rinso',
            'Tissue Paseo',
            'Susu UHT Frisian Flag',
            'Roti Tawar Sari Roti',
            'Telur Ayam 1kg',
            'Biscuit Oreo',
            'Kerupuk Udang',
            'Sambal ABC',
            'Kecap Manis Bango',
            'Mayonaise Maestro'
        ];

        $purchasePrice = fake()->randomFloat(2, 1000, 50000);
        $sellingPrice = $purchasePrice * fake()->randomFloat(2, 1.2, 2.0); // 20-100% markup

        return [
            'barcode' => fake()->unique()->ean13(),
            'name' => fake()->randomElement($products) . ' ' . fake()->randomElement(['Original', 'Premium', 'Classic', 'Special']),
            'description' => fake()->sentence(),
            'category_id' => Category::factory(),
            'purchase_price' => $purchasePrice,
            'selling_price' => $sellingPrice,
            'stock' => fake()->numberBetween(0, 100),
            'minimum_stock' => fake()->numberBetween(5, 20),
        ];
    }

    /**
     * Indicate that the product has low stock.
     */
    public function lowStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => fake()->numberBetween(0, 5),
            'minimum_stock' => fake()->numberBetween(10, 20),
        ]);
    }
}