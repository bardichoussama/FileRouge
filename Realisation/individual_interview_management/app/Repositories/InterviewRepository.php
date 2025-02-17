<?php

namespace App\Repositories;

use App\Models\Interview;

class InterviewRepository {

    public function __construct(Interview $model)
    {
        $this->model = $model;
    }

    public function getScheduledInterviewsCount()
    {
        return $this->model->where('status', 'scheduled')->count();
    }

    public function getCompletedInterviewsCount()
    {
        return $this->model->where('status', 'completed')->count();
    }
    
}