<?php

namespace Database\Seeders;

use App\Models\Pengiriman;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 5) as $key => $item) {
            $transaction = Transaction::create([
                'transaction_number' => Transaction::transactionNumberGenerator(),
                'total' => mt_rand(100, 300) * 1000,
                'status' => 'ordered',
                'user_id' => 1
            ]);

            Pengiriman::create([
                'transaction_id' => $transaction->id,
                'name' => fake()->name(),
                'phone' => fake()->phoneNumber(),
                'address' => fake()->address(),
                'province' => 'bali',
                'city' => 'denpasar',
                'district' => 'denpasar selatan',
                'village' => 'renon',
                'postal_code' => '80026',
                'district_id' => 123,
                'awb' => Transaction::transactionNumberGenerator(),
                'status' => 'set-pickup',
            ]);

            foreach (range(1, mt_rand(1, 5)) as $key => $item) {
                $product = Product::inRandomOrder()->first();
                $qty = mt_rand(1, 10);


                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'qty' => $qty,
                    'subtotal' => $product->price * $qty,
                ]);
            }
        }
    }
}
