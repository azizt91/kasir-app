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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->enum('type', ['in', 'out'])->comment('Stock movement type: in (purchase) or out (sale)');
            $table->integer('quantity')->comment('Quantity moved');
            $table->string('reference_type')->nullable()->comment('Reference model type (transaction, purchase, etc.)');
            $table->unsignedBigInteger('reference_id')->nullable()->comment('Reference model ID');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['product_id', 'type']);
            $table->index(['reference_type', 'reference_id']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};