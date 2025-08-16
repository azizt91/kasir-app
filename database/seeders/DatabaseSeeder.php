<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin Minimarket',
            'email' => 'admin@minimarket.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create kasir users
        $kasir1 = User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir1@minimarket.com',
            'password' => bcrypt('password'),
            'role' => 'kasir',
            'email_verified_at' => now(),
        ]);

        $kasir2 = User::create([
            'name' => 'Kasir 2',
            'email' => 'kasir2@minimarket.com',
            'password' => bcrypt('password'),
            'role' => 'kasir',
            'email_verified_at' => now(),
        ]);

        // Create categories
        $categories = [
            ['name' => 'Makanan & Minuman', 'description' => 'Produk makanan dan minuman'],
            ['name' => 'Elektronik', 'description' => 'Peralatan elektronik'],
            ['name' => 'Peralatan Rumah Tangga', 'description' => 'Keperluan rumah tangga'],
            ['name' => 'Kesehatan & Kecantikan', 'description' => 'Produk kesehatan dan kecantikan'],
            ['name' => 'Pakaian & Aksesoris', 'description' => 'Pakaian dan aksesoris'],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Create suppliers
        Supplier::factory(10)->create();

        // Create products with specific categories
        Category::all()->each(function ($category) {
            Product::factory(10)->create([
                'category_id' => $category->id,
            ]);
        });

        // Create some products with low stock
        Product::factory(5)->lowStock()->create();

        // Create sample transactions
        $users = User::whereIn('role', ['admin', 'kasir'])->get();

        // Create transactions for the last 30 days
        for ($i = 0; $i < 50; $i++) {
            $transaction = Transaction::create([
                // 'transaction_code' => Transaction::generateTransactionCode(),
                'transaction_code' => 'TRX' . now()->format('Ymd') . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'user_id' => $users->random()->id,
                'subtotal' => 0,
                'discount' => 0,
                'tax' => 0,
                'total_amount' => 0,
                'payment_method' => fake()->randomElement(['cash', 'card', 'other']),
                'amount_paid' => 0,
                'change_amount' => 0,
                'status' => 'completed',
                'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
            ]);

            // Add transaction items
            $products = Product::where('stock', '>', 0)->inRandomOrder()->take(random_int(1, 5))->get();
            $subtotal = 0;

            foreach ($products as $product) {
                $quantity = random_int(1, min(3, $product->stock));
                $price = $product->selling_price;
                $itemSubtotal = (float) $price * $quantity;

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $itemSubtotal,
                ]);

                // Update product stock
                $product->decrement('stock', $quantity);

                // Create stock movement
                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'out',
                    'quantity' => $quantity,
                    'reference_type' => 'App\Models\Transaction',
                    'reference_id' => $transaction->id,
                    'notes' => "Penjualan - {$transaction->transaction_code}",
                    'created_at' => $transaction->created_at,
                ]);

                $subtotal += $itemSubtotal;
            }

            // Update transaction totals
            $discount = fake()->boolean(30) ? fake()->randomFloat(2, 0, $subtotal * 0.1) : 0;
            $totalAmount = $subtotal - $discount;
            $amountPaid = $totalAmount + fake()->randomFloat(2, 0, 20000);
            $changeAmount = $amountPaid - $totalAmount;

            $transaction->update([
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total_amount' => $totalAmount,
                'amount_paid' => $amountPaid,
                'change_amount' => $changeAmount,
            ]);
        }

        // Create additional stock movements for inventory history
        Product::all()->each(function ($product) {
            // Initial stock entry
            if ($product->stock > 0) {
                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'in',
                    'quantity' => $product->stock + random_int(10, 50),
                    'notes' => 'Stok awal produk',
                    'created_at' => fake()->dateTimeBetween('-60 days', '-30 days'),
                ]);
            }

            // Random stock additions
            for ($i = 0; $i < random_int(1, 3); $i++) {
                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'in',
                    'quantity' => random_int(10, 100),
                    'notes' => 'Restok dari supplier',
                    'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
                ]);
            }
        });

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin credentials: admin@minimarket.com / password');
        $this->command->info('Kasir credentials: kasir1@minimarket.com / password');
    }
}
