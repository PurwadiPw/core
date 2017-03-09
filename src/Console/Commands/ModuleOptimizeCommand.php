<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 09/03/17
 * Time: 7:34
 */

namespace Pw\Core\Console\Commands;

use Illuminate\Console\Command;

class ModuleOptimizeCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimalkan cache module untuk performa yang lebih baik';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->info('Mengenerate pengoptimalan cache module');

        $this->laravel['modules']->optimize();

        event('modules.optimized', [$this->laravel['modules']->all()]);
    }
}