<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 09/03/17
 * Time: 14:52
 */
namespace Pw\Core\Facades;

use Illuminate\Support\Facades\Facade;

class Theme extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'themes';
    }
}