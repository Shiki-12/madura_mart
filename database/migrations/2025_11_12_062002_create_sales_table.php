<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id(); // BigInt (PK)

            // Mencatat tanggal transaksi
            $table->date('sale_date');

            // Mencatat total belanjaan
            $table->integer('total_price')->default(0);

            // TAMBAHAN PENTING: Siapa kasirnya?
            // (Relasi ke tabel users)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade'); // Jika user dihapus, data penjualan ikut hilang (opsional, bisa juga set null)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
