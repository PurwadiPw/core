<?php

namespace App\Modules\Content\Providers;

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
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'content');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'content');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations', 'content');
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
