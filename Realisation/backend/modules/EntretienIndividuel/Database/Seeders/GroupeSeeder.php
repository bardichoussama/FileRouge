<?php

namespace Modules\EntretienIndividuel\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupeSeeder extends Seeder
{
    public function run()
    {
        DB::table('groupes')->insert([
            [
                'nom' => 'Groupe A',
                'annee_promotion' => '2024',
                'description' => 'Premier groupe de formation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Groupe B',
                'annee_promotion' => '2024',
                'description' => 'Deuxième groupe de formation',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
} 