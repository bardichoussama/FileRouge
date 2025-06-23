<?php

namespace Modules\PkgApprenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgApprenant\Models\Groupe;
use Modules\PkgApprenant\Models\Promotion;

class GroupeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promotions = Promotion::all();

        foreach ($promotions as $promotion) {
            Groupe::create([
                'nom' => 'Groupe A',
                'description' => 'Groupe A de la promotion ' . $promotion->start_year,
                'promotion_id' => $promotion->id,
            ]);

            Groupe::create([
                'nom' => 'Groupe B',
                'description' => 'Groupe B de la promotion ' . $promotion->start_year,
                'promotion_id' => $promotion->id,
            ]);
        }
    }
}
