<?php

namespace Modules\PkgSessionDeSuivi\Domain\Interfaces;

use Modules\PkgSessionDeSuivi\Domain\Entities\AIInsight;


interface AIInsightRepositoryInterface
{
    /** Persist a new AI insight */
    public function create(AIInsight $aiInsight): AIInsight;

}