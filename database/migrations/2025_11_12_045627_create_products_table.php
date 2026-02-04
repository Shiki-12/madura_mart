<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distributor_id')->constrained('distributors')->onDelete('cascade');
            
            $table->string('serial_number', 20)->unique();
            $table->string('name', 50);
            $table->string('type', 50);
            $table->text('description')->nullable();
            $table->date('expiration_date')->nullable();
            $table->integer('price')->default(0);
            $table->integer('stock')->default(0);
            $table->string('picture')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};