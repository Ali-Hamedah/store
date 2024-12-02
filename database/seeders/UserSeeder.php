<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Ali Hamedah',
            'email' => 'aliali735522@gmail.com',
            'password' => Hash::make('12345678'),
            'phone_number' => '068181863821',
            'country' => fake()->countryCode(),
        ]);
        User::create([
            'name' => 'Store',
            'email' => 'aliali773355@gmail.com',
            'password' => Hash::make('12345678'),
            'phone_number' => '068181863821',
            'country' => fake()->countryCode(),
        ]);
    }
}
