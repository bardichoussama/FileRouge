<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\EntretienIndividuel\Providers\EntretienIndividuelServiceProvider; 
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(EntretienIndividuelServiceProvider::class); 
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
