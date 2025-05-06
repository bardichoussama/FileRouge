<?php

namespace Modules\EntretienIndividuel\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormulaireSeeder extends Seeder
{
    public function run()
    {
        DB::table('formulaires')->insert([
            [
                'titre' => 'Évaluation des compétences techniques',
                'description' => 'Formulaire pour évaluer les compétences techniques des apprenants',
                'deadline' => now()->addDays(7),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Bilan de progression',
                'description' => 'Formulaire pour faire le point sur la progression de l\'apprenant',
                'deadline' => now()->addDays(14),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
} 