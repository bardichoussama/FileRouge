<?php

namespace Modules\EntretienIndividuel\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionReponseSeeder extends Seeder
{
    public function run()
    {
        // Get the first question (choix_unique)
        $question1 = DB::table('questions')
            ->where('type', 'choix_unique')
            ->first();

        // Get the second question (choix_multiple)
        $question2 = DB::table('questions')
            ->where('type', 'choix_multiple')
            ->first();

        // Options for choix_unique question
        DB::table('option_reponses')->insert([
            [
                'question_id' => $question1->id,
                'texte' => 'Débutant',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_id' => $question1->id,
                'texte' => 'Intermédiaire',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_id' => $question1->id,
                'texte' => 'Avancé',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Options for choix_multiple question
        DB::table('option_reponses')->insert([
            [
                'question_id' => $question2->id,
                'texte' => 'PHP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_id' => $question2->id,
                'texte' => 'JavaScript',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_id' => $question2->id,
                'texte' => 'Python',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
} 