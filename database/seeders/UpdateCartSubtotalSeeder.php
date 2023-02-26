<?php
use Illuminate\Database\Seeder;
use App\Models\Cart;

class UpdateCartSubtotalSeeder extends Seeder
{
    public function run()
    {
        $carts = Cart::with('items')->get();

        foreach ($carts as $cart) {
            $subtotal = $cart->items()->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });
            //$cart->subtotal = $subtotal;
            $cart->save();
        }
    }
}
