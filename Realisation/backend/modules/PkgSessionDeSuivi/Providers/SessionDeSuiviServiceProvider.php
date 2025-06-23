<?php

namespace Modules\PkgSessionDeSuivi\Providers;

use Illuminate\Support\ServiceProvider;

//Auth
use Modules\PkgSessionDeSuivi\Domain\Interfaces\AuthRepositoryInterface;
use Modules\PkgSessionDeSuivi\Domain\Repositories\AuthRepository;
use Modules\PkgSessionDeSuivi\Services\AuthService;
use Modules\PkgSessionDeSuivi\Http\Controllers\AuthController;

//student
use Modules\PkgSessionDeSuivi\Domain\Interfaces\StudentRepositoryInterface;
use Modules\PkgSessionDeSuivi\Domain\Repositories\StudentRepository;
use Modules\PkgSessionDeSuivi\Services\StudentService;
use Modules\PkgSessionDeSuivi\Http\Controllers\StudentController;

//student checkin
use Modules\PkgSessionDeSuivi\Domain\Interfaces\StudentCheckinRepositoryInterface;
use Modules\PkgSessionDeSuivi\Domain\Repositories\StudentCheckinRepository;
use Modules\PkgSessionDeSuivi\Services\StudentCheckinService;
use Modules\PkgSessionDeSuivi\Http\Controllers\StudentCheckinController;

//checkin form
use Modules\PkgSessionDeSuivi\Domain\Interfaces\CheckinFormRepositoryInterface;
use Modules\PkgSessionDeSuivi\Domain\Repositories\CheckinFormRepository;
use Modules\PkgSessionDeSuivi\Services\CheckinFormService;
use Modules\PkgSessionDeSuivi\Http\Controllers\CheckinFormController;

//question
use Modules\PkgSessionDeSuivi\Domain\Interfaces\QuestionRepositoryInterface;
use Modules\PkgSessionDeSuivi\Domain\Repositories\QuestionRepository;
use Modules\PkgSessionDeSuivi\Services\QuestionService;
use Modules\PkgSessionDeSuivi\Http\Controllers\QuestionController;

//promotion
use Modules\PkgSessionDeSuivi\Domain\Interfaces\PromotionRepositoryInterface;
use Modules\PkgSessionDeSuivi\Domain\Repositories\PromotionRepository;
use Modules\PkgSessionDeSuivi\Services\PromotionService;
use Modules\PkgSessionDeSuivi\Http\Controllers\PromotionController;

//insight
use Modules\PkgSessionDeSuivi\Domain\Interfaces\AIInsightRepositoryInterface;
use Modules\PkgSessionDeSuivi\Domain\Repositories\AIInsightRepository;
use Modules\PkgSessionDeSuivi\Services\AIInsightService;
use Modules\PkgSessionDeSuivi\Services\GeminiService;

//dashboard
use Modules\PkgSessionDeSuivi\Domain\Interfaces\DashboardRepositoryInterface;
use Modules\PkgSessionDeSuivi\Domain\Repositories\DashboardRepository;
use Modules\PkgSessionDeSuivi\Services\DashboardService;
use Modules\PkgSessionDeSuivi\Http\Controllers\DashboardController;









class SessionDeSuiviServiceProvider extends ServiceProvider
{
    public function register()
    {
        
     //Auth
     $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
     $this->app->bind(AuthService::class, AuthService::class);

     //student
     $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
     $this->app->bind(StudentService::class, StudentService::class);
   

     //student checkin
     $this->app->bind(StudentCheckinRepositoryInterface::class, StudentCheckinRepository::class);
     $this->app->bind(StudentCheckinService::class, StudentCheckinService::class);
        

     //checkin form
     $this->app->bind(CheckinFormRepositoryInterface::class, CheckinFormRepository::class);
     $this->app->bind(CheckinFormService::class, CheckinFormService::class);

     //question
     $this->app->bind(QuestionRepositoryInterface::class, QuestionRepository::class);
     $this->app->bind(QuestionService::class, QuestionService::class);

    //promotion
    $this->app->bind(PromotionRepositoryInterface::class, PromotionRepository::class);
    $this->app->bind(PromotionService::class, PromotionService::class);

    //insight
    $this->app->bind(AIInsightRepositoryInterface::class, AIInsightRepository::class);
    $this->app->bind(AIInsightService::class, AIInsightService::class);
    $this->app->bind(GeminiService::class, GeminiService::class);

    //dashboard
    $this->app->bind(DashboardRepositoryInterface::class, DashboardRepository::class);
    $this->app->bind(DashboardService::class, DashboardService::class);
    $this->app->bind(DashboardController::class, DashboardController::class);
    }

    public function boot()
    {
        // Load core migrations first
        $this->loadMigrationsFrom(base_path('app/migrations'));
        
        // Then load module migrations
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        
        // Choose ONE of these approaches, not both:
        
        // Option 1: Load routes without prefix
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        
        // Option 2: Load routes with 'api' prefix (recommended for API routes)
        $this->app['router']->prefix('api')->group(__DIR__ . '/../Routes/api.php');
    }
}