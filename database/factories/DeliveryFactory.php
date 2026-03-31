<?php

namespace Database\Factories;

use App\Models\Delivery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Delivery>
 */
class DeliveryFactory extends Factory
{
    protected $model = Delivery::class;

    public function definition(): array
    {
        $statuses = ['assigned', 'picked_up', 'in_transit', 'delivered', 'failed'];

        return [
            'delivery_date' => clone $this->faker->dateTimeBetween('-6 months', 'now'),
            'expedition_id' => null, // Overridden
            'order_id' => null, // Overridden
            'courier_id' => null, // Overridden
            'picture_proof' => null,
            'invoice' => $this->faker->unique()->numberBetween(100000, 999999),
            'status' => $this->faker->randomElement($statuses),
            'notes' => $this->faker->optional(0.3)->sentence(),
        ];
    }
}
