<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrderItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('order_items')->delete();
        
        $orders = \App\Models\Order::all();
        $products = \App\Models\Product::all();
        
        if ($products->count() > 0) {
            foreach ($orders as $order) {
                $itemCount = rand(1, 4);
                $total = 0;
                $shuffledProducts = $products->shuffle()->take($itemCount);
                
                foreach ($shuffledProducts as $product) {
                    $item = \App\Models\OrderItem::factory()->create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'price' => $product->price,
                    ]);
                    
                    $item->subtotal = $item->price * $item->quantity;
                    $item->save();
                    
                    $total += $item->subtotal;
                    
                    // Deduct stock realistically (but don't go negative)
                    if ($product->stock >= $item->quantity) {
                        $product->stock -= $item->quantity;
                    } else {
                        $product->stock = 0;
                    }
                    $product->save();
                }
                
                // Update parent order total
                $order->total_price = $total;
                $order->save();
            }
        }
    }
}