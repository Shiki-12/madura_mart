<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();

            // Relasi ke Header Penjualan (Sales)
            $table->foreignId('sale_id')
                ->constrained('sales')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // PERBAIKAN: Gunakan product_id (Integer) bukan serial_number (String)
            $table->foreignId('product_id')
                ->constrained('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Data Transaksi
            $table->integer('selling_price')->default(0); // Harga Jual saat itu
            $table->integer('quantity')->default(0);      // Jumlah barang (biar konsisten namanya 'quantity' aja)
            $table->integer('subtotal')->default(0);      // (Harga x Qty)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};
