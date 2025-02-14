<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function interviews()
{
    return $this->belongsToMany(Interview::class, 'interview_question')->withPivot('order', 'difficulty_level')->withTimestamps();
}
}
