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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->date('order_date');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade')->nullAble();
            $table->enum('status', ['pending', 'ordered', 'processed', 'shipped', 'arrived', 'finished', 'cancelled by customer', 'cancelled by seller'])->nullAble();
            $table->enum('payment_method', ['transfer', 'cash on delivery'])->default('cash on delivery');
            $table->integer('total_price')->default(0);
            $table->string('status information')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
