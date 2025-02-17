<?php

namespace App\Services;

use App\Repositories\InterviewRepository;

class InterviewService 
{
    protected $repository;

    public function __construct(InterviewRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getStatistics()
    {
        return [
            'scheduled'  => $this->repository->getScheduledInterviewsCount(),
            'completed'  => $this->repository->getCompletedInterviewsCount(),
        ];
    }
}
