<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SaleDetailsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sale_details')->delete();
        
        \DB::table('sale_details')->insert(array (
            0 => 
            array (
                'id' => 1,
                'sale_id' => 1,
                'product_id' => 2,
                'selling_price' => 21450,
                'quantity' => 19,
                'subtotal' => 407550,
                'created_at' => '2026-02-13 15:29:25',
                'updated_at' => '2026-02-13 15:29:25',
            ),
        ));
        
        
    }
}