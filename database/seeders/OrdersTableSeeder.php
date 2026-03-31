<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('orders')->delete();

        $users = \App\Models\User::where('role', 'customer')->pluck('id')->toArray();

        if (empty($users)) return;

        // ── 1. Historical spread: 50 orders across the last 6 months ──────────
        for ($i = 0; $i < 50; $i++) {
            \App\Models\Order::factory()->create([
                'user_id' => \Illuminate\Support\Arr::random($users),
            ]);
        }

        // ── 2. TODAY's batch: guarantee dashboard metrics are non-zero ─────────
        $todayStatuses = ['completed', 'completed', 'payment_verified', 'processed', 'pending'];
        shuffle($todayStatuses);
        $count = rand(3, 5);

        for ($i = 0; $i < $count; $i++) {
            $now = Carbon::now()->subMinutes(rand(0, 480)); // spread over last 8 hrs

            \App\Models\Order::factory()->create([
                'user_id'      => \Illuminate\Support\Arr::random($users),
                'status'       => $todayStatuses[$i % count($todayStatuses)],
                'order_date'   => $now->format('Y-m-d H:i:s'),
                'created_at'   => $now,
                'updated_at'   => $now,
            ]);
        }
    }
}