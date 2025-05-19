<?php

namespace Database\Seeders;

use App\Enums\UserRole;
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
            'user_name' => 'admin',
            'phone_number' => '98123456',
            'email' => 'admin@gmail.com',
            'role' => UserRole::Admin->value,
            'password' => '1234567',
        ]);

        $this->call([
            DrinkSeeder::class,
            FoodSeeder::class,
        ]);
    }
}
