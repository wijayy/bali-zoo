<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alamat>
 */
class AlamatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $village = \App\Models\Village::inRandomOrder()->first();
        return [
            'nama' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'postal_code' => '80226',
            'alamat' => "Jalan " . fake()->streetName() . ", RT " . fake()->randomDigit() . "/RW " . fake()->randomDigit() . ", Desa Panjer",
            'user_id' => \App\Models\User::factory(),
            'province' => "BALI",
            'regency' => "DENPASAR",
            'district' => "DENPASAR SELATAN",
            'village' => 'PANJER',
            'province_id' => 15,
            'regency_id' => 201,
            'district_id' => 2175,
            'village_id' => 26041,
        ];
    }
}