<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DistributorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('distributors')->delete();
        
        \DB::table('distributors')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'PT Shiki Jaya Jaya',
                'address' => '13826 Meyers Rd',
                'phone_number' => '999820013611',
                'created_at' => '2026-02-13 15:23:36',
                'updated_at' => '2026-02-13 15:23:36',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'PT Sukses Yuei',
                'address' => '661720 Tokyo Rd',
                'phone_number' => '0997231723211',
                'created_at' => '2026-02-13 15:24:26',
                'updated_at' => '2026-02-13 15:24:26',
            ),
        ));
        
        
    }
}