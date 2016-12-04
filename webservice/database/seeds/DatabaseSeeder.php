<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Database tables.
     *
     * @var array
     */
    protected $tables = [
        'users',
        'products',
        'categories',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate();

        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
    }

    /**
     * Clear all tables in the database.
     *
     * @return void
     */
    protected function truncate()
    {
        Schema::disableForeignKeyConstraints();

        foreach ($this->tables as $name) {
            DB::table($name)->truncate();
        }

        Schema::enableForeignKeyConstraints();
    }
}
