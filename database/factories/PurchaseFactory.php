<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'purchase_date' => $this->faker->date(),
            'total' => $this->faker->randomFloat(2, 100, 1000),
            'payment_method' => $this->faker->randomElement(['cash', 'credit_card', 'bank_transfer']),
            'status' => $this->faker->randomElement(['pending', 'completed', 'canceled']),
            'purchase_number' => 'PO-' . $this->faker->unique()->numerify('######'),
        ];
    }
}
