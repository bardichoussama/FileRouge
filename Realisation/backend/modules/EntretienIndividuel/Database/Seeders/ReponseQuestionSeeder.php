<?php

namespace Modules\EntretienIndividuel\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReponseQuestionSeeder extends Seeder
{
    public function run()
    {
        // Get the first reponse_formulaire
        $reponseFormulaire = DB::table('reponse_formulaires')->first();

        // Get all questions for this formulaire
        $questions = DB::table('questions')
            ->where('formulaire_id', $reponseFormulaire->formulaire_id)
            ->get();

        foreach ($questions as $question) {
            DB::table('reponse_questions')->insert([
                [
                    'reponse_formulaire_id' => $reponseFormulaire->id,
                    'question_id' => $question->id,
                    'reponse_texte' => $question->type === 'texte_libre' ? 'Je souhaite améliorer mes compétences en développement web.' : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
    }
} 