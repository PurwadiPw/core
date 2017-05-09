<?php

namespace App\Modules\Personel\Providers;

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
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'personel');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'personel');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations', 'personel');
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
