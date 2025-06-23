<?php

namespace Modules\PkgSessionDeSuivi\Domain\Repositories;

use Modules\PkgSessionDeSuivi\Domain\Entities\CheckinForm;
use Modules\PkgSessionDeSuivi\Domain\Interfaces\CheckinFormRepositoryInterface;
use Modules\PkgApprenant\Models\Apprenant;
use Modules\PkgSessionDeSuivi\Domain\Entities\StudentCheckin;

class CheckinFormRepository implements CheckinFormRepositoryInterface
{
    protected $checkinFormRepository;
    protected $apprenantRepository;
    protected $studentCheckinRepository;
    public function __construct(CheckinForm $checkinFormRepository, Apprenant $apprenantRepository, StudentCheckin $studentCheckinRepository)
    {
        $this->checkinFormRepository = $checkinFormRepository;
        $this->apprenantRepository = $apprenantRepository;
        $this->studentCheckinRepository = $studentCheckinRepository;
    }
    public function getAll()
    {
        return $this->checkinFormRepository->withCount('questions')->get();
    }
    public function create($data)
    {
        return $this->checkinFormRepository->create($data);
    }
    public function getById($id){
        return $this->checkinFormRepository->find($id);
    }

    public function delete($id){
        return $this->checkinFormRepository->where('id', $id)->delete();
    }
    public function update($id, $data){
        return $this->checkinFormRepository->where('id', $id)->update($data);
    }
    public function getAvailableFormsForStudent($studentId)
{
    $today = now()->toDateString();

    // Determine student's promotion via relationship
    $student = $this->apprenantRepository->where('user_id', $studentId)
        ->with('groupe.promotion')
        ->first();

    if (! $student || ! $student->groupe || ! $student->groupe->promotion) {
        return collect();
    }

    $promotionId = $student->groupe->promotion->id;

    // Return active forms scoped to this promotion and student
    return $this->checkinFormRepository->with('questions')
        ->where('is_active', true)
        ->where('promotion_id', $promotionId)
        ->whereDate('start_date', '<=', $today)
        ->whereDate('end_date', '>=', $today)
        ->whereDoesntHave('studentCheckins', function ($query) use ($studentId) {
            $query->where('student_id', $studentId);
        })
        ->get();
}
public function getFormWithQuestions($formId)
{
    return $this->checkinFormRepository->with('questions')->find($formId);
}

    public function getFormWithResponsesAndInsights($formId)
{
    return $this->studentCheckinRepository->with([
        'student:id,name,email',
        'student.apprenant.groupe.promotion',
        'answers.question',
        'aiInsights'
    ])
    ->where('checkin_form_id', $formId)
    ->get();
}
 }

