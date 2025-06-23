<?php

namespace Modules\PkgSessionDeSuivi\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\PkgSessionDeSuivi\Services\QuestionService;

class QuestionController extends Controller
{
    protected $questionService;
    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function getQuestionsByFormId($formId)
    {
        return $this->questionService->getQuestionsByFormId($formId);
    }

}
