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
            'postal_code' => '80225',
            'alamat' => "Jalan " . fake()->streetName() . ", RT " . fake()->randomDigit() . "/RW " . fake()->randomDigit() . ", Desa Panjer",
            'user_id' => \App\Models\User::factory(),
            'province' => "BALI",
            'regency' => "DENPASAR",
            'district' => "DENPASAR SELATAN",
            'village' => 'PANJER',
            'province_id' => 0,
            'regency_id' => 0,
            'district_id' => 0,
            'village_id' => 0,

        ];
    }
}