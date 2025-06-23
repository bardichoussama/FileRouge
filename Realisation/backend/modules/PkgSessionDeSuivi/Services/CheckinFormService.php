<?php

namespace Modules\PkgSessionDeSuivi\Services;

use Modules\PkgSessionDeSuivi\Domain\Interfaces\CheckinFormRepositoryInterface;
use Modules\PkgSessionDeSuivi\Domain\Interfaces\QuestionRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\PkgSessionDeSuivi\Services\PromotionService;

class CheckinFormService implements CheckinFormRepositoryInterface
{
    protected $checkinFormRepository;
    protected $questionRepository;
    protected $promotionService;
    public function __construct(CheckinFormRepositoryInterface $checkinFormRepository, QuestionRepositoryInterface $questionRepository, PromotionService $promotionService)
    {
        $this->checkinFormRepository = $checkinFormRepository;
        $this->questionRepository = $questionRepository;
        $this->promotionService = $promotionService;
    }
    public function getAll()
    {
        return $this->checkinFormRepository->getAll();
    }
   // Interface-required methods - basic form operations without questions
   public function create($data)
   {
       return DB::transaction(function () use ($data) {
           $startDate = $data['start_date'] ?? Carbon::now()->toDateString();
           $endDate = $data['end_date'] ?? Carbon::now()->toDateString();

           $promotion = $this->promotionService->getActivePromotion();
           
           return $this->checkinFormRepository->create([
               'promotion_id' => $promotion ? $promotion->id : null,
               'title' => $data['title'],
               'description' => $data['description'] ?? null,
               'is_active' => $data['is_active'] ?? false,
               'start_date' => $startDate,
               'end_date' => $endDate,
           ]);
       });
   }

   public function update($id, $data)
   {
       return DB::transaction(function () use ($id, $data) {
           $existingForm = $this->checkinFormRepository->getById($id);
           $startDate = $data['start_date'] ?? $existingForm->start_date;
           $endDate = $data['end_date'] ?? $existingForm->end_date;
           
           return $this->checkinFormRepository->update($id, [
               'promotion_id' => $existingForm->promotion_id,
               'title' => $data['title'],
               'description' => $data['description'] ?? null,
               'is_active' => $data['is_active'] ?? false,
               'start_date' => $startDate,
               'end_date' => $endDate,
           ]);
       });
   }
  
   public function createFormWithQuestions($data)
   {
       return DB::transaction(function () use ($data) {
           // Create the form first using the basic create method
           $form = $this->create($data);
   
           // Then add questions if provided
           if (isset($data['questions']) && is_array($data['questions'])) {
               foreach ($data['questions'] as $question) {
                   $this->questionRepository->create([
                       'checkin_form_id' => $form->id,
                       'question_text' => $question['question_text'],
                       'question_type' => $question['question_type'],
                   ]);
               }
           }
   
           return $form->load('questions');
       });
   }
   
   public function updateFormWithQuestions($id, $data)
   {
       return DB::transaction(function () use ($id, $data) {
           // Update the form first using the basic update method
           $this->update($id, $data);
   
           // Then handle questions if provided
           if (isset($data['questions']) && is_array($data['questions'])) {
               $existingQuestionIds = collect($data['questions'])->pluck('id')->filter()->toArray();
   
               // Delete questions not in the update payload
               $this->questionRepository->deleteWhereNotInForm($id, $existingQuestionIds);
   
               // Loop through questions to update or create
               foreach ($data['questions'] as $question) {
                   if (isset($question['id'])) {
                       // Update existing question
                       $this->questionRepository->update($question['id'], [
                           'question_text' => $question['question_text'],
                           'question_type' => $question['question_type'],
                       ]);
                   } else {
                       // Create new question
                       $this->questionRepository->create([
                           'checkin_form_id' => $id,
                           'question_text' => $question['question_text'],
                           'question_type' => $question['question_type'],
                       ]);
                   }
               }
           }
   
           return $this->checkinFormRepository->getById($id)->load('questions');
       });
   }   

    public function getById($id){
        return $this->checkinFormRepository->getById($id);
    }
    public function deleteFormQuestions($id){
        return $this->checkinFormRepository->delete($id);
    } 

 

    public function delete($id)
    {
        return $this->deleteFormQuestions($id);
    }
    public function getAvailableFormsForStudent($studentId)
    {
        return $this->checkinFormRepository->getAvailableFormsForStudent($studentId);
    }
    public function getFormWithQuestions($formId)
    {
        return $this->checkinFormRepository->getFormWithQuestions($formId);
    }

    public function getFormWithResponsesAndInsights($formId)
    {
        $checkins = $this->checkinFormRepository->getFormWithResponsesAndInsights($formId);
        
        return $checkins->map(function ($checkin) {
            return [
                'id' => $checkin->id,
                'student_id' => $checkin->student->id,
                'student_name' => $checkin->student->name,
                'student_promotion' => $checkin->student->apprenant->groupe->promotion->year ?? null,
                'student_group' => $checkin->student->apprenant->groupe->nom ?? null,
                'student_email' => $checkin->student->email,
                'submitted_at' => $checkin->created_at,
                'answers_count' => $checkin->answers()->count(),
                'answers' => $checkin->answers()->get()->map(function ($answer) {
                    return [
                        'question_id' => $answer->question_id,
                        'question_text' => $answer->question->question_text,
                        'answer_text' => $answer->answer_text
                    ];
                }),
                'insights' => $checkin->aiInsights->map(function ($insight) {
                    return [
                        'id' => $insight->id,
                        'insight_text' => $insight->insight_text,
                        'type' => $insight->type,
                        'created_at' => $insight->created_at
                    ];
                })
            ];
        });
    }

    
}
