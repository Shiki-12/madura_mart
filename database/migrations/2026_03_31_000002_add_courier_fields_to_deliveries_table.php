<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add courier_id, status, and notes to deliveries table
     * to support courier-side delivery tracking.
     */
    public function up(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->foreignId('courier_id')
                  ->nullable()
                  ->after('order_id')
                  ->constrained('users')
                  ->onDelete('set null');

            $table->enum('status', ['assigned', 'picked_up', 'in_transit', 'delivered', 'failed'])
                  ->default('assigned')
                  ->after('picture_proof');

            $table->text('notes')->nullable()->after('status');

            // Make picture_proof nullable (courier uploads it later)
            $table->string('picture_proof')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropForeign(['courier_id']);
            $table->dropColumn(['courier_id', 'status', 'notes']);
        });
    }
};
