<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 07/03/17
 * Time: 21:07
 */

namespace Pw\Core;

use Pw\Core\Contracts\Repository;
use Illuminate\Foundation\Application;

class Modules
{
    protected $app;

    protected $repository;

    public function __construct(Application $app, Repository $repository)
    {
        $this->app = $app;
        $this->repository = $repository;
    }

    public function register()
    {
        $modules = $this->repository->enabled();

        $modules->each(function($module) {
            $this->registerServiceProvider($module);
            $this->autoloadFiles($module);
        });
    }

    private function registerServiceProvider($module)
    {
        $serviceProvider = module_class($module['slug'], 'Providers\\ModuleServiceProvider');

        if (class_exists($serviceProvider)) {
            $this->app->register($serviceProvider);
        }
    }

    private function autoloadFiles($module)
    {
        if (isset($module['autoload'])) {
            foreach ($module['autoload'] as $file) {
                $path = module_path($module['slug'], $file);

                if (file_exists($path)) {
                    include $path;
                }
            }
        }
    }

    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->repository, $method], $arguments);
    }
}