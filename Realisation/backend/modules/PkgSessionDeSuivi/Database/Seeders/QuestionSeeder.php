<?php

namespace Modules\PkgSessionDeSuivi\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgSessionDeSuivi\Domain\Entities\Question;
use Modules\PkgSessionDeSuivi\Domain\Entities\CheckinForm;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $forms = CheckinForm::all();

        foreach ($forms as $form) {
            Question::create([
                'checkin_form_id' => $form->id,
                'question_text' => 'Comment évaluez-vous votre semaine ?',
                'question_type' => 'text',
            ]);

            Question::create([
                'checkin_form_id' => $form->id,
                'question_text' => 'Avez-vous rencontré des difficultés ?',
                'question_type' => 'text',
            ]);

            Question::create([
                'checkin_form_id' => $form->id,
                'question_text' => 'Que souhaitez-vous améliorer ?',
                'question_type' => 'text',
            ]);
        }
    }
}
