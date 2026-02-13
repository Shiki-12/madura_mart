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
        
        
    }
}