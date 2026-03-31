<?php

namespace Database\Factories;

use App\Models\PurchaseDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseDetail>
 */
class PurchaseDetailFactory extends Factory
{
    protected $model = PurchaseDetail::class;

    public function definition(): array
    {
        $purchase_price = $this->faker->numberBetween(4, 90) * 1000;
        $purchase_amount = $this->faker->numberBetween(10, 50);

        return [
            'purchase_id' => 1, // To be overridden
            'product_id' => 1, // To be overridden
            'purchase_price' => $purchase_price,
            'purchase_amount' => $purchase_amount,
            'subtotal' => $purchase_price * $purchase_amount,
            'selling_margin' => $this->faker->numberBetween(10, 30), // 10% to 30% margin
        ];
    }
}
