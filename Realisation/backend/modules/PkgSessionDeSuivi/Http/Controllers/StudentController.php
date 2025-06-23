<?php

namespace Modules\PkgSessionDeSuivi\Http\Controllers;

use App\Http\Controllers\Controller;   
use Modules\PkgSessionDeSuivi\Services\StudentService;

class StudentController extends Controller  
{
    private $studentService;

    public function __construct(StudentService $studentService)                       
    {
        $this->studentService = $studentService;
    }

    public function getAll()
    {
        $students = $this->studentService->getAll();
        return response()->json($students);
    }
   

}