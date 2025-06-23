<?php

namespace Modules\PkgSessionDeSuivi\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgSessionDeSuivi\Domain\Entities\StudentCheckin;
use Modules\PkgApprenant\Models\Apprenant;
use Modules\PkgSessionDeSuivi\Domain\Entities\CheckinForm;

class StudentCheckinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apprenants = Apprenant::all();
        
        $checkinForms = CheckinForm::all();

        foreach ($apprenants as $apprenant) {
            // link student user id
            $form = $checkinForms->firstWhere('promotion_id', $apprenant->groupe->promotion_id);

            if ($form) {
                StudentCheckin::create([
                    'student_id' => $apprenant->user_id,
                    'checkin_form_id' => $form->id,
                 
                ]);
            }
        }
    }
}
