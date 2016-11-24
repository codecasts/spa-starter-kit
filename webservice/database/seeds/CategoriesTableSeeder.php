<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Product;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = \App::make('Faker\Generator');

        /**
        * Clear up the tables before adding new data
        */
        Category::truncate();
        Product::truncate();

        /**
        * Create 50 categories
        */
        factory(Category::class, 200)->create()->each(function ($category) use ($faker) {
            /**
            * For each category 2 to 5 products will
            * be created and assigned
            */
            $quantity = $faker->numberBetween(2, 5);

            /**
            * Generate in memory the products
            */
            $products = factory(Product::class, $quantity)->make();

            foreach ($products as $product) {
                /**
                * Using the relatioship save the products
                * to the category
                */
                $category->products()->save($product);
            }
        });
    }
}
