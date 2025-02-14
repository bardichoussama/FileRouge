<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'interview_user')->withPivot('role')->withTimestamps();
    }
    public function questions()
{
    return $this->belongsToMany(Question::class, 'interview_question')->withPivot('order', 'difficulty_level')->withTimestamps();
}

public function feedback()
{
    return $this->hasOne(Feedback::class);
}
}
