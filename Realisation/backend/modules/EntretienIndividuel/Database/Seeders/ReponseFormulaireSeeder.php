<?php

namespace Modules\EntretienIndividuel\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReponseFormulaireSeeder extends Seeder
{
    public function run()
    {
        // Get the first entretien with a formulaire
        $entretien = DB::table('entretiens')
            ->whereNotNull('formulaire_id')
            ->first();

        // Get an apprenant from the entretien_apprenant table
        $apprenant = DB::table('entretien_apprenant')
            ->where('entretien_id', $entretien->id)
            ->first();

        DB::table('reponse_formulaires')->insert([
            [
                'formulaire_id' => $entretien->formulaire_id,
                'apprenant_id' => $apprenant->apprenant_id,
                'date_soumission' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
} 