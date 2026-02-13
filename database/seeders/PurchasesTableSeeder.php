<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurchasesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('purchases')->delete();
        
        \DB::table('purchases')->insert(array (
            0 => 
            array (
                'id' => 1,
                'note_number' => 'INV-2026-001',
                'purchase_date' => '2026-02-13',
                'distributor_id' => 1,
                'total_price' => 409500,
                'created_at' => '2026-02-13 15:28:46',
                'updated_at' => '2026-02-13 15:28:46',
            ),
        ));
        
        
    }
}