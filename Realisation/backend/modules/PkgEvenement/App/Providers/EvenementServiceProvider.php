<?php

namespace Modules\PkgEvenement\App\Providers; 

use Illuminate\Support\ServiceProvider;

class EvenementServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__."/../../Routes/api.php");

        // $this->loadMigrationsFrom(__DIR__."/../../Database/migrations");
        // $this->loadViewsFrom(__DIR__."/../../Resources/views", "Blog");
        
    }
}
