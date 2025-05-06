<?php

namespace Modules\EntretienIndividuel\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class Formulaire extends Model
{
    protected $table = 'formulaires';
    protected $fillable = [
       'titre',
       'description',
       'deadline'
    ];
}
