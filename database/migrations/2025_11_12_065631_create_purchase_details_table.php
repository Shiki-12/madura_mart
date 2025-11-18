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
        Schema::create('purchase_details', function (Blueprint $table) {
        $table->id();

        // CHANGED: Use string() to match the 'note_number' column type
        $table->string('note_number_purchase', 15)->nullable();

        // CHANGED: Use string() to match the 'serial_number' column type
        $table->string('serial_number_product', 10)->nullable();

        $table->integer('purchase_price')->default(0);
        $table->smallInteger('selling_margin')->default(0);
        $table->integer('purchase_amount')->default(0);
        $table->integer('subtotal')->default(0);

        $table->foreign('note_number_purchase')
              ->references('note_number')
              ->on('purchases')
              ->onUpdate('cascade')
              ->onDelete('cascade');

        $table->foreign('serial_number_product')
              ->references('serial_number')
              ->on('products')
              ->onUpdate('cascade')
              ->onDelete('cascade');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
