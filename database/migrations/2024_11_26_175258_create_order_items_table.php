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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()
                ->constrained('products')
                ->nullOnDelete();
            $table->string('product_name');
            $table->decimal('original_price', 10, 2); // السعر الأصلي
            $table->decimal('discounted_price', 10, 2);
            $table->unsignedSmallInteger('quantity')->default(1);
            $table->decimal('total', 10, 2);
            $table->char('currency_code', 3);
            $table->json('options')->nullable();

            $table->unique(['order_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
