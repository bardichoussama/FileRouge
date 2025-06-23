<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\PkgSessionDeSuivi\Services\AIInsightService;

class GenerateAIInsightJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $studentCheckinId;

    public function __construct(int $studentCheckinId)
    {
        $this->studentCheckinId = $studentCheckinId;
    }

    public function handle(AIInsightService $aiInsightService)
    {
        $aiInsightService->generateInsightForStudentCheckin($this->studentCheckinId);
    }
}