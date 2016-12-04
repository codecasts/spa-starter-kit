<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Happy Developer =D',
            'email' => 'happy.developer@vuejsisawesome.com',
            'password' => Hash::make(123456),
        ]);
    }
}
