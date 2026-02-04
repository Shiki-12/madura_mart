<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();

            // PERBAIKAN 1: Gunakan purchase_id (Relasi ke tabel purchases)
            // onDelete('cascade') artinya jika Nota induk dihapus, detail barangnya ikut terhapus otomatis.
            $table->foreignId('purchase_id')->constrained('purchases')->onDelete('cascade');

            // PERBAIKAN 2: Gunakan product_id (Relasi ke tabel products)
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            // Data Transaksi
            $table->integer('purchase_price')->default(0); // Harga Beli Satuan
            $table->integer('purchase_amount')->default(0); // Jumlah Beli (Qty)
            $table->integer('subtotal')->default(0);       // (Harga Beli x Qty)

            // Fitur Tambahan (Opsional sesuai blueprint asli): Margin Jual
            // Ini berguna jika nanti ingin otomatis update harga jual produk berdasarkan margin
            $table->smallInteger('selling_margin')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
