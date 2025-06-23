<?php

namespace Modules\PkgSessionDeSuivi\Domain\Interfaces;

interface StudentCheckinRepositoryInterface
{
  
    public function submitCheckin(array $data, int $studentId);
    public function getMyCheckins($studentId);
   
}
