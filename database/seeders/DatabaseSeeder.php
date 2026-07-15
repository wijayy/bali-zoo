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
        $this->seedMainDatabase();
        $this->seedSecondDatabase();
    }

    public function seedSecondDatabase(): void
    {
        // Set connection to mysql2 for coupon seeding
        config(['database.default' => 'mysql2']);
        $this->call(CouponSeeder::class);
        // Reset back to mysql
        config(['database.default' => 'mysql']);
    }

    public function seedMainDatabase(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@admin.com',
            'is_admin' => 1,
        ]);

        foreach (range(1, 10) as $key => $item) {
            User::factory()->create([
                'name' => "User $item",
                'email' => "user$item@example.com",
                'is_admin' => 0,
            ]);
        }

        $categories = [
            ['name' => "Boneka", 'image' => "category/swee.jpeg"],
            ['name' => "Payung", 'image' => "category/folded.jpeg"],
            ['name' => "Sandal", 'image' => "category/sandal.jpeg"],
        ];

        foreach ($categories as $item) {
            Category::factory()->create([
                'name' => $item['name'],
                'image' => $item['image'],
            ]);
        }
        foreach (range(1, 1) as $key => $item) {

            Supplier::factory()->create([
                'name' => "Supplier $item",
            ]);
        }


        $this->call(ProductSeeder::class);

        // Product::factory(20)->recycle([Category::all(), Supplier::all()])->create();

        Review::factory(100)->recycle([User::all(), Product::all()])->create();

        $this->call(IndoRegionSeeder::class);
        $this->call(AlamatSeeder::class);

        $this->call(BannerSeeder::class);
        // $this->call(TransactionSeeder::class);
    }
}
