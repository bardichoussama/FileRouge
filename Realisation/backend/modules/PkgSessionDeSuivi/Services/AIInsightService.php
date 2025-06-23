<?php

namespace Modules\PkgSessionDeSuivi\Services;

use Modules\PkgSessionDeSuivi\Domain\Interfaces\AIInsightRepositoryInterface;
use Modules\PkgSessionDeSuivi\Domain\Entities\AIInsight;
use Modules\PkgSessionDeSuivi\Domain\Entities\StudentCheckin;
use Exception;

class AIInsightService
{
    private AIInsightRepositoryInterface $aiInsightRepository;
    private GeminiService $geminiService;

    public function __construct(
        AIInsightRepositoryInterface $aiInsightRepository,
        GeminiService $geminiService
    ) {
        $this->aiInsightRepository = $aiInsightRepository;
        $this->geminiService = $geminiService;
    }



        public function generateInsightForStudentCheckin(int $studentCheckinId): AIInsight
    {
        try {
            // Get student checkin with related data
            $studentCheckin = $this->getStudentCheckinData($studentCheckinId);
            
            // Prepare data for AI analysis
            $studentData = $this->prepareStudentDataForAnalysis($studentCheckin);
            
            // Generate AI insight
            $insightText = $this->geminiService->analyzeStudentResponses($studentData);
            
            // Save insight to database
            $aiInsight = new AIInsight([
                'student_checkin_id' => $studentCheckinId,
                'insight_text' => $insightText,
                'type' => 'gemini_analysis'
            ]);
            
            return $this->aiInsightRepository->create($aiInsight);
            
        } catch (Exception $e) {
            throw new Exception('Failed to generate AI insight: ' . $e->getMessage());
        }
    }

    public function generateInsightsForCheckinForm(int $checkinFormId): array
    {
        try {
            $insights = [];
            $studentCheckins = $this->getStudentCheckinsByFormId($checkinFormId);
            
            foreach ($studentCheckins as $checkin) {
                $insights[] = $this->generateInsightForStudentCheckin($checkin->id);
            }
            
            return $insights;
        } catch (Exception $e) {
            throw new Exception('Failed to generate insights for form: ' . $e->getMessage());
        }
    }

    private function getStudentCheckinData(int $studentCheckinId)
    {
        // Use your existing StudentCheckin model with relationships
        // Adjust the model path according to your project structure
        $studentCheckin = \Modules\PkgSessionDeSuivi\Domain\Entities\StudentCheckin::with([
            'checkinForm',
            'student', 
            'answers.question'
        ])->find($studentCheckinId);

        if (!$studentCheckin) {
            throw new Exception("Student checkin with ID {$studentCheckinId} not found");
        }

        return $studentCheckin;
    }

    private function getStudentCheckinsByFormId(int $checkinFormId): \Illuminate\Database\Eloquent\Collection
    {
        return StudentCheckin::with([
            'checkinForm',
            'student',
            'answers.question'
        ])->where('checkin_form_id', $checkinFormId)->get();
    }

    private function prepareStudentDataForAnalysis(StudentCheckin $studentCheckin): array
    {
        // Use relation if it exists; attribute may contain raw string JSON which we ignore here
        $answersRelation = $studentCheckin->getRelation('answers');
        $answersCollection = $answersRelation instanceof \Illuminate\Support\Collection ? $answersRelation : collect();
        $answers = [];
        
        foreach ($answersCollection as $answer) {
            $answers[] = [
                'question' => $answer->question->question_text,
                'answer' => $answer->answer_text,
                'question_type' => $answer->question->question_type
            ];
        }
        
        return [
            'student_id' => $studentCheckin->student_id,
            'form_title' => $studentCheckin->checkinForm->title,
            'submitted_at' => $studentCheckin->created_at->format('Y-m-d H:i:s'),
            'answers' => $answers
        ];
    }




}