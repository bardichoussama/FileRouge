<?php

namespace Modules\EntretienIndividuel\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntretienSeeder extends Seeder
{
    public function run()
    {
        // Get IDs
        $responsableId = DB::table('users')
            ->where('role', 'responsable')
            ->first()
            ->id;

        $groupeId = DB::table('groupes')
            ->first()
            ->id;

        $formulaireId = DB::table('formulaires')
            ->first()
            ->id;

        DB::table('entretiens')->insert([
            [
                'titre' => 'Premier entretien de suivi',
                'description' => 'Entretien pour faire le point sur la progression',
                'date_heure' => now()->addDays(2),
                'duree_minutes' => 60,
                'responsable_id' => $responsableId,
                'groupe_id' => $groupeId,
                'formulaire_id' => $formulaireId,
                'statut' => 'planifié',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Bilan intermédiaire',
                'description' => 'Évaluation des compétences acquises',
                'date_heure' => now()->addDays(7),
                'duree_minutes' => 45,
                'responsable_id' => $responsableId,
                'groupe_id' => $groupeId,
                'formulaire_id' => null,
                'statut' => 'planifié',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
} 