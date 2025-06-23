<?php

namespace Modules\PkgSessionDeSuivi\Http\Controllers;

use Modules\PkgSessionDeSuivi\Services\PromotionService;
use App\Http\Controllers\Controller;

class PromotionController extends Controller
{
   
    protected $promotionService;
    public function __construct(PromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
    }
    public function getAll()
    {
        return $this->promotionService->getAll();
    }
}

