<?php

namespace Database\Factories;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        return [
            'order_id' => 1, // Overridden
            'product_id' => 1, // Overridden
            'product_name' => 'Sample Product', // Overridden
            'quantity' => $this->faker->numberBetween(1, 5),
            'price' => 10000, // Overridden
            'subtotal' => 0, // Quantity * Price
        ];
    }
}
