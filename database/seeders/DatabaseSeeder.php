<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Generate Default Admin Account
        User::create([
            'full_name' => 'Administrator',
            'username'  => 'admin',
            'email'     => 'admin@ourcoffee.com',
            'password'  => Hash::make('password'),
            'role'      => 'admin',
        ]);

        // 2. Generate Default Kasir Account
        User::create([
            'full_name' => 'Kasir OurCoffee',
            'username'  => 'kasir',
            'email'     => 'kasir@ourcoffee.com',
            'password'  => Hash::make('kasir123'),
            'role'      => 'kasir',
        ]);

        // 3. Generate Dummy Customer 'lipi'
        User::create([
            'full_name' => 'Lipi Customer',
            'username'  => 'lipi',
            'email'     => 'lipi@gmail.com',
            'password'  => Hash::make('lipi123'),
            'role'      => 'customer',
        ]);

        // 4. Call Product Seeder to load all 13 products
        $this->call([
            ProductSeeder::class
        ]);
    }
}
