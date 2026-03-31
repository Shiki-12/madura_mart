<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SalesTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('sales')->delete();

        // ── Static baseline sale (preserved) ──────────────────────────────────
        \DB::table('sales')->insert([
            'id'          => 1,
            'sale_date'   => '2026-02-13',
            'total_price' => 407550,
            'user_id'     => 2,
            'created_at'  => '2026-02-13 15:29:25',
            'updated_at'  => '2026-02-13 15:29:25',
        ]);

        // ── Historical spread: random sales over last 6 months ────────────────
        $adminUser = \App\Models\User::where('role', 'owner')
                        ->orWhere('role', 'admin')
                        ->first();
        $userId = $adminUser ? $adminUser->id : 2;

        $sampleTotals = [85000, 126500, 210000, 54750, 310000, 175500, 92000, 440000];
        for ($i = 0; $i < 30; $i++) {
            $date = Carbon::now()->subDays(rand(1, 180));
            \DB::table('sales')->insert([
                'sale_date'   => $date->format('Y-m-d'),
                'total_price' => $sampleTotals[array_rand($sampleTotals)] + rand(-10000, 50000),
                'user_id'     => $userId,
                'created_at'  => $date,
                'updated_at'  => $date,
            ]);
        }

        // ── TODAY's batch: guarantee dashboard metrics are non-zero ───────────
        $todayCount = rand(3, 5);
        for ($i = 0; $i < $todayCount; $i++) {
            $now = Carbon::now()->subMinutes(rand(0, 480)); // spread over last 8 hrs
            \DB::table('sales')->insert([
                'sale_date'   => Carbon::today()->format('Y-m-d'),
                'total_price' => $sampleTotals[array_rand($sampleTotals)] + rand(0, 30000),
                'user_id'     => $userId,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }
    }
}