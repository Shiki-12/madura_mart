<?php

namespace Database\Factories;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition(): array
    {
        return [
            'note_number' => $this->faker->unique()->numerify('PO-###########'),
            'purchase_date' => $this->faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'distributor_id' => 1, // Will be overridden in seeder
            'total_price' => 0, // Will be calculated after adding details
        ];
    }
}
