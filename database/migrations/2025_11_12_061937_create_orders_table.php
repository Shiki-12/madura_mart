<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Identitas Unik
            $table->string('invoice_number')->unique(); // INV/2026/001

            // Pelaku
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Pembeli
            $table->foreignId('courier_id')->nullable()->constrained('users')->onDelete('set null'); // Kurir (diisi admin nanti)

            // Detail Pengiriman
            $table->text('delivery_address'); // Alamat kirim (snapshot dari profil user/input baru)

            // Status & Pembayaran
            $table->date('order_date');
            $table->enum('status', [
                'pending',              // Baru checkout, belum bayar/verifikasi
                'payment_verified',     // (Baru) Pembayaran transfer dicek admin ok
                'processed',            // Admin sedang packing / menyiapkan
                'shipped',              // Paket dibawa kurir (Kurir update ini)
                'arrived',              // Paket sampai di lokasi (Kurir update ini)
                'completed',            // Customer klik "Pesanan Diterima" / Selesai
                'cancelled',            // Batal
            ])->default('pending');

            $table->enum('payment_method', ['transfer', 'cod'])->default('cod');
            $table->string('payment_proof')->nullable(); // Foto bukti transfer

            // Keuangan
            $table->integer('total_price')->default(0);

            // Catatan (Ganti 'status information')
            $table->string('notes')->nullable(); // Catatan pembatalan atau info tambahan

            $table->timestamps();
        });
    }
};
