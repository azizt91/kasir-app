<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class SampleProductSeeder extends Seeder
{
    public function run()
    {
        // Create categories first
        $categories = [
            ['name' => 'Makanan', 'description' => 'Produk makanan'],
            ['name' => 'Minuman', 'description' => 'Produk minuman'],
            ['name' => 'Snack', 'description' => 'Makanan ringan'],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(['name' => $categoryData['name']], $categoryData);
        }

        // Create sample products
        $products = [
            [
                'barcode' => '8999999001',
                'name' => 'Indomie Goreng',
                'category_id' => Category::where('name', 'Makanan')->first()->id,
                'stock' => 50,
                'minimum_stock' => 10,
                'cost_price' => 2500,
                'selling_price' => 3000,
            ],
            [
                'barcode' => '8999999002',
                'name' => 'Aqua 600ml',
                'category_id' => Category::where('name', 'Minuman')->first()->id,
                'stock' => 30,
                'minimum_stock' => 5,
                'cost_price' => 3000,
                'selling_price' => 4000,
            ],
            [
                'barcode' => '8999999003',
                'name' => 'Chitato Sapi Panggang',
                'category_id' => Category::where('name', 'Snack')->first()->id,
                'stock' => 25,
                'minimum_stock' => 5,
                'cost_price' => 8000,
                'selling_price' => 10000,
            ],
            [
                'barcode' => '8999999004',
                'name' => 'Teh Botol Sosro',
                'category_id' => Category::where('name', 'Minuman')->first()->id,
                'stock' => 40,
                'minimum_stock' => 8,
                'cost_price' => 4000,
                'selling_price' => 5000,
            ],
            [
                'barcode' => '8999999005',
                'name' => 'Roti Tawar Sari Roti',
                'category_id' => Category::where('name', 'Makanan')->first()->id,
                'stock' => 15,
                'minimum_stock' => 3,
                'cost_price' => 12000,
                'selling_price' => 15000,
            ],
        ];

        foreach ($products as $productData) {
            Product::firstOrCreate(['barcode' => $productData['barcode']], $productData);
        }
    }
}
