<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 08/03/17
 * Time: 5:31
 */

namespace Pw\Core\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $driver = ucfirst(config('modules.driver'));

        if ($driver == 'Custom') {
            $namespace = config('modules.custom_driver');
        } else {
            $namespace = 'Pw\Core\Repositories\\' . $driver . 'Repository';
        }

        $this->app->bind('Pw\Core\Contracts\Repository', $namespace);
    }
}
