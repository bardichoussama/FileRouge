<?php

namespace Modules\PkgSessionDeSuivi\Http\Controllers;

use App\Http\Controllers\Controller;   
use Modules\PkgSessionDeSuivi\Services\CheckinFormService;
use Modules\PkgSessionDeSuivi\Http\Requests\CheckinFormRequest;

class CheckinFormController extends Controller
{
    protected $checkinFormService;
    public function __construct(CheckinFormService $checkinFormService)
    {
        $this->checkinFormService = $checkinFormService;
    }
    public function getAll()
    {
        return $this->checkinFormService->getAll();
    }
    public function create(CheckinFormRequest $request)
    {
        $data = $request->validated();
        $created = $this->checkinFormService->createFormWithQuestions($data);
        return response()->json($created, 201);
    }

    public function getFormById($id){
        $formId = $this->checkinFormService->getById($id);
        return response()->json($formId,201) ;
    }
    public function deleteFormQuestions($id){
        $formId = $this->checkinFormService->deleteFormQuestions($id);
        return response()->json($formId,201) ;
    }
    public function updateFormWithQuestions(CheckinFormRequest $request, $id)
    {
        $data = $request->validated();
        $formId = $this->checkinFormService->updateFormWithQuestions($id, $data);
        return response()->json($formId, 200);
    }
    public function getAvailableFormsForStudent($studentId)
    {
        $forms = $this->checkinFormService->getAvailableFormsForStudent($studentId);
        return response()->json($forms);
    }
    public function getFormWithQuestions($formId)
    {
        $formWithQuestions = $this->checkinFormService->getFormWithQuestions($formId);
        return response()->json($formWithQuestions);
    }

    // Add this method
    public function getFormWithResponsesAndInsights($formId)
    {
        try {
            $form = $this->checkinFormService->getFormWithResponsesAndInsights($formId);
            
            return response()->json([
                'success' => true,
                'data' => $form
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch form with responses and insights',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
