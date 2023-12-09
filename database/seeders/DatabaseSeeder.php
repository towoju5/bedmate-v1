<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $password = Hash::make('password');
        for ($i = 0; $i < 30; $i++) {
            User::factory()->create([
                'name' => fake()->name(),
                'email' => fake()->companyEmail(),
                'is_escort' => true,
                'password' => $password,
                'username' => fake()->userName(),
                'plans' => 'freemium'
            ]);
        }
    }
}
