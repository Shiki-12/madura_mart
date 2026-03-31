<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $statuses = ['pending', 'payment_verified', 'processed', 'shipped', 'arrived', 'completed', 'cancelled'];
        
        return [
            'invoice_number' => 'INV-' . now()->format('Ymd') . '-' . $this->faker->unique()->numberBetween(10000, 99999),
            'user_id' => 1, // To be overridden
            'courier_id' => null, // Optional
            'delivery_address' => $this->faker->address(),
            'order_date' => $this->faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d H:i:s'),
            'status' => $this->faker->randomElement($statuses),
            'payment_method' => $this->faker->randomElement(['transfer', 'cod']),
            'payment_proof' => null, // Set conditionally if verified
            'total_price' => 0, // Calculated later
            'notes' => $this->faker->optional(0.3)->sentence(),
        ];
    }
}
