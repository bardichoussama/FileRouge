<?php

namespace Modules\PkgSessionDeSuivi\Domain\Interfaces;

interface PromotionRepositoryInterface
{
    public function getAll();
    public function getByYear($year);
    public function getCurrentPromotion();
    public function getActivePromotion();
}
