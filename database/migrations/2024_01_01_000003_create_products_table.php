<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique()->comment('Product barcode for scanning');
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->decimal('purchase_price', 10, 2)->comment('Buying price from supplier');
            $table->decimal('selling_price', 10, 2)->comment('Selling price to customer');
            $table->integer('stock')->default(0)->comment('Current stock quantity');
            $table->integer('minimum_stock')->default(10)->comment('Minimum stock warning level');
            $table->timestamps();
            
            $table->index('barcode');
            $table->index('name');
            $table->index(['stock', 'minimum_stock']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};