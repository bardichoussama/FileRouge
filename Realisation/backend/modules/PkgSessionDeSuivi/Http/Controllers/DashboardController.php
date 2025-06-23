<?php
namespace Modules\PkgSessionDeSuivi\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Modules\PkgSessionDeSuivi\Services\DashboardService;

class DashboardController extends Controller
{
    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function getKPIs(Request $request, $promotionId = null)
    {
        $promotionId = $promotionId ?? $request->get('promotion_id');
        $data = $this->dashboardService->getKPIs($promotionId);
        
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function getGroupeStats(Request $request, $promotionId = null)
    {
        $promotionId = $promotionId ?? $request->get('promotion_id');
        $data = $this->dashboardService->getGroupeSubmissionStats($promotionId);
        
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function getCheckinsByPromotion()
    {
        $data = $this->dashboardService->getCheckinsByPromotion();
        
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

 
}