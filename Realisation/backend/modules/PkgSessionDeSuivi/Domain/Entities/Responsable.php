<?php

namespace Modules\PkgSessionDeSuivi\Domain\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    protected $fillable = [
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 