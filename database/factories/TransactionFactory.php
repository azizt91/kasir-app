<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 10000, 500000);
        $discount = fake()->randomFloat(2, 0, $subtotal * 0.1); // Max 10% discount
        $tax = 0; // No tax for now
        $totalAmount = $subtotal - $discount + $tax;
        $amountPaid = $totalAmount + fake()->randomFloat(2, 0, 50000); // Sometimes overpaid
        $changeAmount = $amountPaid - $totalAmount;

        return [
            'transaction_code' => Transaction::generateTransactionCode(),
            'user_id' => User::factory(),
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'total_amount' => $totalAmount,
            'payment_method' => fake()->randomElement(['cash', 'card', 'other']),
            'amount_paid' => $amountPaid,
            'change_amount' => $changeAmount,
            'status' => 'completed',
            'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}