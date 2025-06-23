<?php

namespace Modules\PkgSessionDeSuivi\Services;

use Modules\PkgSessionDeSuivi\Domain\Interfaces\DashboardRepositoryInterface;
class DashboardService
{
    private $dashboardRepository;

    public function __construct(DashboardRepositoryInterface $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function getKPIs($promotionId = null)
    {
        return $this->dashboardRepository->getKPICounts($promotionId);
    }

    public function getGroupeSubmissionStats($promotionId = null)
    {
        return $this->dashboardRepository->getGroupeStats($promotionId);
    }

    public function getCheckinsByPromotion()
    {
        return $this->dashboardRepository->getCheckinsByPromotion();
    }


}