<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => "Boneka", 'image' => "swee.jpeg"],
            ['name' => "Payung", 'image' => "folded.jpeg"],
            ['name' => "Sandal", 'image' => "sandal.jpeg"],
        ];
        $products = [
            ['name' => "Swee Orang Utan", 'image1' => 'product/swee.jpeg', 'price' => 255000, 'category_id' => 1],
            ['name' => "Pei Meerkart", 'image1' => 'product/pie.jpeg', 'price' => 255000, 'category_id' => 1],
            ['name' => "Baby Tiger", 'image1' => 'product/tiger.jpeg', 'price' => 255000, 'category_id' => 1],
            ['name' => "Giraffe Medium", 'image1' => 'product/giraffe.jpeg', 'price' => 350000, 'category_id' => 1],
            ['name' => "Ring Tailed Lemur", 'image1' => 'product/ring.jpeg', 'price' => 295000, 'category_id' => 1],
            ['name' => "Golf Umbrella", 'image1' => 'product/umbrella.jpeg', 'price' => 220000, 'category_id' => 2],
            ['name' => "Folded Umbrella", 'image1' => 'product/folded.jpeg', 'price' => 220000, 'category_id' => 2],
            ['name' => "Sandal Bali Zoo Kids", 'image1' => 'product/sandal.jpeg', 'price' => 65000, 'category_id' => 3],
            ['name' => "Sandal Bali Zoo Dewasa", 'image1' => 'product/sandal1.jpeg', 'price' => 65000, 'category_id' => 3],
        ];
        foreach ($products as $key => $item) {
            Product::factory()->recycle([Supplier::all()])->create([
                'name' => $item['name'],
                'category_id' => $item['category_id'],
                'sell_price' => $item['price'],
                'stock' => mt_rand(10, 20),
                'image1' => $item['image1'],
            ]);
        }
    }
}
