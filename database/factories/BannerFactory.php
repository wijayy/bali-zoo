<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Banner>
 */
class BannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'slug' => $this->faker->slug(),
            'image' => $this->faker->imageUrl(800, 400, 'animals', true),
            'startShow' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'endShow' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
        ];
    }
}
