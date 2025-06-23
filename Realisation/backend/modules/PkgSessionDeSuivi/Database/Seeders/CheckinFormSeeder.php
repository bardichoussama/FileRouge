<?php

namespace Modules\PkgSessionDeSuivi\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgSessionDeSuivi\Domain\Entities\CheckinForm;
use Modules\PkgApprenant\Models\Promotion;
use Carbon\Carbon;

class CheckinFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the latest promotion start date
        $latestDate = Promotion::max('start_date');
        // Fetch promotions earlier than the latest start date
        $promotions = Promotion::whereDate('start_date', '<', $latestDate)->get();

        foreach ($promotions as $promotion) {
            CheckinForm::create([
                'promotion_id' => $promotion->id,
                'title' => 'Suivi hebdomadaire',
                'description' => 'Formulaire de suivi pour la semaine',
                'is_active' => true,
                'start_date' => Carbon::now()->startOfWeek(),
                'end_date' => Carbon::now()->endOfWeek(),
            ]);
        }
    }
}
