<?php

namespace Modules\EntretienIndividuel\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        // Get the first formulaire ID
        $formulaireId = DB::table('formulaires')->first()->id;

        DB::table('questions')->insert([
            [
                'formulaire_id' => $formulaireId,
                'enonce' => 'Comment évaluez-vous votre niveau en programmation ?',
                'type' => 'choix_unique',
                'ordre' => 1,
                'obligatoire' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'formulaire_id' => $formulaireId,
                'enonce' => 'Quelles technologies maîtrisez-vous ?',
                'type' => 'choix_multiple',
                'ordre' => 2,
                'obligatoire' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'formulaire_id' => $formulaireId,
                'enonce' => 'Quels sont vos objectifs pour les prochains mois ?',
                'type' => 'texte_libre',
                'ordre' => 3,
                'obligatoire' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
} 