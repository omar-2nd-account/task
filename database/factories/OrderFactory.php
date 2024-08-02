<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductCode;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_name' => $this->faker->name,
            'phone_number' => $this->faker->phoneNumber,
            'product_code' => ProductCode::factory()->create()->id,
            'final_price' => $this->faker->randomFloat(3, 0, 999999),
            'quantity' => $this->faker->randomDigit,
        ];
    }
}
