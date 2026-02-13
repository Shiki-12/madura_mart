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
        
        
        
    }
}