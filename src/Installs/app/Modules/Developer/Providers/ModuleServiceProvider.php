<?php

namespace App\Modules\Developer\Providers;

use Pw\Core\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'developer');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'developer');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations', 'developer');
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
