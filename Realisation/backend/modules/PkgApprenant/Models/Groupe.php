<?php

namespace Modules\PkgApprenant\Models;

use Modules\PkgApprenant\Models\Apprenant;
use Modules\PkgApprenant\Models\Promotion;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $fillable = ['nom', 'promotion_id', 'description'];

    public function apprenants()
    {
        return $this->hasMany(Apprenant::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }
}
