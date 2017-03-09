<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 07/03/17
 * Time: 20:46
 */

namespace Pw\Core\Providers;

use Illuminate\Support\ServiceProvider;

class GeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $generators = [
            'command.make.module' => \Pw\Core\Console\Generators\MakeModuleCommand::class,
            'command.make.module.controller' => \Pw\Core\Console\Generators\MakeControllerCommand::class,
            'command.make.module.middleware' => \Pw\Core\Console\Generators\MakeMiddlewareCommand::class,
            'command.make.module.migration'  => \Pw\Core\Console\Generators\MakeMigrationCommand::class,
            'command.make.module.model'      => \Pw\Core\Console\Generators\MakeModelCommand::class,
            'command.make.module.policy'     => \Pw\Core\Console\Generators\MakePolicyCommand::class,
            'command.make.module.provider'   => \Pw\Core\Console\Generators\MakeProviderCommand::class,
            'command.make.module.request'    => \Pw\Core\Console\Generators\MakeRequestCommand::class,
            'command.make.module.seeder'     => \Pw\Core\Console\Generators\MakeSeederCommand::class,
        ];

        foreach ($generators as $slug => $class) {
            $this->app->singleton($slug, function ($app) use ($slug, $class) {
                return $app[$class];
            });

            $this->commands($slug);
        }
    }
}