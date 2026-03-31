<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurchaseDetailsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('purchase_details')->delete();
        
        \DB::table('purchase_details')->insert(array (
            0 => 
            array (
                'id' => 1,
                'purchase_id' => 1,
                'product_id' => 2,
                'purchase_price' => 19500,
                'purchase_amount' => 21,
                'subtotal' => 409500,
                'selling_margin' => 10,
                'created_at' => '2026-02-13 15:28:46',
                'updated_at' => '2026-02-13 15:28:46',
            ),
        ));
        
        // Loop over the 20 newly generated purchases (ignoring the static 1) to attach items
        $purchases = \App\Models\Purchase::where('id', '!=', 1)->get();
        foreach ($purchases as $purchase) {
            $products = \App\Models\Product::where('distributor_id', $purchase->distributor_id)->pluck('id')->toArray();
            
            if (!empty($products)) {
                $itemCount = rand(1, 3);
                $total = 0;
                for ($j = 0; $j < $itemCount; $j++) {
                    $p_id = \Illuminate\Support\Arr::random($products);
                    
                    $detail = \App\Models\PurchaseDetail::factory()->create([
                        'purchase_id' => $purchase->id,
                        'product_id' => $p_id,
                    ]);
                    
                    $total += $detail->subtotal;
                    
                    // Increment stock realistically
                    $product = \App\Models\Product::find($p_id);
                    $product->stock += $detail->purchase_amount;
                    $product->save();
                }
                
                // Update parent purchase total
                $purchase->total_price = $total;
                $purchase->save();
            }
        }
    }
}