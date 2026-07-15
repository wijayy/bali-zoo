<?php

namespace Database\Seeders;

use App\Models\Alamat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlamatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (\App\Models\User::all() as $user) {
            Alamat::factory(1)->recycle($user)->create(['default' => true]);
            $user->alamats()->saveMany(Alamat::factory(3)->create());
        }
    }
}
