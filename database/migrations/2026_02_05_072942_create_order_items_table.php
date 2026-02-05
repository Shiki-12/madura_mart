<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Relasi ke Header Order
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Hapus order = hapus item

            // Relasi ke Produk
            // Kalau produk dihapus, data penjualan jangan hilang (set null)
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');

            // Snapshot Data (Penting untuk laporan laba rugi akurat)
            $table->string('product_name'); // Simpan nama produk saat beli (jaga2 kalau nama produk diubah)
            $table->integer('quantity');
            $table->integer('price'); // Harga satuan saat dibeli
            $table->integer('subtotal'); // quantity * price

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
