<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 09/03/17
 * Time: 8:37
 */

namespace Pw\Core\Console\Generators;

use Pw\Core\Console\GeneratorCommand;

class MakeSeederCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module:seeder
    	{slug : Slug module.}
    	{name : Nama class seeder.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat seeder class untuk module';

    /**
     * String to store the command type.
     *
     * @var string
     */
    protected $type = 'Module seeder';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/seeder.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getPath($name)
    {
        return module_path($this->argument('slug'), 'Database/Seeds/'.$name.'.php');
    }

    /**
     * Parse the name and format according to the root namespace.
     *
     * @param string $name
     *
     * @return string
     */
    protected function parseName($name)
    {
        return $name;
    }

    /**
     * Replace namespace in seeder stub.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getNamespace($name)
    {
        return module_class($this->argument('slug'), 'Database\Seeds');
    }
}