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
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade')->nullAble();
            $table->string('serial_number_product', 10)->nullAble();
            $table->integer('selling_price')->default(0);
            $table->integer('sales_quantity')->default(0);
            $table->integer('subtotal')->default(0);

            $table->foreign('serial_number_product')
                ->references('serial_number')
                ->on('products')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};
