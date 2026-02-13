<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('products')->delete();
        
        \DB::table('products')->insert(array (
            0 => 
            array (
                'id' => 1,
                'distributor_id' => 2,
                'serial_number' => 'KKP-001',
                'name' => 'Kopi Hitam',
                'type' => 'Beverages',
                'description' => 'Kopi Penjamin Melek 100%',
                'expiration_date' => '2126-02-13',
                'price' => 5000,
                'stock' => 120,
                'picture' => 'product-images/ey9OrBK0KfvEJyWKDN5Edw5JepfFzyEuj6na15Xl.jpg',
                'is_active' => 1,
                'created_at' => '2026-02-13 15:26:41',
                'updated_at' => '2026-02-13 15:26:41',
            ),
            1 => 
            array (
                'id' => 2,
                'distributor_id' => 1,
                'serial_number' => 'KKT-001',
                'name' => 'Kentang Mustofa',
                'type' => 'Food & Snacks',
                'description' => 'kentang mustofa, untuk tambahan lauk di nasi dan juga nyemil',
                'expiration_date' => '2026-07-13',
                'price' => 21450,
                'stock' => 14,
                'picture' => 'product-images/12Miz3rh1D2qvwrahRx44qsNeHoFa40gFgNHDQjR.jpg',
                'is_active' => 1,
                'created_at' => '2026-02-13 15:28:04',
                'updated_at' => '2026-02-13 15:29:25',
            ),
            2 => 
            array (
                'id' => 3,
                'distributor_id' => 1,
                'serial_number' => 'CCV-001',
                'name' => 'Caviar',
                'type' => 'Food & Snacks',
                'description' => 'Caviar premium, very expensive',
                'expiration_date' => '2026-03-13',
                'price' => 10000000,
                'stock' => 3,
                'picture' => 'product-images/9haR8hcXI06IGnxZh8WIsAh1TjoidpA0tlPykHe4.jpg',
                'is_active' => 1,
                'created_at' => '2026-02-13 15:30:49',
                'updated_at' => '2026-02-13 15:30:49',
            ),
        ));
        
        
    }
}