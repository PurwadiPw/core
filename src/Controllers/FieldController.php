<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 13/03/17
 * Time: 10:56
 */

namespace Pw\Core\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Schema;

use Pw\Core\Models\Crud;
use Pw\Core\Models\CrudFields;
use Pw\Core\Models\CrudFieldTypes;
use Pw\Core\Helpers\CoreHelper;

class FieldController extends Controller
{

    public function __construct() {
        // for authentication (optional)
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        $crud = Crud::find($request->crud_id);
        $crud_id = $request->crud_id;

        $field_id = CrudFields::createField($request);

        // Give Default Full Access to Super Admin
        $role = \App\Models\Role::where("name", "SUPER_ADMIN")->first();
        Crud::setDefaultFieldRoleAccess($field_id, $role->id, "full");

        return redirect()->route(config('core.adminRoute') . '.cruds.show', [$crud_id]);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $field = CrudFields::find($id);

        $crud = Crud::find($field->crud);
        $ftypes = CrudFieldTypes::getFTypes2();

        $tables = CoreHelper::getDBTables([]);

        return view('core.cruds.field_edit', [
            'crud' => $crud,
            'ftypes' => $ftypes,
            'tables' => $tables
        ])->with('field', $field);
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
        $crud_id = $request->crud_id;

        CrudFields::updateField($id, $request);

        return redirect()->route(config('core.adminRoute') . '.cruds.show', [$crud_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get Context
        $field = CrudFields::find($id);
        $crud = Crud::find($field->crud);

        // Delete from Table crud_field
        Schema::table($crud->name_db, function ($table) use ($field) {
            $table->dropColumn($field->colname);
        });

        // Delete Context
        $field->delete();
        return redirect()->route(config('core.adminRoute') . '.cruds.show', [$crud->id]);
    }

    /**
     * Check unique values for perticular field
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function check_unique_val(Request $request, $field_id)
    {
        $valExists = false;

        // Get Field
        $field = CrudFields::find($field_id);
        // Get Crud
        $crud = Crud::find($field->crud);

        // echo $crud->name_db." ".$field->colname." ".$request->field_value;
        $rowCount = DB::table($crud->name_db)->where($field->colname, $request->field_value)->where("id", "!=", $request->row_id)->whereNull('deleted_at')->count();

        if($rowCount > 0) {
            $valExists = true;
        }

        return response()->json(['exists' => $valExists]);
    }
}
