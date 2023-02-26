<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use Faker\Factory as Faker;
class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            $num_orders = rand(1, 3);

            for ($i = 0; $i < $num_orders; $i++) {
                $order = $user->orders()->create([
                    'status' => 'pending',
                    'shipping_address' => $user->address,
                ]);

                $num_items = rand(1, 5);
                $selected_products = Product::all()->random($num_items);

                foreach ($selected_products as $product) {
                    $quantity = rand(1, 3);
                    $price = $product->price;
                    $order->items()->create([
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                    ]);
                }
            }
        }
    }
}
