<?php

namespace Modules\PkgSessionDeSuivi\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\PkgSessionDeSuivi\Domain\Entities\Question;

class StudentCheckinAnswer extends Model
{


    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    protected $fillable = [ 
        'checkin_id',
        'question_id',
        'answer_text',
    ];
}
