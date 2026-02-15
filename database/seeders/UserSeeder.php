<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Lecturer',
            'email' => 'lecturer@example.com',
            'password' => Hash::make('password123'),
            'role' => 'lecturer'
        ]);

        User::create([
            'name' => 'Student',
            'email' => 'student@example.com',
            'password' => Hash::make('password123'),
            'role' => 'student'
        ]);
    }
}