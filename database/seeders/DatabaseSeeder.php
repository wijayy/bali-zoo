<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\Supplier;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@admin.com',
            'is_admin' => 1,
        ]);

        Category::factory(5)->create();

        Supplier::factory(5)->create();

        Product::factory(20)->recycle([Category::all(), Supplier::all()])->create();

        Review::factory(100)->recycle([User::all(), Product::all()])->create();

        $this->call(IndoRegionSeeder::class);

        $this->call(CouponSeeder::class);
    }
}
