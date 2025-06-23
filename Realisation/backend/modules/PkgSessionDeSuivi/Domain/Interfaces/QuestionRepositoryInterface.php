<?php

namespace Modules\PkgSessionDeSuivi\Domain\Interfaces;

interface QuestionRepositoryInterface
{

    public function create($data);
    public function getQuestionsByFormId($formId);
    public function deleteWhereNotInForm($formId, array $keepIds);
}
