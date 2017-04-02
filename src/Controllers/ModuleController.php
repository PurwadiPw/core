<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 22/03/17
 * Time: 6:42
 */

namespace Pw\Core\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\VarDumper\Cloner\Data;
use Yajra\Datatables\Datatables;
use Pw\Core\Models\Menu;
use Pw\Core\Models\Crud;
use Pw\Core\Facades\Module;
use Theme;

class ModuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $req)
    {
        $modules = Module::all();

        if ($req->ajax()){
            return Datatables::of($modules)
                    ->addColumn('status', function($module){
                        return Module::isEnabled($module['slug']) ? 'Aktif' : 'Nonaktif';
                    })
                    ->addColumn('action', function($module){
                        if (Module::isEnabled($module['slug'])){
                            return '<a class="btn btn-danger btn-xs act_module" onclick="actModule('.kutip().'Menonaktifkan'.kutip().', '.kutip().$module['name'].kutip().', '.kutip().$module['slug'].kutip().')" rel="tooltip" data-placement="top" data-original-title="Menonaktifkan Module" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-ban"></i></a>';
                        }else{
                            return '<a class="btn btn-primary btn-xs act_module" onclick="actModule('.kutip().'Mengaktifkan'.kutip().', '.kutip().$module['name'].kutip().', '.kutip().$module['slug'].kutip().')" rel="tooltip" data-placement="top" data-original-title="Mengaktifkan Module" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-check-square-o"></i></a>';
                        }
                    })
                    ->make(true);
        }

        return Theme::view('default::core.modules.index', [
            'modules' => $modules
        ]);
    }

    public function store(Request $req)
    {
        if (Module::exists($req['slug'])){
            $ok = false;
            $messages = 'Maaf, Module Sudah ada';
        }else{
            $command = Artisan::call('make:module', ['slug' => $req['slug'], '--quick' => true]);
            if ($command == 0){
                $module = Module::where('slug', $req['slug']);
                $menu =  Menu::create([
                    "name" => title_case(str_replace('_', ' ', snake_case($module['name']))),
                    "url" => '#',
                    "icon" => "fa fa-cubes",
                    "type" => 'module',
                    "parent" => 0
                ]);
                if ($menu) {
                    $ok = true;
                    $messages = 'Module berhasil di generate';
                }
            }else{
                $ok = false;
                $messages = 'Module gagal di generate';
            }
        }
        return response()->json([
            'ok' => $ok,
            'msg' => $messages
        ]);
    }

    public function act_module($act, $slug)
    {
        $action = $act == 'Mengaktifkan' ? 'enable' : 'disable';
        if (Module::$action($slug)){
            $status = $act == 'Mengaktifkan' ? 'Aktif' : 'Nonaktif';
        }else{
            $status = 'Failed';
        }
        return response()->json([
            'ok' => true,
            'msg' => $status
        ]);
    }
}