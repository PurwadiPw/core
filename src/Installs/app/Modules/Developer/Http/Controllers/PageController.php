<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 13/03/17
 * Time: 10:49
 */

namespace App\Modules\Developer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Pw\Core\Helpers\CoreHelper;
use Pw\Core\Models\Crud;
use Pw\Core\Models\Page;
use Pw\Core\Models\Menu;
use Theme;
use DB;

class PageController extends Controller
{
    public $show_action = true;

    public $listing_cols = ['id', 'title', 'slug', 'active'];

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
        return Theme::view('default::core.pages.index', [
            'show_actions' => $this->show_action,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = Menu::where('type', 'front')->where('parent', 0)->where('is_backend', 0)->get();
        $returnHTML = Theme::view('default::core.pages.opr.create', [
            'menus' => $menus
        ])->render();

        return response()->json([
            'success'  => true,
            'msg' => 'Single Data',
            'html'     => $returnHTML,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $page = new Page;

        $page->template = '';
        $page->core_menus_id = $req->menu;
        $page->active = $req->active;

        foreach (array_keys(CoreHelper::availableLang()) as $locale) {
            foreach ($page->translatedAttributes as $attr) {
                $page->translateOrNew($locale)->{$attr} = $req->{$locale}[$attr];
            }
        }

        if ($page->save()) {
            $ok = true;
            $messages = 'Data Berhasil Disimpan!!';            
        }else{
            $ok = false;
            $messages = 'Data Gagal Disimpan!!';
        }
        return response()->json([
            'ok' => $ok,
            'msg' => $messages
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
        $pages = Page::where('id',$id)->first();
        if (isset($pages->id)) {
            $returnHTML = Theme::view('default::core.pages.opr.read', [
                'page' => $pages,
            ])->render();

            return response()->json([
                'success'  => true,
                'msg' => $pages,
                'html'     => $returnHTML,
            ]);
        } else {
            return response()->json([
                'success'  => false,
                'msg' => 'Single Data',
                'html'     => '',
            ]);
        }
    }

    /**
     * Show the form for editing the specified crud_satu.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageedit = Page::where('id',$id)->first();
        $menus = Menu::where('type', 'front')->where('parent', 0)->where('is_backend', 0)->get();
        if (isset($pageedit->id)) {
            $returnHTML = Theme::view('default::core.pages.opr.update', [
                'pageedit' => $pageedit,
                'menus' => $menus
            ])->render();

            return response()->json([
                'success'  => true,
                'msg' => $pageedit,
                'html'     => $returnHTML,
            ]);
        } else {
            return response()->json([
                'success'  => false,
                'msg' => 'Single Data',
                'html'     => '',
            ]);
        }
    }

    /**
     * Update Custom Menu
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {

        $page = Page::find($id);

        $page->template = '';
        $page->active = $req->active;

        foreach (array_keys(CoreHelper::availableLang()) as $locale) {
            foreach ($page->translatedAttributes as $attr) {
                $page->translateOrNew($locale)->{$attr} = $req->{$locale}[$attr];
            }
        }

        if ($page->save()) {
            $ok = true;
            $messages = 'Data Berhasil Diubah!!';            
        }else{
            $ok = false;
            $messages = 'Data Gagal Diubah!!';
        }
        return response()->json([
            'ok' => $ok,
            'msg' => $messages
        ]);
    }

    /**
     * Remove the specified Pages from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $pages = Page::where('id',$id)->first();
        if (isset($pages->id)) {
            $returnHTML = Theme::view('default::core.pages.opr.delete', [
                'page' => $pages,
            ])->render();

            return response()->json([
                'success'  => true,
                'msg' => $pages,
                'html'     => $returnHTML,
            ]);
        } else {
            return response()->json([
                'success'  => false,
                'msg' => 'Single Data',
                'html'     => '',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $req)
    {
        if (is_array($req->id)) {
            foreach ($req->id as $idM) {
                $page = Page::where('id', $idM)->first();
                $page->deleteTranslations();
                $page->delete();
            }
            $ok = true;
            $messages = 'Data Berhasil Dihapus!!';
        }else{
            $page = Page::where('id', $id)->first();
            $page->deleteTranslations();
            $page->delete();

            $ok = true;
            $messages = 'Data Berhasil Dihapus!!';
        }
        return response()->json([
            'ok' => $ok,
            'msg' => $messages
        ]);
    }

    /**
     * Datatable Ajax fetch
     *
     * @return
     */
    public function dtajax()
    {
        $values = Page::with('trans')->get();
        $out    = Datatables::of($values)->make();
        $data   = $out->getData();

        for ($i = 0; $i < count($data->data); $i++) {
            for ($j = 0; $j < count($this->listing_cols); $j++) {
                $col = $this->listing_cols[$j];
                if ($col == 'active') {
                    $data->data[$i][$j] = $values[$i][$col] == 1 ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>';
                }else{
                    $data->data[$i][$j] = $values[$i][$col];
                }
            }
        }

        $out->setData($data);
        return $out;
        /*$page = new Page;
        foreach ($page->translatedAttributes as $row) {
            echo DB::connection()->getDoctrineColumn('core_pages_translation', $row)->getType()->getName().'<br>';
        }*/
    }

    public function openTab(Request $req)
    {
        $input = $req->all();
        if ($req->isMethod('post') && $req->ajax()) {
            if ($input['dataId'] || ($input['dataId'] == '0')) {
                if (is_array($input['dataId'])) {
                    return response()->json([
                        'success'  => true,
                        'msg' => 'Delete multiple',
                        'html'     => false,
                    ]);
                } else {
                    $id = $input['dataId'];
                    switch ($input['act']) {
                        case 'create':
                            return $this->create();
                        break;

                        case 'read':
                            return $this->show($id);
                        break;

                        case 'update':
                            return $this->edit($id);
                        break;

                        case 'delete':
                            return $this->delete($id);
                        break;

                        case 'audit':
                            return response()->json([
                                'success'  => true,
                                'msg' => 'Audit'
                            ]);
                        break;
                    }
                }
            }
        }
    }
}
