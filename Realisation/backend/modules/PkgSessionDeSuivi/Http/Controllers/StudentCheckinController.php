<?php

namespace Modules\PkgSessionDeSuivi\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\PkgSessionDeSuivi\Services\StudentCheckinService;
use Illuminate\Http\Request;

class StudentCheckinController extends Controller
{
    protected $studentCheckinService;
    public function __construct(StudentCheckinService $studentCheckinService)
    {
        $this->studentCheckinService = $studentCheckinService;
    }
    
    public function submitCheckin(Request $request)
    {
        $request->validate([
            'checkin_form_id' => 'required|exists:checkin_forms,id',
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.answer_text' => 'required|string',
        ]);

        $studentId = auth()->id();

        $checkin = $this->studentCheckinService->submitCheckin($request->all(), $studentId);

        return response()->json([
            'message' => 'Check-in submitted successfully.',
            'data' => $checkin,
        ]);
    }
    public function getMyCheckins()
    {
        $studentId = auth()->id();
        $checkins = $this->studentCheckinService->getMyCheckins($studentId);
        return response()->json($checkins);
    }
   

}
