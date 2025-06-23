<?php

namespace Modules\PkgSessionDeSuivi\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AIInsight extends Model
{
    protected $table = 'ai_insights';

    protected $fillable = [
       'student_checkin_id',
       'insight_text',
       'type',
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function studentCheckin()
    {
        return $this->belongsTo(StudentCheckin::class, 'student_checkin_id');
    }
}
