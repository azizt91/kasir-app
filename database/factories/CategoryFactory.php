<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Makanan & Minuman',
            'Elektronik',
            'Peralatan Rumah Tangga',
            'Kesehatan & Kecantikan',
            'Pakaian & Aksesoris',
            'Mainan & Hobi',
            'Olahraga & Outdoor',
            'Buku & Alat Tulis',
            'Otomotif',
            'Kebun & Taman'
        ];

        return [
            'name' => fake()->unique()->randomElement($categories),
            'description' => fake()->sentence(10),
        ];
    }
}