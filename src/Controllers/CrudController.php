<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 13/03/17
 * Time: 10:51
 */

namespace Pw\Core\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Pw\Core\Facades\Theme;
use Pw\Core\Facades\Module;
use Pw\Core\Helpers\CoreHelper;
use Pw\Core\Models\Crud;
use Pw\Core\Models\CrudFields;
use Pw\Core\Models\CrudFieldTypes;
use Pw\Core\Helpers\CodeGenerator;
use App\Models\Role;
use Schema;
use Pw\Core\Models\Menu;

use Yajra\Datatables\Datatables;

class CrudController extends Controller
{

    public function __construct() {
        // for authentication (optional)
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $cruds = Crud::all();
        $modules = Module::all();
        if ($req->ajax()){
            return Datatables::of($cruds)
                ->addColumn('name', function ($crud){
                    return '<a href="'.url(config('core.adminRoute') . '/crud/'.$crud->id).'">'.$crud->name.'</a>';
                })
                ->addColumn('module', function($crud){
                    $module = Module::where('slug', $crud->module);
                    $moduleName = $module != '[]' ? $module['name'] : 'Crud ini tidak berada dalam module';
                    return $moduleName;
                })
                ->addColumn('items', function($crud){
                    return Crud::itemCount($crud->name);
                })
                ->addColumn('action', function($crud){
                    return '
						<a href="'.url(config('core.adminRoute') . '/crud/'.$crud->id).'#fields" class="btn btn-primary btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
						<a href="'.url(config('core.adminRoute') . '/crud/'.$crud->id).'#access" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-key"></i></a>
						<a href="'.url(config('core.adminRoute') . '/crud/'.$crud->id).'#sort" class="btn btn-success btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-sort"></i></a>
						<a class="btn btn-danger btn-xs" onClick="actCrud('.kutip().$crud->id.kutip().', '.kutip().$crud->name.kutip().')" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-trash"></i></a>
                    ';
                })
                ->make(true);
        }
        return Theme::view('default::core.cruds.index', [
            'cruds' => $cruds,
            'modules' => $modules
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $crud_id = Crud::generateBase($request->module, $request->name, $request->table, $request->icon);
        return response()->json([
            'ok' => true,
            'data' => $crud_id,
            'msg' => 'Crud berhasil ditambahkan'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ftypes = CrudFieldTypes::getFTypes2();
        $crud = Crud::find($id);
        $crud = Crud::get($crud->name);

        $tables = CoreHelper::getDBTables([]);
        $cruds = CoreHelper::getCrudNames([]);

        // Get Crud Access for all roles
        $roles = Crud::getRoleAccess($id);

        return view('default::core.cruds.show', [
            'no_header' => true,
            'no_padding' => "no-padding",
            'ftypes' => $ftypes,
            'tables' => $tables,
            'cruds' => $cruds,
            'roles' => $roles
        ])->with('crud', $crud);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $crud = Crud::find($id);

        //Delete Menu
        $menuItems = Menu::where('name', $crud->name)->first();
        if(isset($menuItems)) {
            $menuItems->delete();
        }

        // Delete Crud Fields
        $crud_fields = CrudFields::where('crud',$crud->id)->delete();

        // Delete Resource Views directory
        \File::deleteDirectory(resource_path('/views/core/' . $crud->name_db));

        // Delete Controller
        \File::delete(app_path('/Http/Controllers/Core/'.$crud->name.'Controller.php'));

        // Delete Model
        if($crud->model == "User" || $crud->model == "Role" || $crud->model == "Permission") {
            \File::delete(app_path($crud->model.'.php'));
        } else {
            \File::delete(app_path('Models/'.$crud->model.'.php'));
        }

        // Modify Migration for Deletion
        // Find existing migration file
        $mfiles = scandir(base_path('database/migrations/'));
        $fileExistName = "";
        foreach ($mfiles as $mfile) {
            if(str_contains($mfile, "create_".$crud->name_db."_table")) {
                $migrationClassName = ucfirst(camel_case("create_".$crud->name_db."_table"));

                $templateDirectory = __DIR__.'/../stubs';
                $migrationData = file_get_contents($templateDirectory."/migration_removal.stub");
                $migrationData = str_replace("__migration_class_name__", $migrationClassName, $migrationData);
                $migrationData = str_replace("__db_table_name__", $crud->name_db, $migrationData);
                file_put_contents(base_path('database/migrations/'.$mfile), $migrationData);
            }
        }

        // Delete Admin Routes
        if(CoreHelper::laravel_ver() == 5.4) {
            $file_admin_routes = base_path("/routes/admin.php");
        } else {
            $file_admin_routes = base_path("/app/Http/admin.php");
        }
        while(CoreHelper::getLineWithString($file_admin_routes, "Core\\".$crud->name."Controller") != -1) {
            $line = CoreHelper::getLineWithString($file_admin_routes, "Core\\".$crud->name.'Controller');
            $fileData = file_get_contents($file_admin_routes);
            $fileData = str_replace($line, "", $fileData);
            file_put_contents($file_admin_routes, $fileData);
        }
        if(CoreHelper::getLineWithString($file_admin_routes, "=== ".$crud->name." ===") != -1) {
            $line = CoreHelper::getLineWithString($file_admin_routes, "=== ".$crud->name." ===");
            $fileData = file_get_contents($file_admin_routes);
            $fileData = str_replace($line, "", $fileData);
            file_put_contents($file_admin_routes, $fileData);
        }

        // Delete Table
        Schema::drop($crud->name_db);

        // Delete Crud
        $crud->delete();

        $cruds = Crud::all();
        return redirect()->route(config('core.adminRoute') . '.crud.index', ['cruds' => $cruds]);
    }

    /**
     * Generate Cruds CRUD + Model
     *
     * @param  int  $crud_id
     * @return \Illuminate\Http\Response
     */
    public function generate_crud($crud_id)
    {
        $crud = Crud::find($crud_id);
        $crud = Crud::get($crud->name);

        $config = CodeGenerator::generateConfig($crud->name,$crud->fa_icon);

        CodeGenerator::createController($config);
        CodeGenerator::createModel($config);
        CodeGenerator::createViews($config);
        CodeGenerator::appendRoutes($config);
        CodeGenerator::addMenu($config);

        // Set Crud Generated = True
        $crud = Crud::find($crud_id);
        $crud->is_gen='1';
        $crud->save();

        // Give Default Full Access to Super Admin
        $role = Role::where("name", "SUPER_ADMIN")->first();
        Crud::setDefaultRoleAccess($crud->id, $role->id, "full");
    }

    /**
     * Generate Cruds Migrations
     *
     * @param  int  $crud_id
     * @return \Illuminate\Http\Response
     */
    public function generate_migr($crud_id)
    {
        $crud = Crud::find($crud_id);
        $crud = Crud::get($crud->name);
        CodeGenerator::generateMigration($crud->name_db, true);
    }

    /**
     * Generate Cruds Migrations and CRUD Model
     *
     * @param  int  $crud_id
     * @return \Illuminate\Http\Response
     */
    public function generate_migr_crud($crud_id)
    {
        $crud = Crud::find($crud_id);
        $crud = Crud::get($crud->name);

        // Create Config for Code Generation
        $config = CodeGenerator::generateConfig($crud->name, $crud->fa_icon);
        // CoreHelper::log("info", "Migration: ".json_encode($config, JSON_PRETTY_PRINT)."\n", null);

        // Generate Migration
        CodeGenerator::generateMigration($crud->name_db, true, $config->crudName, $config);

        // Generate CRUD
        CodeGenerator::createController($config);
        CodeGenerator::createModel($config);
        CodeGenerator::createViews($config);
        CodeGenerator::appendRoutes($config);
        CodeGenerator::addMenu($config);

        // Set Crud Generated = True
        $crud = Crud::find($crud_id);
        $crud->is_gen='1';
        $crud->save();

        // Give Default Full Access to Super Admin
        $role = Role::where("name", "SUPER_ADMIN")->first();
        Crud::setDefaultRoleAccess($crud->id, $role->id, "full");
    }
    /**
     * Generate Cruds Update(migrations and crud) not routes
     *
     * @param  int  $crud_id
     * @return \Illuminate\Http\Response
     */
    public function generate_update($crud_id)
    {
        $crud = Crud::find($crud_id);
        $crud = Crud::get($crud->name);

        // Generate Migration
        CodeGenerator::generateMigration($crud->name_db, true, $config->crudName, $config);

        // Create Config for Code Generation
        $config = CodeGenerator::generateConfig($crud->name, $crud->fa_icon);

        // Generate CRUD
        CodeGenerator::createController($config);
        CodeGenerator::createModel($config);
        CodeGenerator::createViews($config);

        // Set Crud Generated = True
        $crud = Crud::find($crud_id);
        $crud->is_gen='1';
        $crud->save();
    }

    /**
     * Set the model view_column
     *
     * @param  int  $crud_id
     * @param string $column_name
     * @return \Illuminate\Http\Response
     */
    public function set_view_col($crud_id, $column_name){
        $crud = Crud::find($crud_id);
        $crud->view_col=$column_name;
        $crud->save();

        return redirect()->route(config('core.adminRoute') . '.crud.show', [$crud_id]);
    }

    public function save_role_crud_permissions(Request $request, $id)
    {
        $crud = Crud::find($id);
        $crud = Crud::get($crud->name);

        $tables = CoreHelper::getDBTables([]);
        $cruds = CoreHelper::getCrudNames([]);
        $roles = Role::all();

        $now = date("Y-m-d H:i:s");

        foreach($roles as $role) {

            /* =============== role_crud_fields =============== */

            foreach ($crud->fields as $field) {
                $field_name = $field['colname'].'_'.$role->id;
                $field_value = $request->$field_name;
                if($field_value == 0) {
                    $access = 'invisible';
                } else if($field_value == 1) {
                    $access = 'readonly';
                } else if($field_value == 2) {
                    $access = 'write';
                }

                $query = DB::table('role_crud_fields')->where('role_id', $role->id)->where('field_id', $field['id']);
                if($query->count() == 0) {
                    DB::insert('insert into role_crud_fields (role_id, field_id, access, created_at, updated_at) values (?, ?, ?, ?, ?)', [$role->id, $field['id'], $access, $now, $now]);
                } else {
                    DB::table('role_crud_fields')->where('role_id', $role->id)->where('field_id', $field['id'])->update(['access' => $access]);
                }
            }

            /* =============== role_crud =============== */

            $crud_name = 'crud_'.$role->id;
            if(isset($request->$crud_name)) {
                $view = 'crud_view_'.$role->id;
                $create = 'crud_create_'.$role->id;
                $edit = 'crud_edit_'.$role->id;
                $delete = 'crud_delete_'.$role->id;
                if(isset($request->$view)) {
                    $view = 1;
                } else {
                    $view = 0;
                }
                if(isset($request->$create)) {
                    $create = 1;
                } else {
                    $create = 0;
                }
                if(isset($request->$edit)) {
                    $edit = 1;
                } else {
                    $edit = 0;
                }
                if(isset($request->$delete)) {
                    $delete = 1;
                } else {
                    $delete = 0;
                }

                $query = DB::table('role_crud')->where('role_id', $role->id)->where('crud_id', $id);
                if($query->count() == 0) {
                    DB::insert('insert into role_crud (role_id, crud_id, acc_view, acc_create, acc_edit, acc_delete, created_at, updated_at) values (?, ?, ?, ?, ?, ?, ?, ?)', [$role->id, $id, $view, $create, $edit, $delete, $now, $now]);
                } else {
                    DB::table('role_crud')->where('role_id', $role->id)->where('crud_id', $id)->update(['acc_view' => $view, 'acc_create' => $create, 'acc_edit' => $edit, 'acc_delete' => $delete]);
                }
            }
        }
        return redirect(config('core.adminRoute') . '/crud/'.$id."#access");
    }

    public function save_crud_field_sort(Request $request, $id)
    {
        $sort_array = $request->sort_array;

        foreach ($sort_array as $index => $field_id) {
            DB::table('crud_fields')->where('id', $field_id)->update(['sort' => ($index + 1)]);
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function get_crud_files(Request $request, $crud_id)
    {
        $crud = Crud::find($crud_id);

        $arr = array();
        $arr[] = "app/Http/Controllers/Core/".$crud->controller.".php";
        $arr[] = "app/Models/".$crud->model.".php";
        $views = scandir(resource_path('views/core/'.$crud->name_db));
        foreach ($views as $view) {
            if($view != "." && $view != "..") {
                $arr[] = "resources/views/core/".$view;
            }
        }
        // Find existing migration file
        $mfiles = scandir(base_path('database/migrations/'));
        $fileExistName = "";
        foreach ($mfiles as $mfile) {
            if(str_contains($mfile, "create_".$crud->name_db."_table")) {
                $arr[] = 'database/migrations/' . $mfile;
            }
        }
        return response()->json([
            'files' => $arr
        ]);
    }
}
