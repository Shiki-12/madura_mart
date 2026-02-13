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
        Schema::disableForeignKeyConstraints();

        $this->call([
            UsersTableSeeder::class,
            DistributorsTableSeeder::class,
            ExpeditionsTableSeeder::class,
            ProductsTableSeeder::class,
            PurchasesTableSeeder::class,
            OrdersTableSeeder::class,
            SalesTableSeeder::class,
            DeliveriesTableSeeder::class,
            PurchaseDetailsTableSeeder::class,
            SaleDetailsTableSeeder::class,
            OrderDetailsTableSeeder::class,
            OrderItemsTableSeeder::class,
        ]);

        Schema::enableForeignKeyConstraints();
        $this->call(UsersTableSeeder::class);
        $this->call(DistributorsTableSeeder::class);
        $this->call(ExpeditionsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(PurchasesTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(DeliveriesTableSeeder::class);
        $this->call(SalesTableSeeder::class);
        $this->call(PurchaseDetailsTableSeeder::class);
        $this->call(SaleDetailsTableSeeder::class);
        $this->call(OrderDetailsTableSeeder::class);
        $this->call(OrderItemsTableSeeder::class);
    }
}
