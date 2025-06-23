<?php

namespace Modules\PkgSessionDeSuivi\Domain\Repositories;
use Modules\PkgSessionDeSuivi\Domain\Interfaces\PromotionRepositoryInterface;
use Modules\PkgApprenant\Models\Promotion;
use Carbon\Carbon;
class PromotionRepository implements PromotionRepositoryInterface
{
    protected $promotion;
    
    public function __construct(Promotion $promotion)
    {
        $this->promotion = $promotion;
    }
    public function getAll()
    {
        return $this->promotion->all();
    }
       /**
     * Get promotion by year (starting year for multi-year promotions)
     */
    public function getByYear($year)
    {
        return $this->promotion->where('year', $year)->first();
    }
    
    /**
     * Get the current active promotion based on current date
     * This handles promotions that span multiple years
     */
    public function getCurrentPromotion()
    {
        $currentDate = Carbon::now();
        $currentYear = $currentDate->year;
        
        // Try current year first
        $promotion = $this->getByYear($currentYear);
        
        // If no promotion for current year and we're in early months,
        // check previous year (for promotions like 2024-2025)
        if (!$promotion && $currentDate->month <= 6) {
            $promotion = $this->getByYear($currentYear - 1);
        }
        
        return $promotion;
    }
    
    /**
     * Get active promotion with date range validation
     * If you add start_date and end_date to promotions table
     */
    public function getActivePromotion()
    {
        $currentDate = Carbon::now()->toDateString();
        
        return $this->promotion->where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->first();
    }

}
