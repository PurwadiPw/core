<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 13/03/17
 * Time: 13:56
 */

namespace Pw\Core\Console\Commands;

use Illuminate\Console\Command;

use Pw\Core\Helpers\CodeGenerator;

class CoreMigrationCommand extends Command
{
    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'core:migration {table} {--generate}';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Menggenerate Migrations untuk Core';

    /**
     *
     * @return mixed
     */
    public function handle()
    {
        $table = $this->argument('table');
        $generateFromTable = $this->option('generate');
        if($generateFromTable) {
            $generateFromTable = true;
        }
        CodeGenerator::generateMigration($table, $generateFromTable, $this);
    }
}