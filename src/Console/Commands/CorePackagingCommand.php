<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 13/03/17
 * Time: 14:02
 */

namespace Pw\Core\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Pw\Core\Helpers\CoreHelper;

class CorePackagingCommand extends Command
{
    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'core:packaging';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = '[Hanya untuk Developer] - Copy Core-Dev files ke package: "pw/core"';

    protected $from;
    protected $to;

    var $modelsInstalled = ["User", "Role", "Permission", "Employee", "Department", "Upload", "Organization", "Backup"];

    /**
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Mengekspor started...');

        $from = base_path();
        $to = base_path('packages/pw/core/src/Installs');

        $this->info('from: '.$from." to: ".$to);

        // Controllers
        $this->line('Mengekspor Controllers...');
        $this->replaceFolder($from."/app/Http/Controllers/Auth", $to."/app/Controllers/Auth");
        $this->replaceFolder($from."/app/Http/Controllers/Core", $to."/app/Controllers/Core");
        $this->copyFile($from."/app/Http/Controllers/Controller.php", $to."/app/Controllers/Controller.php");
        $this->copyFile($from."/app/Http/Controllers/HomeController.php", $to."/app/Controllers/HomeController.php");

        // Models
        $this->line('Mengekspor Models...');

        foreach ($this->modelsInstalled as $model) {
            if($model == "User" || $model == "Role" || $model == "Permission") {
                $this->copyFile($from."/app/Models/".$model.".php", $to."/app/Models/".$model.".php");
            } else {
                $this->copyFile($from."/app/Models/".$model.".php", $to."/app/Models/".$model.".php");
            }
        }

        // Routes
        $this->line('Mengekspor Routes...');
        if(CoreHelper::laravel_ver() == 5.4) {
            $this->copyFile($from."/routes/admin.php", $to."/app/admin_routes.php");
        } else {
            $this->copyFile($from."/app/Http/admin.php", $to."/app/admin_routes.php");
        }

        // tests
        $this->line('Mengekspor tests...');
        $this->replaceFolder($from."/tests", $to."/tests");

        // Config
        $this->line('Mengekspor Config...');
        $this->copyFile($from."/config/core.php", $to."/config/core.php");

        // core-assets
        $this->line('Mengekspor Core Assets...');
        $this->replaceFolder($from."/public/core-assets", $to."/core-assets");
        // Use "git config core.fileMode false" for ignoring file permissions

        // migrations
        $this->line('Mengekspor migrations...');
        $this->replaceFolder($from."/database/migrations", $to."/migrations");

        // seeds
        $this->line('Mengekspor seeds...');
        $this->copyFile($from."/database/seeds/DatabaseSeeder.php", $to."/seeds/DatabaseSeeder.php");

        // resources
        $this->line('Mengekspor resources: assets + views...');
        $this->replaceFolder($from."/resources/assets", $to."/resources/assets");
        $this->replaceFolder($from."/resources/views", $to."/resources/views");

        // Utilities 
        $this->line('Mengekspor Utilities...');
        // $this->copyFile($from."/gulpfile.js", $to."/gulpfile.js"); // Temporarily Not used.
    }

    private function replaceFolder($from, $to) {
        $this->info("replaceFolder: ($from, $to)");
        if(file_exists($to)) {
            CoreHelper::recurse_delete($to);
        }
        CoreHelper::recurse_copy($from, $to);
    }

    private function copyFile($from, $to) {
        $this->info("copyFile: ($from, $to)");
        //CoreHelper::recurse_copy($from, $to);
        if(!file_exists(dirname($to))) {
            $this->info("mkdir: (".dirname($to).")");
            mkdir(dirname($to));
        }
        copy($from, $to);
    }
}