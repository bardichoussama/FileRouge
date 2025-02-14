<?php

namespace Database\Seeders;
use App\Models\User;   // <-- Import User Model
use Illuminate\Database\Seeder;
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
            'name' => 'admin',       // <-- Change to 'name'
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'resposable_de_formation'  // Match the role exactly as in your enum
        ]);

        User::create([
            'name' => 'student',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role' => 'apprenant'
        ]);

        User::create([
            'name' => 'teacher',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'role' => 'formateur'
        ]);
    }
}
