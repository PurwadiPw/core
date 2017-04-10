<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 13/03/17
 * Time: 10:49
 */

namespace Pw\Core\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Pw\Core\Helpers\CoreHelper;
use Pw\Core\Models\Crud;
use Pw\Core\Models\Menu;
use Pw\Core\Models\Page;
use Theme;

class MenuController extends Controller
{

    public function __construct()
    {
        // for authentication (optional)
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cruds    = Crud::all();
        $menu     = new Menu;
        $pages = Page::with('trans')->get();

        $type = (!is_null($request->input('type')) ? $request->input('type') : '');
        if ($type == 'backend') {
            $menus = $menu->where('is_backend', 1)->orderBy('hierarchy', 'asc')->get();
        } else {
            $menus = $menu->where('is_backend', 0)->orderBy('hierarchy', 'asc')->get();
        }

        $id = (!is_null($request->input('id')) ? $request->input('id') : '');
        if ($id != '') {
            $menuedit = $menu->where('id', $id)->first();
        } else {
            $menuedit = '';
        }

        return Theme::view('default::core.menus.index', [
            'pages'  => $pages,
            'menuItems' => $menu->getHTML($type, $menus),
            'menus'     => $menus,
            'cruds'     => $cruds,
            'menuedit'  => $menuedit,
            'type'      => $type,
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

        $parent = Input::get('parent');
        $name   = Input::get('name');
        $url    = Input::get('url');
        $icon   = Input::get('icon');
        $type   = Input::get('type');

        $menu = new Menu;

        if ($type == 'crud') {
            $crud_id = Input::get('crud_id');
            $crud    = Crud::find($crud_id);
            if (isset($crud->id)) {
                $menu->icon   = $crud->fa_icon;
                $menu->parent = 0;
            } else {
                return response()->json([
                    "status"  => "failure",
                    "message" => "Crud does not exists",
                ], 200);
            }

            foreach (array_keys(CoreHelper::availableLang()) as $locale) {
                $menu->translateOrNew($locale)->name = $crud->name;
                $menu->translateOrNew($locale)->url  = $crud->url;
            }
        } elseif (($type == 'front') || ($type == 'front-submenu')) {
            $menu->is_backend = 0;
            $menu->parent = $parent;
            $menu->icon   = $icon;
            foreach (array_keys(CoreHelper::availableLang()) as $locale) {
                foreach ($menu->translatedAttributes as $attr) {
                    $menu->translateOrNew($locale)->{$attr} = $request->{$locale}[$attr];
                }
            }
        }
        $menu->type = $type;
        $menu->save();

        if ($type == 'crud') {
            return response()->json([
                "status" => "success",
            ], 200);
        } elseif (($type == 'front') || ($type == 'front-submenu')) {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $ftypes = CrudFieldTypes::getFTypes2();
        // $crud = Crud::find($id);
        // $crud = Crud::get($crud->name);
        // return view('core.cruds.show', [
        //     'no_header' => true,
        //     'no_padding' => "no-padding",
        //     'ftypes' => $ftypes
        // ])->with('crud', $crud);
    }

    /**
     * Update Custom Menu
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $name = Input::get('name');
        $url  = Input::get('url');
        $icon = Input::get('icon');
        $type = Input::get('type');

        $menu       = Menu::find($id);
        $menu->name = $name;
        $menu->url  = $url;
        $menu->icon = $icon;
        $menu->save();

        return redirect(config('core.adminRoute') . '/core_menus');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Menu::find($id)->delete();
        return redirect()->route(config('core.adminRoute') . '.core_menus.index');
    }

    /**
     * Update Menu Hierarchy
     *
     * @return \Illuminate\Http\Response
     */
    public function update_hierarchy()
    {
        $parents   = Input::get('jsonData');
        $parent_id = 0;

        for ($i = 0; $i < count($parents); $i++) {
            $this->apply_hierarchy($parents[$i], $i + 1, $parent_id);
        }

        return $parents;
    }

    public function apply_hierarchy($menuItem, $num, $parent_id)
    {
        // echo "apply_hierarchy: ".json_encode($menuItem)." - ".$num." - ".$parent_id."  <br><br>\n\n";
        $menu            = Menu::find($menuItem['id']);
        $menu->parent    = $parent_id;
        $menu->hierarchy = $num;
        $menu->save();

        if (isset($menuItem['children'])) {
            for ($i = 0; $i < count($menuItem['children']); $i++) {
                $this->apply_hierarchy($menuItem['children'][$i], $i + 1, $menuItem['id']);
            }
        }
    }
}
