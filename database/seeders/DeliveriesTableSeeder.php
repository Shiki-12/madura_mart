<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DeliveriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('deliveries')->delete();
        
        $orders = \App\Models\Order::whereIn('status', ['shipped', 'arrived', 'completed'])->get();
        $couriers = \App\Models\User::where('role', 'courier')->pluck('id')->toArray();
        $expeditions = \App\Models\Expedition::pluck('id')->toArray();
        
        foreach ($orders as $order) {
            $deliveryStatus = 'in_transit';
            if ($order->status == 'arrived') $deliveryStatus = 'delivered';
            if ($order->status == 'completed') $deliveryStatus = 'delivered';
            
            // Generate realistic delivery date slightly after order date
            $deliveryDate = \Carbon\Carbon::parse($order->order_date)->addDays(rand(1, 3));
            
            \App\Models\Delivery::factory()->create([
                'order_id' => $order->id,
                'courier_id' => !empty($couriers) ? \Illuminate\Support\Arr::random($couriers) : null,
                'expedition_id' => !empty($expeditions) ? \Illuminate\Support\Arr::random($expeditions) : null,
                'status' => $deliveryStatus,
                'delivery_date' => $deliveryDate->format('Y-m-d H:i:s'),
            ]);
            
            // Assign courier to the order as well for consistency
            if (!empty($couriers)) {
                $order->courier_id = \Illuminate\Support\Arr::random($couriers);
                $order->save();
            }
        }
    }
}