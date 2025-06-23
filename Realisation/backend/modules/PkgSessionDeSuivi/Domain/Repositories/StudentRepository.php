<?php

namespace Modules\PkgSessionDeSuivi\Domain\Repositories;

use Modules\PkgSessionDeSuivi\Domain\Interfaces\StudentRepositoryInterface;
use Modules\PkgApprenant\Models\Apprenant;

class StudentRepository implements StudentRepositoryInterface
{
    protected $student;
    
    public function __construct(Apprenant $student)
    {
        $this->student = $student;
    }
    public function getAll(){
        return $this->student->all();
    }
    
}