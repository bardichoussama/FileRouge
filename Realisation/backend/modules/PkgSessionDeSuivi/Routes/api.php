<?php

use Illuminate\Support\Facades\Route;

use Modules\PkgSessionDeSuivi\Http\Controllers\StudentController;
use Modules\PkgSessionDeSuivi\Http\Controllers\StudentCheckinController;
use Modules\PkgSessionDeSuivi\Http\Controllers\CheckinFormController;
use Modules\PkgSessionDeSuivi\Http\Controllers\QuestionController;
use Modules\PkgSessionDeSuivi\Http\Controllers\PromotionController;
use Modules\PkgSessionDeSuivi\Http\Controllers\AuthController;
use Modules\PkgSessionDeSuivi\Http\Controllers\AIInsightController;
use App\Http\Controllers\TestAIController;
use Modules\PkgSessionDeSuivi\Http\Controllers\DashboardController;

//Auth
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    
});



Route::prefix('dashboard')->middleware('auth:sanctum')->group(function () {
    Route::get('kpis/{promotionId}', [DashboardController::class, 'getKPIs']);
    Route::get('groupe-stats/{promotionId}', [DashboardController::class, 'getGroupeStats']);
    Route::get('checkins-by-promotion', [DashboardController::class, 'getCheckinsByPromotion']);
    
});


        // Protect checkin-forms
        Route::prefix('checkin-forms')->middleware('auth:sanctum')->group(function () {
            Route::get('/', [CheckinFormController::class, 'getAll']);
            Route::get('/{id}', [CheckinFormController::class, 'getFormById']);
            Route::post('/', [CheckinFormController::class, 'create']);
            Route::put('/{id}', [CheckinFormController::class, 'updateFormWithQuestions']);
            Route::delete('/{id}', [CheckinFormController::class, 'deleteFormQuestions']);
            Route::get('/available-forms/{studentId}', [CheckinFormController::class, 'getAvailableFormsForStudent']);
            Route::get('/form-with-questions/{formId}', [CheckinFormController::class, 'getFormWithQuestions']);
            // New: get form responses (answers) with student info
            
            // New: get form with both responses and AI insights if needed
            Route::get('/{formId}/responses-with-insights', [CheckinFormController::class, 'getFormWithResponsesAndInsights']);

        });
 

        // Protect student-checkins
        Route::prefix('student-checkins')->middleware('auth:sanctum')->group(function () {
            Route::post('/', [StudentCheckinController::class, 'submitCheckin']);
            Route::get('/my-checkins', [StudentCheckinController::class, 'getMyCheckins']);
        
        });
    
        // Protect students
        Route::prefix('students')->group(function () {
            Route::get('/', [StudentController::class, 'getAll']);
        });

        // Protect questions
        Route::prefix('questions')->group(function () {
            
            
            Route::get('/form/{formId}', [QuestionController::class, 'getQuestionsByFormId']);
        });

      
    // Protect promotions
    Route::prefix('promotions')->group(function () {
        Route::get('/', [PromotionController::class, 'getAll']);
    });

Route::prefix('ai-insights')->group(function () {
   
    Route::post('/analyze/checkin-form/{checkinFormId}', [AIInsightController::class, 'analyzeCheckinForm']);

});




