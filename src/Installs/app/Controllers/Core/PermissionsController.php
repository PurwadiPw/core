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
use Pw\Core\Helpers\CoreHelper;
use Zizaco\Entrust\EntrustFacade as Entrust;

use App\Models\Permission;
use App\Models\Role;

use Theme;

class PermissionsController extends Controller
{
	public $show_action = true;
	public $view_col = 'name';
	public $listing_cols = ['id', 'name', 'display_name'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(CoreHelper::laravel_ver() == 5.4) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = CrudFields::listingColumnAccessScan('Permissions', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = CrudFields::listingColumnAccessScan('Permissions', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Permissions.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$crud = Crud::get('Permissions');
		
		if(Crud::hasAccess($crud->id)) {
			return Theme::view('default::core.permissions.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'crud' => $crud
			]);
		} else {
            return redirect(config('core.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new permission.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created permission in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Crud::hasAccess("Permissions", "create")) {
		
			$rules = Crud::validateRules("Permissions", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
            	$ok = false;
            	$messages = $validator->messages();
			}
			
			$insert_id = Crud::insert("Permissions", $request);
			
            $ok = true;
            $messages = 'Berhasil';
			
		} else {
            $ok = false;
            $messages = 'Anda tidak mempunyai akses "Create Permission"';
		}
        return response()->json([
        	'ok' => $ok,
        	'msg' => $messages
        ]);
	}

	/**
	 * Display the specified permission.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Crud::hasAccess("Permissions", "view")) {
			
			$permission = Permission::find($id);
			if(isset($permission->id)) {
				$crud = Crud::get('Permissions');
				$crud->row = $permission;
				
				$roles = Role::all();
				
				return Theme::view('default::core.permissions.show', [
					'crud' => $crud,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding",
					'roles' => $roles
				])->with('permission', $permission);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("permission"),
				]);
			}
		} else {
			return redirect(config('core.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified permission.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Crud::hasAccess("Permissions", "edit")) {
			$permission = Permission::find($id);
			if(isset($permission->id)) {
				$crud = Crud::get('Permissions');
				$crud->row = $permission;
				
				return Theme::view('default::core.permissions.edit', [
					'crud' => $crud,
					'view_col' => $this->view_col,
				])->with('permission', $permission);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("permission"),
				]);
			}
		} else {
			return redirect(config('core.adminRoute')."/");
		}
	}

	/**
	 * Update the specified permission in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Crud::hasAccess("Permissions", "edit")) {
			
			$rules = Crud::validateRules("Permissions", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Crud::updateRow("Permissions", $request, $id);
			
			return redirect()->route(config('core.adminRoute') . '.permissions.index');
			
		} else {
			return redirect(config('core.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified permission from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Crud::hasAccess("Permissions", "delete")) {
			Permission::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('core.adminRoute') . '.permissions.index');
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
		$values = DB::table('permissions')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = CrudFields::getCrudFields('Permissions');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = CrudFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('core.adminRoute') . '/permissions/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Crud::hasAccess("Permissions", "edit")) {
					$output .= '<a href="'.url(config('core.adminRoute') . '/permissions/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Crud::hasAccess("Permissions", "delete")) {
					$output .= Form::open(['route' => [config('core.adminRoute') . '.permissions.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
	
	/**
	 * Save the  permissions for role in permission view.
	 *
	 * @param  int  $id
	 * @return Redirect to permisssions page
	 */
	public function save_permissions(Request $request, $id)
	{
		if(Entrust::hasRole('SUPER_ADMIN')) {
			$permission = Permission::find($id);
			$crud = Crud::get('Permissions');
			$crud->row = $permission;
			$roles = Role::all();
			
			foreach ($roles as $role) {
				$permi_role_id = 'permi_role_'.$role->id;
				$permission_set = $request->$permi_role_id;
				if(isset($permission_set)) {
					$query = DB::table('permission_role')->where('permission_id', $id)->where('role_id', $role->id);
					if($query->count() == 0) {
						DB::insert('insert into permission_role (permission_id, role_id) values (?, ?)', [$id, $role->id]);
					}
				} else {
					$query = DB::table('permission_role')->where('permission_id', $id)->where('role_id', $role->id);
					if($query->count() > 0) {
						DB::delete('delete from permission_role where permission_id = "'.$id.'" AND role_id = "'.$role->id.'" ');
					}
				}
			}
			return redirect(config('core.adminRoute') . '/permissions/'.$id."#tab-access");
		} else {
			return redirect(config('core.adminRoute')."/");
		}
	}
}
