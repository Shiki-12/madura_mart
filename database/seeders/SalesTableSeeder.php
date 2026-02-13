<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SalesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sales')->delete();
        
        \DB::table('sales')->insert(array (
            0 => 
            array (
                'id' => 1,
                'sale_date' => '2026-02-13',
                'total_price' => 407550,
                'user_id' => 2,
                'created_at' => '2026-02-13 15:29:25',
                'updated_at' => '2026-02-13 15:29:25',
            ),
        ));
        
        
    }
}