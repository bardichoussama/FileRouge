<?php
namespace Modules\PkgSessionDeSuivi\Services;

use Modules\PkgSessionDeSuivi\Domain\Interfaces\StudentCheckinRepositoryInterface;

class StudentCheckinService
{
    protected StudentCheckinRepositoryInterface $repository;

    public function __construct(StudentCheckinRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function submitCheckin(array $data, int $studentId)
    {
        return $this->repository->submitCheckin($data, $studentId);
    }
    public function getMyCheckins($studentId)
    {
        return $this->repository->getMyCheckins($studentId);
    }
}
