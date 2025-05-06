<?php

namespace Modules\EntretienIndividuel\Providers; 

use Illuminate\Support\ServiceProvider;
use Modules\EntretienIndividuel\Domain\Interfaces\IFormulaire;
use Modules\EntretienIndividuel\Domain\Repositories\FormulaireRepository;
use Modules\EntretienIndividuel\Services\EntretienService;
use Modules\EntretienIndividuel\Services\FormulaireService;
use Modules\EntretienIndividuel\Domain\Entities\Formulaire;

class EntretienIndividuelServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register the interface to repository binding
        $this->app->bind(
            IFormulaire::class,
            FormulaireRepository::class
        );
        
        // Register FormulaireService
        $this->app->singleton(FormulaireService::class, function ($app) {
            return new FormulaireService($app->make(IFormulaire::class));
        });
        
        // If you also need EntretienService
        $this->app->singleton(EntretienService::class, function ($app) {
            return new EntretienService($app->make(IFormulaire::class));
        });
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
    }
}