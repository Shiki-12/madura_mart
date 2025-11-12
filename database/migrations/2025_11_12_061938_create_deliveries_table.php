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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->date('delivery_date');
            $table->foreignId('expedition_id')->constrained('expeditions')->onDelete('cascade')->nullAble();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade')->nullAble();
            $table->string('picture_proof');
            $table->integer('invoice');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
