<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 07/03/17
 * Time: 20:44
 */

namespace Pw\Core\Providers;

use Pw\Core\Database\Migrations\Migrator;
use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
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
        $this->registerInstallCommand();
        $this->registerCrudCommand();
        $this->registerMigrationCommand();
        $this->registerPackagingCommand();
        $this->registerDisableCommand();
        $this->registerEnableCommand();
        $this->registerListCommand();
        $this->registerMigrateCommand();
        $this->registerMigrateRefreshCommand();
        $this->registerMigrateResetCommand();
        $this->registerMigrateRollbackCommand();
        $this->registerOptimizeCommand();
        $this->registerSeedCommand();
    }

    /**
     * Register the core:install command.
     */
    protected function registerInstallCommand()
    {
        $this->app->singleton('command.core.install', function () {
            return new \Pw\Core\Console\Commands\CoreInstallCommand();
        });

        $this->commands('command.core.install');
    }

    /**
     * Register the core:crud command.
     */
    protected function registerCrudCommand()
    {
        $this->app->singleton('command.core.crud', function () {
            return new \Pw\Core\Console\Commands\CoreCrudCommand();
        });

        $this->commands('command.core.crud');
    }

    /**
     * Register the core:migration command.
     */
    protected function registerMigrationCommand()
    {
        $this->app->singleton('command.core.migration', function () {
            return new \Pw\Core\Console\Commands\CoreMigrationCommand();
        });

        $this->commands('command.core.migration');
    }

    /**
     * Register the core:packaging command.
     */
    protected function registerPackagingCommand()
    {
        $this->app->singleton('command.core.packaging', function () {
            return new \Pw\Core\Console\Commands\CorePackagingCommand();
        });

        $this->commands('command.core.packaging');
    }

    /**
     * Register the module:disable command.
     */
    protected function registerDisableCommand()
    {
        $this->app->singleton('command.module.disable', function () {
            return new \Pw\Core\Console\Commands\ModuleDisableCommand();
        });

        $this->commands('command.module.disable');
    }

    /**
     * Register the module:enable command.
     */
    protected function registerEnableCommand()
    {
        $this->app->singleton('command.module.enable', function () {
            return new \Pw\Core\Console\Commands\ModuleEnableCommand();
        });

        $this->commands('command.module.enable');
    }

    /**
     * Register the module:list command.
     */
    protected function registerListCommand()
    {
        $this->app->singleton('command.module.list', function ($app) {
            return new \Pw\Core\Console\Commands\ModuleListCommand($app['modules']);
        });

        $this->commands('command.module.list');
    }

    /**
     * Register the module:migrate command.
     */
    protected function registerMigrateCommand()
    {
        $this->app->singleton('command.module.migrate', function ($app) {
            return new \Pw\Core\Console\Commands\ModuleMigrateCommand($app['migrator'], $app['modules']);
        });

        $this->commands('command.module.migrate');
    }

    /**
     * Register the module:migrate:refresh command.
     */
    protected function registerMigrateRefreshCommand()
    {
        $this->app->singleton('command.module.migrate.refresh', function () {
            return new \Pw\Core\Console\Commands\ModuleMigrateRefreshCommand();
        });

        $this->commands('command.module.migrate.refresh');
    }

    /**
     * Register the module:migrate:reset command.
     */
    protected function registerMigrateResetCommand()
    {
        $this->app->singleton('command.module.migrate.reset', function ($app) {
            return new \Pw\Core\Console\Commands\ModuleMigrateResetCommand($app['modules'], $app['files'], $app['migrator']);
        });

        $this->commands('command.module.migrate.reset');
    }

    /**
     * Register the module:migrate:rollback command.
     */
    protected function registerMigrateRollbackCommand()
    {
        $this->app->singleton('command.module.migrate.rollback', function ($app) {
            $repository = $app['migration.repository'];
            $table = $app['config']['database.migrations'];

            $migrator = new Migrator($table, $repository, $app['db'], $app['files']);

            return new \Pw\Core\Console\Commands\ModuleMigrateRollbackCommand($migrator, $app['modules']);
        });

        $this->commands('command.module.migrate.rollback');
    }

    /**
     * Register the module:optimize command.
     */
    protected function registerOptimizeCommand()
    {
        $this->app->singleton('command.module.optimize', function () {
            return new \Pw\Core\Console\Commands\ModuleOptimizeCommand();
        });

        $this->commands('command.module.optimize');
    }

    /**
     * Register the module:seed command.
     */
    protected function registerSeedCommand()
    {
        $this->app->singleton('command.module.seed', function ($app) {
            return new \Pw\Core\Console\Commands\ModuleSeedCommand($app['modules']);
        });

        $this->commands('command.module.seed');
    }
}