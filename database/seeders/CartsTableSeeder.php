<?php

namespace Database\Seeders;
use App\Models\Cart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
class CartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Tạo 50 giỏ hàng ảo
        for ($i = 0; $i < 50; $i++) {
            $user = User::inRandomOrder()->first();
            $cart = new Cart();
            $cart->user_id = $user->id;
            $cart->save();
        }
    }
}
