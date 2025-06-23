<?php

namespace Modules\PkgSessionDeSuivi\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_text',
        'question_type',
        'checkin_form_id',
    ];

    public function checkinForm()
    {
        return $this->belongsTo(CheckinForm::class);
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): \Illuminate\Database\Eloquent\Factories\Factory
    {
        return \Database\Factories\QuestionFactory::new();
    }
}
