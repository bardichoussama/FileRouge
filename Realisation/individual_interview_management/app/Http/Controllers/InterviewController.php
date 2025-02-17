<?php

namespace App\Http\Controllers;

use App\Services\InterviewService;

class InterviewController extends Controller
{
    protected $service;

    public function __construct(InterviewService $service)
    {
        $this->service = $service;
    }

    public function statistics()
    {
        return response()->json($this->service->getStatistics());
    }
}
