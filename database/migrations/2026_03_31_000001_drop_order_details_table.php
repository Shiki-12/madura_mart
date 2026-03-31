<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Drop the legacy order_details table.
     * The order_items table is the canonical line-item table,
     * using proper integer FK (product_id) with data snapshots.
     */
    public function up(): void
    {
        Schema::dropIfExists('order_details');
    }

    public function down(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->string('serial_number_product', 10)->nullable();
            $table->integer('selling_price')->default(0);
            $table->integer('sales_quantity')->default(0);
            $table->integer('subtotal')->default(0);
            $table->string('note')->nullable();
            $table->foreign('serial_number_product')
                ->references('serial_number')
                ->on('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }
};
