<?php

namespace Modules\PkgSessionDeSuivi\Domain\Repositories;

use Modules\PkgSessionDeSuivi\Domain\Entities\Question;
use Modules\PkgSessionDeSuivi\Domain\Interfaces\QuestionRepositoryInterface;

class QuestionRepository implements QuestionRepositoryInterface
{
    protected $questionRepository;
    public function __construct(Question $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function create($data)
    {
        return $this->questionRepository->create($data);
    }


    public function getQuestionsByFormId($formId)
    {
        return $this->questionRepository->where('checkin_form_id', $formId)->get();
    }

    public function deleteWhereNotInForm($formId, array $keepIds)
{
    return $this->questionRepository->where('checkin_form_id', $formId)
        ->whereNotIn('id', $keepIds)
        ->delete();
}

}
