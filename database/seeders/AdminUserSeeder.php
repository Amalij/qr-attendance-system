<?php
// database/seeders/AdminUserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@123.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create sample lecturer
        $lecturer = User::create([
            'name' => 'Amali',
            'email' => 'amali@123.com',
            'password' => Hash::make('Amali123'),
            'role' => 'lecturer',
        ]);

        // Create sample student
        User::create([
            'name' => 'Student ',
            'email' => 'student@123.com ',
            'password' => Hash::make('Student123'),
            'role' => 'student',
        ]);
    }
}