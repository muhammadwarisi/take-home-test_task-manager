<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use RealRashid\SweetAlert\SweetAlertServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(\App\Services\AuthServiceInterface::class, \App\Services\AuthService::class);
        SweetAlertServiceProvider::class;
        \Spatie\Permission\PermissionServiceProvider::class;
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
