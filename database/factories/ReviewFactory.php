<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $number = mt_rand(1, 10);
        return [
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'rate' => mt_rand(1, 5),
            "review" => fake()->paragraph(rand(1, 5)),
            'image' => $number < 3 ? 'review/rev1.jpg' : ''
        ];
    }
}
