<?php

namespace Database\Seeders;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Tạo 50 sản phẩm ảo
        for ($i = 0; $i < 50; $i++) {
            $product = new Product();
            $product->name = $faker->sentence(3);
            $product->price = $faker->randomFloat(2, 10, 100);
            $product->stock = $faker->numberBetween(0, 100);
            $product->status = $faker->randomElement(['available', 'unavailable']);
            $product->image = $faker->imageUrl(640, 480, 'cats');
            $product->description = $faker->paragraph(3);
            $product->save();
        }
    }
}
