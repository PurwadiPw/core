<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 13/03/17
 * Time: 11:44
 */

namespace Pw\Core\Helpers;

use Exception;
use Illuminate\Filesystem\Filesystem;
use Pw\Core\Models\Crud;
use Pw\Core\Models\CrudFieldTypes;
use Pw\Core\Helpers\CoreHelper;
use Pw\Core\Models\Menu;

class CodeGenerator
{
    /**
     * Generate Controller file
     * if $generate is true then create file from crud info from DB
     * $comm is command Object from Migration command
     * CodeGenerator::generateMigration($table, $generateFromTable);
     **/
    public static function createController($config, $comm = null) {

        $templateDirectory = __DIR__.'/stubs';

        CoreHelper::log("info", "Creating controller...", $comm);
        $md = file_get_contents($templateDirectory."/controller.stub");

        $md = str_replace("__controller_class_name__", $config->controllerName, $md);
        $md = str_replace("__model_name__", $config->modelName, $md);
        $md = str_replace("__crud_name__", $config->crudName, $md);
        $md = str_replace("__view_column__", $config->crud->view_col, $md);

        // Listing columns
        $listing_cols = "";
        foreach ($config->crud->fields as $field) {
            $listing_cols .= "'".$field['colname']."', ";
        }
        $listing_cols = trim($listing_cols, ", ");

        $md = str_replace("__listing_cols__", $listing_cols, $md);
        $md = str_replace("__view_folder__", $config->dbTableName, $md);
        $md = str_replace("__route_resource__", $config->dbTableName, $md);
        $md = str_replace("__db_table_name__", $config->dbTableName, $md);
        $md = str_replace("__singular_var__", $config->singularVar, $md);

        file_put_contents(base_path('app/Http/Controllers/Core/'.$config->controllerName.".php"), $md);
    }

    public static function createModel($config, $comm = null) {

        $templateDirectory = __DIR__.'/stubs';

        CoreHelper::log("info", "Creating model...", $comm);
        $md = file_get_contents($templateDirectory."/model.stub");

        $md = str_replace("__model_class_name__", $config->modelName, $md);
        $md = str_replace("__db_table_name__", $config->dbTableName, $md);

        file_put_contents(base_path('app/Models/'.$config->modelName.".php"), $md);
    }

    public static function createViews($config, $comm = null) {

        $templateDirectory = __DIR__.'/stubs';

        CoreHelper::log("info", "Creating views...", $comm);
        // Create Folder
        @mkdir(base_path("resources/views/core/".$config->dbTableName), 0777, true);

        // ============================ Listing / Index ============================
        $md = file_get_contents($templateDirectory."/views/index.blade.stub");

        $md = str_replace("__crud_name__", $config->crudName, $md);
        $md = str_replace("__db_table_name__", $config->dbTableName, $md);
        $md = str_replace("__controller_class_name__", $config->controllerName, $md);
        $md = str_replace("__singular_var__", $config->singularVar, $md);
        $md = str_replace("__singular_cap_var__", $config->singularCapitalVar, $md);
        $md = str_replace("__crud_name_2__", $config->crudName2, $md);

        // Listing columns
        $inputFields = "";
        foreach ($config->crud->fields as $field) {
            $inputFields .= "\t\t\t\t\t@core_input($"."crud, '".$field['colname']."')\n";
        }
        $inputFields = trim($inputFields);
        $md = str_replace("__input_fields__", $inputFields, $md);

        file_put_contents(base_path('resources/views/core/'.$config->dbTableName.'/index.blade.php'), $md);

        // ============================ Edit ============================
        $md = file_get_contents($templateDirectory."/views/edit.blade.stub");

        $md = str_replace("__crud_name__", $config->crudName, $md);
        $md = str_replace("__db_table_name__", $config->dbTableName, $md);
        $md = str_replace("__controller_class_name__", $config->controllerName, $md);
        $md = str_replace("__singular_var__", $config->singularVar, $md);
        $md = str_replace("__singular_cap_var__", $config->singularCapitalVar, $md);
        $md = str_replace("__crud_name_2__", $config->crudName2, $md);

        // Listing columns
        $inputFields = "";
        foreach ($config->crud->fields as $field) {
            $inputFields .= "\t\t\t\t\t@core_input($"."crud, '".$field['colname']."')\n";
        }
        $inputFields = trim($inputFields);
        $md = str_replace("__input_fields__", $inputFields, $md);

        file_put_contents(base_path('resources/views/core/'.$config->dbTableName.'/edit.blade.php'), $md);

        // ============================ Show ============================
        $md = file_get_contents($templateDirectory."/views/show.blade.stub");

        $md = str_replace("__crud_name__", $config->crudName, $md);
        $md = str_replace("__db_table_name__", $config->dbTableName, $md);
        $md = str_replace("__singular_var__", $config->singularVar, $md);
        $md = str_replace("__singular_cap_var__", $config->singularCapitalVar, $md);
        $md = str_replace("__crud_name_2__", $config->crudName2, $md);

        // Listing columns
        $displayFields = "";
        foreach ($config->crud->fields as $field) {
            $displayFields .= "\t\t\t\t\t\t@core_display($"."crud, '".$field['colname']."')\n";
        }
        $displayFields = trim($displayFields);
        $md = str_replace("__display_fields__", $displayFields, $md);

        file_put_contents(base_path('resources/views/core/'.$config->dbTableName.'/show.blade.php'), $md);
    }

    public static function appendRoutes($config, $comm = null) {

        $templateDirectory = __DIR__.'/stubs';

        CoreHelper::log("info", "Appending routes...", $comm);
        if(\Pw\Core\Helpers\CoreHelper::laravel_ver() == 5.4) {
            $routesFile = base_path('routes/admin_routes.php');
        } else {
            $routesFile = app_path('Http/admin_routes.php');
        }

        $contents = file_get_contents($routesFile);
        $contents = str_replace('});', '', $contents);
        file_put_contents($routesFile, $contents);

        $md = file_get_contents($templateDirectory."/routes.stub");

        $md = str_replace("__crud_name__", $config->crudName, $md);
        $md = str_replace("__controller_class_name__", $config->controllerName, $md);
        $md = str_replace("__db_table_name__", $config->dbTableName, $md);
        $md = str_replace("__singular_var__", $config->singularVar, $md);
        $md = str_replace("__singular_cap_var__", $config->singularCapitalVar, $md);

        file_put_contents($routesFile, $md, FILE_APPEND);
    }

    public static function addMenu($config, $comm = null) {

        // $templateDirectory = __DIR__.'/stubs';

        CoreHelper::log("info", "Appending Menu...", $comm);
        if(Menu::where("url", $config->dbTableName)->count() == 0) {
            Menu::create([
                "name" => $config->crudName,
                "url" => $config->dbTableName,
                "icon" => "fa ".$config->fa_icon,
                "type" => 'crud',
                "parent" => 0
            ]);
        }

        // Old Method to add Menu
        // $menu = '<li><a href="{{ url(config("core.adminRoute") . '."'".'/'.$config->dbTableName."'".') }}"><i class="fa fa-cube"></i> <span>'.$config->crudName.'</span></a></li>'."\n".'            <!-- LAMenus -->';
        // $md = file_get_contents(base_path('resources/views/core/layouts/partials/sidebar.blade.php'));
        // $md = str_replace("<!-- LAMenus -->", $menu, $md);
        // file_put_contents(base_path('resources/views/core/layouts/partials/sidebar.blade.php'), $md);
    }

    /**
     * Generate migration file
     * if $generate is true then create file from crud info from DB
     * $comm is command Object from Migration command
     * CodeGenerator::generateMigration($table, $generateFromTable);
     **/
    public static function generateMigration($table, $generate = false, $comm = null)
    {
        $filesystem = new Filesystem();

        if(starts_with($table, "create_")) {
            $tname = str_replace("create_", "",$table);
            $table = str_replace("_table", "",$tname);
        }

        $modelName = ucfirst(str_singular($table));
        $tableP = str_plural(strtolower($table));
        $tableS = str_singular(strtolower($table));
        $migrationName = 'create_'.$tableP.'_table';
        $migrationFileName = date("Y_m_d_His_").$migrationName.".php";
        $migrationClassName = ucfirst(camel_case($migrationName));
        $dbTableName = $tableP;
        $crudName = ucfirst(str_plural($table));

        CoreHelper::log("info", "Model:\t   ".$modelName, $comm);
        CoreHelper::log("info", "Crud:\t   ".$crudName, $comm);
        CoreHelper::log("info", "Table:\t   ".$dbTableName, $comm);
        CoreHelper::log("info", "Migration: ".$migrationName."\n", $comm);

        // Reverse migration generation from table
        $generateData = "";
        $viewColumnName = "view_column_name e.g. name";

        // fa_icon
        $faIcon = "fa-cube";

        if($generate) {
            // check if table, crud and crud fields exists
            $crud = Crud::get($crudName);
            if(isset($crud)) {
                CoreHelper::log("info", "Crud exists :\t   ".$crudName, $comm);

                $viewColumnName = $crud->view_col;
                $faIcon = $crud->fa_icon;

                $ftypes = CrudFieldTypes::getFTypes2();
                foreach ($crud->fields as $field) {
                    $ftype = $ftypes[$field['field_type']];
                    $unique = "false";
                    if($field['unique']) {
                        $unique = "true";
                    }
                    $dvalue = "";
                    if($field['defaultvalue'] != "") {
                        if(starts_with($field['defaultvalue'], "[")) {
                            $dvalue = $field['defaultvalue'];
                        } else {
                            $dvalue = '"'.$field['defaultvalue'].'"';
                        }
                    } else {
                        $dvalue = '""';
                    }
                    $minlength = $field['minlength'];
                    $maxlength = $field['maxlength'];
                    $required = "false";
                    if($field['required']) {
                        $required = "true";
                    }
                    $values = "";
                    if($field['popup_vals'] != "") {
                        if(starts_with($field['popup_vals'], "[")) {
                            $values = ', '.$field['popup_vals'];
                        } else {
                            $values = ', "'.$field['popup_vals'].'"';
                        }
                    }
                    $generateData .= '["'.$field['colname'].'", "'.$field['label'].'", "'.$ftype.'", '.$unique.', '.$dvalue.', '.$minlength.', '.$maxlength.', '.$required.''.$values.'],'."\n            ";
                }
                $generateData = trim($generateData);

                // Find existing migration file
                $mfiles = scandir(base_path('database/migrations/'));
                // print_r($mfiles);
                $fileExists = false;
                $fileExistName = "";
                foreach ($mfiles as $mfile) {
                    if(str_contains($mfile, $migrationName)) {
                        $fileExists = true;
                        $fileExistName = $mfile;
                    }
                }
                if($fileExists) {
                    CoreHelper::log("info", "Replacing old migration file: ".$fileExistName, $comm);
                    $migrationFileName = $fileExistName;
                }
            } else {
                CoreHelper::log("error", "Crud ".$crudName." doesn't exists; Cannot generate !!!", $comm);
            }
        }

        $templateDirectory = __DIR__.'/stubs';

        try {
            CoreHelper::log("line", "Creating migration...", $comm);
            $migrationData = file_get_contents($templateDirectory."/migration.stub");

            $migrationData = str_replace("__migration_class_name__", $migrationClassName, $migrationData);
            $migrationData = str_replace("__db_table_name__", $dbTableName, $migrationData);
            $migrationData = str_replace("__crud_name__", $crudName, $migrationData);
            $migrationData = str_replace("__model_name__", $modelName, $migrationData);
            $migrationData = str_replace("__view_column__", $viewColumnName, $migrationData);
            $migrationData = str_replace("__fa_icon__", $faIcon, $migrationData);
            $migrationData = str_replace("__generated__", $generateData, $migrationData);

            file_put_contents(base_path('database/migrations/'.$migrationFileName), $migrationData);

        } catch (Exception $e) {
            throw new Exception("Unable to generate migration for ".$table." : ".$e->getMessage(), 1);
        }
        CoreHelper::log("info", "Migration done: ".$migrationFileName."\n", $comm);
    }

    // $config = CodeGenerator::generateConfig($crud_name);
    public static function generateConfig($crud, $icon)
    {
        $config = array();
        $config = (object) $config;

        if(starts_with($crud, "create_")) {
            $tname = str_replace("create_", "",$crud);
            $crud = str_replace("_table", "",$tname);
        }

        $config->modelName = ucfirst(str_singular($crud));
        $tableP = str_plural(strtolower($crud));
        $tableS = str_singular(strtolower($crud));
        $config->dbTableName = $tableP;
        $config->fa_icon = $icon;
        $config->crudName = ucfirst(str_plural($crud));
        $config->crudName2 = str_replace('_', ' ', ucfirst(str_plural($crud)));
        $config->controllerName = ucfirst(str_plural($crud))."Controller";
        $config->singularVar = strtolower(str_singular($crud));
        $config->singularCapitalVar = str_replace('_', ' ', ucfirst(str_singular($crud)));

        $crud = Crud::get($config->crudName);
        if(!isset($crud->id)) {
            throw new Exception("Please run 'php artisan migrate' for 'create_".$config->dbTableName."_table' in order to create CRUD.\nOr check if any problem in Crud Name '".$config->crudName."'.", 1);
            return;
        }
        $config->crud = $crud;

        return $config;
    }
}
