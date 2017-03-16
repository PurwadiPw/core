<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 13/03/17
 * Time: 11:57
 */

namespace Pw\Core\Console\Commands;

use Config;
use Artisan;
use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Filesystem\Filesystem;
use Pw\Core\Models\Crud;
use Pw\Core\Helpers\CodeGenerator;

class CoreCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:crud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menggenerate CRUD untuk module';

    /* ================ Config ================ */
    var $module = null;
    var $controllerName = "";
    var $modelName = "";
    var $moduleName = "";
    var $dbTableName = "";
    var $singularVar = "";
    var $singularCapitalVar = "";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $module = $this->argument('module');

        try {

            $config = CodeGenerator::generateConfig($module, "fa-cube");

            CodeGenerator::createController($config, $this);
            CodeGenerator::createModel($config, $this);
            CodeGenerator::createViews($config, $this);
            CodeGenerator::appendRoutes($config, $this);
            CodeGenerator::addMenu($config, $this);

        } catch (Exception $e) {
            $this->error("Crud::handle exception: ".$e);
            throw new Exception("Gagal menggenerate migration untuk ".($module)." : ".$e->getMessage(), 1);
        }
        $this->info("\nCRUD ".($module)." berhasil di generate.\n");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::REQUIRED, 'Crud slug.'],
        ];
    }
}