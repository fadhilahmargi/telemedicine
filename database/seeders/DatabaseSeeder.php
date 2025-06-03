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

        User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'profileImage' => null,
            'password' => bcrypt('twiw')
        ]);

        User::factory()->create([
            'name' => 'Penjaga',
            'username' => 'penjaga',
            'email' => 'penjaga@gmail.com',
            'role' => 'penjaga',
            'profileImage' => null,
            'password' => bcrypt('twiw')
        ]);

        User::factory()->create([
            'name' => 'Spesialis',
            'username' => 'spesialis',
            'email' => 'spesialis@gmail.com',
            'role' => 'spesialis',
            'profileImage' => null,
            'password' => bcrypt('twiw')
        ]);
    }
}
