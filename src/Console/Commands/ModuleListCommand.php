<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 09/03/17
 * Time: 8:00
 */

namespace Pw\Core\Console\Commands;

use Pw\Core\Modules;
use Illuminate\Console\Command;

class ModuleListCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daftar semua module aplikasi';

    /**
     * @var Modules
     */
    protected $module;

    /**
     * The table headers for the command.
     *
     * @var array
     */
    protected $headers = ['#', 'Nama', 'Slug', 'Deskripsi', 'Status'];

    /**
     * Create a new command instance.
     *
     * @param Modules $module
     */
    public function __construct(Modules $module)
    {
        parent::__construct();

        $this->module = $module;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $modules = $this->module->all();

        if (count($modules) == 0) {
            return $this->error("Aplikasi anda belum memiliki module apapun.");
        }

        $this->displayModules($this->getModules());
    }

    /**
     * Get all modules.
     *
     * @return array
     */
    protected function getModules()
    {
        $modules = $this->module->all();
        $results = [];

        foreach ($modules as $module) {
            $results[] = $this->getModuleInformation($module);
        }

        return array_filter($results);
    }

    /**
     * Returns module manifest information.
     *
     * @param string $module
     *
     * @return array
     */
    protected function getModuleInformation($module)
    {
        return [
            '#'           => $module['order'],
            'name'        => $module['name'],
            'slug'        => $module['slug'],
            'description' => $module['description'],
            'status'      => ($this->module->isEnabled($module['slug'])) ? 'Aktif' : 'Nonaktif',
        ];
    }

    /**
     * Display the module information on the console.
     *
     * @param array $modules
     */
    protected function displayModules(array $modules)
    {
        $this->table($this->headers, $modules);
    }
}