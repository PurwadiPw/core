<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 09/03/17
 * Time: 8:00
 */

namespace Pw\Core\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class ModuleEnableCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:enable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengaktifkan module';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $slug = $this->argument('slug');

        if ($this->laravel['modules']->isDisabled($slug)) {
            $this->laravel['modules']->enable($slug);

            $module = $this->laravel['modules']->where('slug', $slug);

            event($slug.'.module.enabled', [$module, null]);

            $this->info('Module berhasil diaktifkan.');
        } else {
            $this->comment('Module sudah diaktifkan.');
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['slug', InputArgument::REQUIRED, 'Module slug.'],
        ];
    }
}