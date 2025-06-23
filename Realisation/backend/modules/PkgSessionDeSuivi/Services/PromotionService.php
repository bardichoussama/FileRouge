<?php

namespace Modules\PkgSessionDeSuivi\Services;
use Modules\PkgSessionDeSuivi\Domain\Interfaces\PromotionRepositoryInterface;

class PromotionService implements PromotionRepositoryInterface
{
    protected $promotionRepository;
    
    public function __construct(PromotionRepositoryInterface $promotionRepository)
    {
        $this->promotionRepository = $promotionRepository;
    }
    public function getAll()
    {
        return $this->promotionRepository->getAll();
    }

    public function getByYear($year)
    {
        return $this->promotionRepository->getByYear($year);
    }

    public function getCurrentPromotion()
    {
        return $this->promotionRepository->getCurrentPromotion();
    }

    public function getActivePromotion()
    {
        return $this->promotionRepository->getActivePromotion();
    }
   
}
