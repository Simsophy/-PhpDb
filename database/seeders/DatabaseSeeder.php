<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'phy@gmail.com',
            'username' => 'admin',   // add username if you use username login
            'password' => bcrypt('12345678'), // your known password
        ]);
    }
}
