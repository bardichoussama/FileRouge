<?php

namespace Modules\EntretienIndividuel\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create 2 responsables
        DB::table('users')->insert([
            [
                'name' => 'Jean Dupont',
                'email' => 'jean.dupont@example.com',
                'password' => Hash::make('password'),
                'role' => 'responsable',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Marie Martin',
                'email' => 'marie.martin@example.com',
                'password' => Hash::make('password'),
                'role' => 'responsable',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Get group IDs
        $groupA = DB::table('groupes')->where('nom', 'Groupe A')->first()->id;
        $groupB = DB::table('groupes')->where('nom', 'Groupe B')->first()->id;

        // Create 2 apprenants with group assignments
        DB::table('users')->insert([
            [
                'name' => 'Pierre Durand',
                'email' => 'pierre.durand@example.com',
                'password' => Hash::make('password'),
                'role' => 'apprenant',
                'group_id' => $groupA,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sophie Bernard',
                'email' => 'sophie.bernard@example.com',
                'password' => Hash::make('password'),
                'role' => 'apprenant',
                'group_id' => $groupB,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
} 