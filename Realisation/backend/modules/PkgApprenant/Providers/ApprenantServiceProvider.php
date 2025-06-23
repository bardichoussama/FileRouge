<?php

namespace Modules\PkgApprenant\Providers;

use Illuminate\Support\ServiceProvider;


class ApprenantServiceProvider extends ServiceProvider
{
    public function register()
    {
       
    }

    public function boot()
    {
        // Load core migrations first
        $this->loadMigrationsFrom(base_path('app/migrations'));
        
        // Then load module migrations
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        
        // Choose ONE of these approaches, not both:
        
        // Option 1: Load routes without prefix
        // $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        
        // Option 2: Load routes with 'api' prefix (recommended for API routes)
        
    }
}