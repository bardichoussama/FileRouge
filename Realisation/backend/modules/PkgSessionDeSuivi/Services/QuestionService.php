<?php

namespace Modules\PkgSessionDeSuivi\Services;

use Modules\PkgSessionDeSuivi\Domain\Interfaces\QuestionRepositoryInterface;

class QuestionService implements QuestionRepositoryInterface
{
    protected $questionRepository;
    public function __construct(QuestionRepositoryInterface $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }
        public function create($data)
    {
        return $this->questionRepository->create($data);
    }
     
    public function deleteWhereNotInForm($formId, array $keepIds)
    {
        return $this->questionRepository->deleteWhereNotInForm($formId, $keepIds);
    }
    public function getQuestionsByFormId($formId)
    {
        return $this->questionRepository->getQuestionsByFormId($formId);
    }

}
