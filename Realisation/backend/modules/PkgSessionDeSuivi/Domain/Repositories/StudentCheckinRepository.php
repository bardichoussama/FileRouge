<?php

namespace Modules\PkgSessionDeSuivi\Domain\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\PkgSessionDeSuivi\Domain\Entities\StudentCheckin;
use Modules\PkgSessionDeSuivi\Domain\Interfaces\StudentCheckinRepositoryInterface;



use Modules\PkgSessionDeSuivi\Domain\Entities\StudentCheckinAnswer;
use Modules\PkgSessionDeSuivi\Domain\Entities\StudentCheckinForm;

class StudentCheckinRepository implements StudentCheckinRepositoryInterface
{
   protected $studentCheckinRepository;
   protected $studentCheckinAnswerRepository;
   public function __construct(StudentCheckin $studentCheckinRepository, StudentCheckinAnswer $studentCheckinAnswerRepository)
   {
       $this->studentCheckinRepository = $studentCheckinRepository;
       $this->studentCheckinAnswerRepository = $studentCheckinAnswerRepository;
   }
  
public function submitCheckin(array $data, int $studentId)
{
    return DB::transaction(function () use ($data, $studentId) {
        $checkin = $this->studentCheckinRepository->create([
            'student_id' => $studentId,
            'checkin_form_id' => $data['checkin_form_id'],
        ]);

        foreach ($data['answers'] as $answer) {
            $this->studentCheckinAnswerRepository->create([
                'checkin_id' => $checkin->id,
                'question_id' => $answer['question_id'],
                'answer_text' => $answer['answer_text'],
            ]);
        }

        return $checkin->load('answers');
    });
}
public function getMyCheckins($studentId)
{
    return $this->studentCheckinRepository::with(['checkinForm', 'answers.question'])
        ->where('student_id', $studentId)
        ->latest()
        ->get();
}


    
}       
