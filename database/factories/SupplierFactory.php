<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => fake()->sentence(2, false),
            "address" => fake()->sentence(2, false),
            "person" => fake()->sentence(2, false),
            "email" => fake()->unique()->safeEmail(),
            "phone" => fake()->phoneNumber(),
        ];
    }
}
