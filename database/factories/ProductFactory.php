<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(2, false),
            'category_id' => Category::factory(),
            'supplier_id' => Supplier::factory(),
            'price' => mt_rand(50, 300) * 1000,
            'stock' => mt_rand(50, 100),
            'image1' => 'product/pro1.jpg',
            'image2' => 'product/pro2.jpg',
            'image3' => 'product/pro3.jpg',
            'image4' => 'product/pro4.jpg',
            'description' => fake()->paragraph(5),
            'width' => mt_rand(50, 100),
            'height' => mt_rand(50, 100),
            'length' => mt_rand(50, 100),
            'weight' => mt_rand(1, 10),
        ];
    }
}
