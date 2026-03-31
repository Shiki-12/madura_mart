<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PurchasesTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('purchases')->delete();

        // ── Static baseline purchase (preserved) ──────────────────────────────
        \DB::table('purchases')->insert([
            'id'             => 1,
            'note_number'    => 'INV-2026-001',
            'purchase_date'  => '2026-02-13',
            'distributor_id' => 1,
            'total_price'    => 409500,
            'created_at'     => '2026-02-13 15:28:46',
            'updated_at'     => '2026-02-13 15:28:46',
        ]);

        $distributors = \App\Models\Distributor::pluck('id')->toArray();

        if (empty($distributors)) return;

        // ── 1. Historical spread: 20 random purchases over last 6 months ──────
        for ($i = 0; $i < 20; $i++) {
            \App\Models\Purchase::factory()->create([
                'distributor_id' => \Illuminate\Support\Arr::random($distributors),
            ]);
        }

        // ── 2. TODAY's batch: guarantee Today's Expense metric is non-zero ────
        $count = rand(1, 2);

        for ($i = 0; $i < $count; $i++) {
            $now = Carbon::now()->subMinutes(rand(0, 300)); // spread over last 5 hrs

            \App\Models\Purchase::factory()->create([
                'distributor_id' => \Illuminate\Support\Arr::random($distributors),
                'purchase_date'  => Carbon::today()->format('Y-m-d'),
                'created_at'     => $now,
                'updated_at'     => $now,
            ]);
        }
    }
}