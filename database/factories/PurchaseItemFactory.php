<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseItem>
 */
class PurchaseItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'purchase_id' => \App\Models\Purchase::factory(),
            'product_id' => \App\Models\Product::factory(),
            'qty' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'subtotal' => function (array $attributes) {
                return $attributes['qty'] * $attributes['price'];
            },
        ];
    }
}
