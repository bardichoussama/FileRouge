<?php

namespace Modules\PkgSessionDeSuivi\Domain\Interfaces;

interface CheckinFormRepositoryInterface
{
    public function getAll();
    public function create($data);
    public function delete($id);
    public function update($id, $data);
    public function getById($id);
    public function getFormWithQuestions($formId);
    public function getAvailableFormsForStudent($studentId);
    public function getFormWithResponsesAndInsights($formId);


   
    

}
