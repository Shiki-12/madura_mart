<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 0. Copy default avatar to storage/profile_pictures only
        $sourceImage = public_path('images/mizuki_akiyama.jpeg');
        if (file_exists($sourceImage)) {
            \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('profile_pictures');
            \Illuminate\Support\Facades\Storage::disk('public')->put('profile_pictures/default.jpeg', file_get_contents($sourceImage));
        }

        Schema::disableForeignKeyConstraints();

        // 1. Core tables first
        $this->call(UsersTableSeeder::class);
        $this->call(DistributorsTableSeeder::class);
        $this->call(ExpeditionsTableSeeder::class);
        
        // 2. Products table
        $this->call(ProductsTableSeeder::class);
        
        // 3. Independent tables
        $this->call(SalesTableSeeder::class);
        $this->call(SaleDetailsTableSeeder::class);
        
        // 4. Procurement Flow
        $this->call(PurchasesTableSeeder::class);
        $this->call(PurchaseDetailsTableSeeder::class);
        
        // 5. Sales Flow
        $this->call(OrdersTableSeeder::class);
        $this->call(OrderItemsTableSeeder::class);
        $this->call(DeliveriesTableSeeder::class);

        Schema::enableForeignKeyConstraints();
    }
}
