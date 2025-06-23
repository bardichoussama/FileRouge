<?php

namespace Modules\PkgSessionDeSuivi\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\PkgSessionDeSuivi\Services\AIInsightService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class AIInsightController extends Controller
{
    private AIInsightService $aiInsightService;

    public function __construct(AIInsightService $aiInsightService)
    {
        $this->aiInsightService = $aiInsightService;
    }



    /**
     * Generate AI insights for all students in a checkin form
     */
    public function analyzeCheckinForm(Request $request, int $checkinFormId): JsonResponse
    {
        try {
            $insights = $this->aiInsightService->generateInsightsForCheckinForm($checkinFormId);
            
            return response()->json([
                'success' => true,
                'message' => 'AI analysis completed for all students',
                'data' => $insights,
                'count' => count($insights)
            ], 200);
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate AI analysis',
                'error' => $e->getMessage()
            ], 500);
        }
    }


} 