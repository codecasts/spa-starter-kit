<?php

use App\Product;
use App\Category;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::all();

        factory(Product::class, 200)->make()->each(function ($product) use ($categories) {
            $product->category()->associate($categories->random())->save();
        });
    }
}
