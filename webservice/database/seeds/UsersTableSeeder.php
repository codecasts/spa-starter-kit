<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'Happy Developer =D',
            'email' => 'happy.developer@vuejsisawesome.com',
            'password' => bcrypt(123456),
        ]);
    }
}
