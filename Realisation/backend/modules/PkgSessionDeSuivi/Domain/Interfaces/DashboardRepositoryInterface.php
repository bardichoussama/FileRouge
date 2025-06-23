<?php
namespace Modules\PkgSessionDeSuivi\Domain\Interfaces;
interface DashboardRepositoryInterface
{
    public function getKPICounts($promotionId = null);
    public function getGroupeStats($promotionId = null);
    public function getCheckinsByPromotion();
}
