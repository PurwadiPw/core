<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 09/03/17
 * Time: 8:36
 */

namespace Pw\Core\Console\Generators;

use Pw\Core\Console\GeneratorCommand;

class MakeMiddlewareCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module:middleware
    	{slug : Slug module.}
    	{name : Nama class middleware.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat middleware class untuk module';

    /**
     * String to store the command type.
     *
     * @var string
     */
    protected $type = 'Module middleware';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/middleware.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return module_class($this->argument('slug'), 'Http\\Middleware');
    }
}
