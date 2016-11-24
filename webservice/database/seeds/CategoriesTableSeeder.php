<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = \App::make('Faker\Generator');

        /**
        * Clear up the tables before adding new data
        */
        \App\Category::truncate();
        \App\Product::truncate();

        /**
        * Create 50 categories
        */
        factory(\App\Category::class, 5000)->create()->each(function ($category) use ($faker) {
            /**
            * For each category 3 to 30 products will
            * be created and assigned
            */
            $quantity = $faker->numberBetween(1, 3);

            /**
            * Generate in memory the products
            */
            $products = factory(\App\Product::class, $quantity)->make();

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
