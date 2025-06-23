<?php

namespace Modules\PkgSessionDeSuivi\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgSessionDeSuivi\Domain\Entities\StudentCheckinAnswer;
use Modules\PkgSessionDeSuivi\Domain\Entities\StudentCheckin;
use Modules\PkgSessionDeSuivi\Domain\Entities\Question;

class StudentCheckinAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $map = [
            'Comment évaluez-vous votre semaine ?' => 'Ma semaine était productive.',
            'Avez-vous rencontré des difficultés ?' => 'J’ai eu du mal avec le projet.',
            'Que souhaitez-vous améliorer ?' => 'Je souhaite améliorer ma gestion du temps.',
        ];

        $checkins = StudentCheckin::all();

        foreach ($checkins as $checkin) {
            $questions = Question::where('checkin_form_id', $checkin->checkin_form_id)->get();

            foreach ($questions as $question) {
                StudentCheckinAnswer::create([
                    'checkin_id' => $checkin->id,
                    'question_id' => $question->id,
                    'answer_text' => $map[$question->question_text] ?? 'Rien à signaler.',
                ]);
            }
        }
    }
}
