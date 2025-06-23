<?php

namespace Modules\PkgApprenant\Models;

use Modules\PkgApprenant\Models\Groupe;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;


class Apprenant extends Model
{
    protected $fillable = [
        'user_id',
        'groupe_id'
    ];

    /**
     * Belongs to a Groupe.
     */
    public function groupe()
    {
        return $this->belongsTo(Groupe::class, 'groupe_id');
    }
} 