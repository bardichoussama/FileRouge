<?php

namespace Modules\PkgSessionDeSuivi\Services;

use Modules\PkgSessionDeSuivi\Domain\Interfaces\StudentRepositoryInterface;

class StudentService 
{
    protected $studentRepository;
    
    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }
   
    public function getAll()
    {
        return $this->studentRepository->getAll();
    }
}
