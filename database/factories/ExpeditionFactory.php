<?php

namespace Database\Factories;

use App\Models\Expedition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expedition>
 */
class ExpeditionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Expedition::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $logistics = ['JNE', 'J&T Express', 'SiCepat Ekspres', 'Ninja Xpress', 'Anteraja', 'Gojek', 'GrabExpress', 'Pos Indonesia'];

        return [
            'name' => $this->faker->unique()->randomElement($logistics),
            'address' => $this->faker->address(),
            'phone_number' => $this->faker->numerify('08##########'),
            'picture' => null,
        ];
    }
}
