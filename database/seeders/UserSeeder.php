<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'phone' => '123-456-7890',
            'address' => '123 Admin St, Admin City',
            'role' => 'admin',
            'photo' => 'Golang.png',
        ]);

        // Create Regular User
        User::create([
            'name' => 'Regular User',
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone' => '098-765-4321',
            'address' => '456 User Ave, User Town',
            'role' => 'user',
            'photo' => null, // Assuming no photo for seeder
        ]);
    }
}

