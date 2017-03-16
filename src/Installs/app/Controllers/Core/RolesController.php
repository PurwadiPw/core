<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Pw\Core\Models\Crud;
use Pw\Core\Models\CrudFields;
use Zizaco\Entrust\EntrustFacade as Entrust;

use App\Models\Role;
use App\Models\Permission;

class RolesController extends Controller
{
	public $show_action = true;
	public $view_col = 'name';
	public $listing_cols = ['id', 'name', 'display_name', 'parent', 'dept'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Pw\Core\Helpers\CoreHelper::laravel_ver() == 5.4) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = CrudFields::listingColumnAccessScan('Roles', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = CrudFields::listingColumnAccessScan('Roles', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Roles.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$crud = Crud::get('Roles');
		
		if(Crud::hasAccess($crud->id)) {
			return View('core.roles.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'crud' => $crud
			]);
		} else {
            return redirect(config('core.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new role.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created role in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Crud::hasAccess("Roles", "create")) {
		
			$rules = Crud::validateRules("Roles", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$request->name = str_replace(" ", "_", strtoupper(trim($request->name)));
			
			$insert_id = Crud::insert("Roles", $request);
			
			$cruds = Crud::all();
			foreach ($cruds as $crud) {
				Crud::setDefaultRoleAccess($crud->id, $insert_id, "readonly");
			}
			
			$role = Role::find($insert_id);
			$perm = Permission::where("name", "ADMIN_PANEL")->first();
			$role->attachPermission($perm);
			
			return redirect()->route(config('core.adminRoute') . '.roles.index');
			
		} else {
			return redirect(config('core.adminRoute')."/");
		}
	}

	/**
	 * Display the specified role.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Crud::hasAccess("Roles", "view")) {
			
			$role = Role::find($id);
			if(isset($role->id)) {
				$crud = Crud::get('Roles');
				$crud->row = $role;
				
				$cruds_arr = DB::table('cruds')->get();
				$cruds_access = array();
				foreach ($cruds_arr as $crud_obj) {
					$crud_obj->accesses = Crud::getRoleAccess($crud_obj->id, $id)[0];
					$cruds_access[] = $crud_obj;
				}
				return view('core.roles.show', [
					'crud' => $crud,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding",
					'cruds_access' => $cruds_access
				])->with('role', $role);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("role"),
				]);
			}
		} else {
			return redirect(config('core.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified role.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Crud::hasAccess("Roles", "edit")) {
			
			$role = Role::find($id);
			if(isset($role->id)) {
				$crud = Crud::get('Roles');
				
				$crud->row = $role;
				
				return view('core.roles.edit', [
					'crud' => $crud,
					'view_col' => $this->view_col,
				])->with('role', $role);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("role"),
				]);
			}
		} else {
			return redirect(config('core.adminRoute')."/");
		}
	}

	/**
	 * Update the specified role in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Crud::hasAccess("Roles", "edit")) {
			
			$rules = Crud::validateRules("Roles", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$request->name = str_replace(" ", "_", strtoupper(trim($request->name)));
			
			if($request->name == "SUPER_ADMIN") {
				$request->parent = 0;
			}
			
			$insert_id = Crud::updateRow("Roles", $request, $id);
			
			return redirect()->route(config('core.adminRoute') . '.roles.index');
			
		} else {
			return redirect(config('core.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified role from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Crud::hasAccess("Roles", "delete")) {
			Role::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('core.adminRoute') . '.roles.index');
		} else {
			return redirect(config('core.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
		$values = DB::table('roles')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = CrudFields::getCrudFields('Roles');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = CrudFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('core.adminRoute') . '/roles/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Crud::hasAccess("Roles", "edit")) {
					$output .= '<a href="'.url(config('core.adminRoute') . '/roles/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Crud::hasAccess("Roles", "delete")) {
					$output .= Form::open(['route' => [config('core.adminRoute') . '.roles.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
	
	public function save_crud_role_permissions(Request $request, $id)
	{
		if(Entrust::hasRole('SUPER_ADMIN')) {
			$role = Role::find($id);
			$crud = Crud::get('Roles');
			$crud->row = $role;
			
			$cruds_arr = DB::table('cruds')->get();
			$cruds_access = array();
			foreach ($cruds_arr as $crud_obj) {
				$crud_obj->accesses = Crud::getRoleAccess($crud_obj->id, $id)[0];
				$cruds_access[] = $crud_obj;
			}
		
			$now = date("Y-m-d H:i:s");
			
			foreach($cruds_access as $crud) {
				
				/* =============== role_crud_fields =============== */
	
				foreach ($crud->accesses->fields as $field) {
					$field_name = $field['colname'].'_'.$crud->id.'_'.$role->id;
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
						DB:: table('role_crud_fields')->where('role_id', $role->id)->where('field_id', $field['id'])->update(['access' => $access]);
					}
				}
				
				/* =============== role_crud =============== */
	
				$crud_name = 'crud_'.$crud->id;
				if(isset($request->$crud_name)) {
					$view = 'crud_view_'.$crud->id;
					$create = 'crud_create_'.$crud->id;
					$edit = 'crud_edit_'.$crud->id;
					$delete = 'crud_delete_'.$crud->id;
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
					
					$query = DB::table('role_crud')->where('role_id', $id)->where('crud_id', $crud->id);
					if($query->count() == 0) {
						DB::insert('insert into role_crud (role_id, crud_id, acc_view, acc_create, acc_edit, acc_delete, created_at, updated_at) values (?, ?, ?, ?, ?, ?, ?, ?)', [$id, $crud->id, $view, $create, $edit, $delete, $now, $now]);
					} else {
						DB:: table('role_crud')->where('role_id', $id)->where('crud_id', $crud->id)->update(['acc_view' => $view, 'acc_create' => $create, 'acc_edit' => $edit, 'acc_delete' => $delete]);
					}
				} else {
					DB:: table('role_crud')->where('role_id', $id)->where('crud_id', $crud->id)->update(['acc_view' => 0, 'acc_create' => 0, 'acc_edit' => 0, 'acc_delete' => 0]);
				}
			}
			return redirect(config('core.adminRoute') . '/roles/'.$id.'#tab-access');
		} else {
			return redirect(config('core.adminRoute')."/");
		}
	}
}
