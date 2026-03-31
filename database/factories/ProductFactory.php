<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Distributor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['Food & Snacks', 'Beverages', 'Daily Needs'];
        $productNames = [
            'Mie Instan Goreng', 'Beras Ramos 5kg', 'Gula Pasir 1kg', 'Minyak Goreng 2L', 'Kopi Susu Sachet', 
            'Teh Celup Kotak', 'Susu Kental Manis', 'Sabun Mandi', 'Sampo Botol', 'Deterjen Bubuk',
            'Saus Sambal Botol', 'Pasta Gigi', 'Keripik Kentang', 'Wafer Coklat', 'Minuman Isotonik'
        ];

        return [
            // Ensure distributor_id is either an existing one or create a new via factory. 
            // Better to rely on seeder for logic. Default to 1.
            'distributor_id' => 1, 
            'serial_number' => strtoupper(Str::random(3)) . '-' . $this->faker->unique()->numberBetween(100, 999),
            'name' => $this->faker->randomElement($productNames) . ' ' . $this->faker->word(),
            'type' => $this->faker->randomElement($types),
            'description' => $this->faker->sentence(),
            'expiration_date' => $this->faker->dateTimeBetween('now', '+2 years')->format('Y-m-d'),
            'price' => $this->faker->numberBetween(5, 100) * 1000,
            'stock' => $this->faker->numberBetween(0, 150),
            'picture' => null,
            'is_active' => true,
        ];
    }
}
