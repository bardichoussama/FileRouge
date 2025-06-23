<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\PkgEvenement\App\Providers\EvenementServiceProvider;
use Modules\PkgApprenant\Providers\ApprenantServiceProvider;
use Modules\PkgSessionDeSuivi\Providers\SessionDeSuiviServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(EvenementServiceProvider::class);
        // $this->app->register(EntretienIndividuelServiceProvider::class);
        $this->app->register(ApprenantServiceProvider::class);
        $this->app->register(SessionDeSuiviServiceProvider::class);
    }

    public function boot(): void
    {
        //
    }
}
