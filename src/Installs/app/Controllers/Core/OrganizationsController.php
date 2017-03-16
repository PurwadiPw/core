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

use App\Models\Organization;

class OrganizationsController extends Controller
{
	public $show_action = true;
	public $view_col = 'name';
	public $listing_cols = ['id', 'profile_image', 'name', 'email', 'phone', 'website', 'assigned_to', 'city'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Pw\Core\Helpers\CoreHelper::laravel_ver() == 5.4) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = CrudFields::listingColumnAccessScan('Organizations', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = CrudFields::listingColumnAccessScan('Organizations', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Organizations.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$crud = Crud::get('Organizations');
		
		if(Crud::hasAccess($crud->id)) {
			return View('core.organizations.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'crud' => $crud
			]);
		} else {
            return redirect(config('core.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new organization.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created organization in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Crud::hasAccess("Organizations", "create")) {
		
			$rules = Crud::validateRules("Organizations", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Crud::insert("Organizations", $request);
			
			return redirect()->route(config('core.adminRoute') . '.organizations.index');
			
		} else {
			return redirect(config('core.adminRoute')."/");
		}
	}

	/**
	 * Display the specified organization.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Crud::hasAccess("Organizations", "view")) {
			
			$organization = Organization::find($id);
			if(isset($organization->id)) {
				$crud = Crud::get('Organizations');
				$crud->row = $organization;
				
				return view('core.organizations.show', [
					'crud' => $crud,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('organization', $organization);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("organization"),
				]);
			}
		} else {
			return redirect(config('core.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified organization.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Crud::hasAccess("Organizations", "edit")) {
			$organization = Organization::find($id);
			if(isset($organization->id)) {
				$organization = Organization::find($id);
				
				$crud = Crud::get('Organizations');
				
				$crud->row = $organization;
				
				return view('core.organizations.edit', [
					'crud' => $crud,
					'view_col' => $this->view_col,
				])->with('organization', $organization);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("organization"),
				]);
			}
		} else {
			return redirect(config('core.adminRoute')."/");
		}
	}

	/**
	 * Update the specified organization in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Crud::hasAccess("Organizations", "edit")) {
			
			$rules = Crud::validateRules("Organizations", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Crud::updateRow("Organizations", $request, $id);
			
			return redirect()->route(config('core.adminRoute') . '.organizations.index');
			
		} else {
			return redirect(config('core.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified organization from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Crud::hasAccess("Organizations", "delete")) {
			Organization::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('core.adminRoute') . '.organizations.index');
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
		$values = DB::table('organizations')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = CrudFields::getCrudFields('Organizations');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) {
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && $fields_popup[$col]->field_type_str == "Image") {
					if($data->data[$i][$j] != 0) {
						$img = \App\Models\Upload::find($data->data[$i][$j]);
						if(isset($img->name)) {
							$data->data[$i][$j] = '<img src="'.$img->path().'?s=50">';
						} else {
							$data->data[$i][$j] = "";
						}
					} else {
						$data->data[$i][$j] = "";
					}
				}
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = CrudFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('core.adminRoute') . '/organizations/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Crud::hasAccess("Organizations", "edit")) {
					$output .= '<a href="'.url(config('core.adminRoute') . '/organizations/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Crud::hasAccess("Organizations", "delete")) {
					$output .= Form::open(['route' => [config('core.adminRoute') . '.organizations.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}
