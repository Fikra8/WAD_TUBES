<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create default admin account
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'usertype' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create default owner account
        User::create([
            'name' => 'Owner User',
            'email' => 'owner@gmail.com',
            'password' => bcrypt('owner123'),
            'usertype' => 'owner',
            'email_verified_at' => now(),
        ]);

        // Create default customer account
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@gmail.com',
            'password' => bcrypt('customer123'),
            'usertype' => 'customer',
            'email_verified_at' => now(),
        ]);
    }
}
