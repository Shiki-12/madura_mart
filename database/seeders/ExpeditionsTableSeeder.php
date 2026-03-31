<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ExpeditionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('expeditions')->delete();
        
        // Ensure static expeditions are kept if there were any, but there were none in the original.
        \App\Models\Expedition::factory()->count(8)->create();
    }
}