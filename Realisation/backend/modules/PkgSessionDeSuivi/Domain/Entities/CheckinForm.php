<?php

namespace Modules\PkgSessionDeSuivi\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\PkgApprenant\Models\Promotion;

class CheckinForm extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'promotion_id', 'title', 'description','is_active','start_date','end_date',
    ];
    
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function studentCheckins()
    {
        return $this->hasMany(StudentCheckin::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
    
    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): \Illuminate\Database\Eloquent\Factories\Factory
    {
        return \Database\Factories\CheckinFormFactory::new();
    }
}
