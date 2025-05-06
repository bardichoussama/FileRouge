<?php

namespace Modules\EntretienIndividuel\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntretienApprenantSeeder extends Seeder
{
    public function run()
    {
        // Get all entretiens
        $entretiens = DB::table('entretiens')->get();

        // Get all apprenants
        $apprenants = DB::table('users')
            ->where('role', 'apprenant')
            ->get();

        foreach ($entretiens as $entretien) {
            // For each entretien, assign 2 random apprenants
            $selectedApprenants = $apprenants->random(2);
            
            foreach ($selectedApprenants as $apprenant) {
                DB::table('entretien_apprenant')->insert([
                    'entretien_id' => $entretien->id,
                    'apprenant_id' => $apprenant->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
} 