<?php

namespace Database\Seeders;
use App\Models\Cart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Product;
class CartItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carts = Cart::all();
        $products = Product::all();

        foreach ($carts as $cart) {
            $num_items = rand(1, 5);
            $selected_products = $products->random($num_items);

            foreach ($selected_products as $product) {
                $quantity = rand(1, 3);
                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                ]);
            }
        }
    }
}
