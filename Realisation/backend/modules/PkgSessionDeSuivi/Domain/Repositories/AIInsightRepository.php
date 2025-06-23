<?php

namespace Modules\PkgSessionDeSuivi\Domain\Repositories;

use Modules\PkgSessionDeSuivi\Domain\Interfaces\AIInsightRepositoryInterface;
use Modules\PkgSessionDeSuivi\Domain\Entities\AIInsight;


class AIInsightRepository implements AIInsightRepositoryInterface
{
    public function create(AIInsight $aiInsight): AIInsight
    {
        return AIInsight::create($aiInsight->toArray());
    }


    

    

    

    
  
    

    
}