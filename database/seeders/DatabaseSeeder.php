<?php

namespace Database\Seeders;
use Database\Seeders\ProductsTableSeeder;
use Database\Seeders\CartsTableSeeder;
use Database\Seeders\CartItemTableSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(ProductsTableSeeder::class);
        //$this->call(CartsTableSeeder::class);
        $this->call(OrderItemTableSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
