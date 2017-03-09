<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 08/03/17
 * Time: 10:51
 */

namespace Pw\Core\Console;

use Illuminate\Console\GeneratorCommand as LaravelGeneratorCommand;
use Illuminate\Support\Str;
use Module;

abstract class GeneratorCommand extends LaravelGeneratorCommand
{
    protected function parseName($name)
    {
        $rootNamespace = config('modules.namespace');

        if (Str::startsWith($name, $rootNamespace)){
            return $name;
        }

        if (Str::contains($name, '/')){
            $name = str_replace('/', '\\', $name);
        }

        return $this->parseName($this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name);
    }

    protected function getPath($name)
    {
        $slug = $this->argument('slug');

        $key = array_search(strtolower($slug), explode('\\', strtolower($name)));
        if ($key === false){
            $newPath = str_replace('\\', '/', $name);
        }else{
            $newPath = implode('/', array_slice(explode('\\', $name), $key + 1));
        }

        return module_path($slug, "$newPath.php");
    }
}