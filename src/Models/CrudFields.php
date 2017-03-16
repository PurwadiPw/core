<?php

namespace Pw\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Schema;
use Log;
use DB;

use Pw\Core\Models\Crud;

class CrudFields extends Model
{
    protected $table = 'crud_fields';
    
    protected $fillable = [
        "colname", "label", "crud", "field_type", "unique", "defaultvalue", "minlength", "maxlength", "required", "popup_vals"
    ];
    
    protected $hidden = [
        
    ];
    
    public static function createField($request) {
        $crud = Crud::find($request->crud_id);
        $crud_id = $request->crud_id;
        
        $field = CrudFields::where('colname', $request->colname)->where('crud', $crud_id)->first();
        if(!isset($field->id)) {
            $field = new CrudFields;
            $field->colname = $request->colname;
            $field->label = $request->label;
            $field->crud = $request->crud_id;
            $field->field_type = $request->field_type;
            if($request->unique) {
                $field->unique = true;
            } else {
                $field->unique = false;
            }
            $field->defaultvalue = $request->defaultvalue;
            if($request->minlength == "") {
				$request->minlength = 0;
			}
			if($request->maxlength == "") {
				if(in_array($request->field_type, [1, 8, 16, 17, 19, 20, 22, 23 ])) {
					$request->maxlength = 256;
				} else if(in_array($request->field_type, [14])) {
					$request->maxlength = 20;
				} else if(in_array($request->field_type, [3, 6, 10, 13])) {
					$request->maxlength = 11;
				}
			}
            $field->minlength = $request->minlength;
            if($request->maxlength != null && $request->maxlength != "") {
				$field->maxlength = $request->maxlength;
			}
            if($request->required) {
                $field->required = true;
            } else {
                $field->required = false;
            }
            if($request->field_type == 7 || $request->field_type == 15 || $request->field_type == 18 || $request->field_type == 20) {
                if($request->popup_value_type == "table") {
                    $field->popup_vals = "@".$request->popup_vals_table;
                } else if($request->popup_value_type == "list") {
                    $request->popup_vals_list = json_encode($request->popup_vals_list);
                    $field->popup_vals = $request->popup_vals_list;
                }
            } else {
				$field->popup_vals = "";
			}
            $field->save();
            
            // Create Schema for Crud Field
            if (!Schema::hasTable($crud->name_db)) {
                Schema::create($crud->name_db, function($table) {
                    $table->increments('id');
                    $table->softDeletes();
                    $table->timestamps();
                });
            }
            Schema::table($crud->name_db, function($table) use ($field, $crud) {
                // $table->string($field->colname);
                // createUpdateFieldSchema()
				$field->crud_obj = $crud;
				Crud::create_field_schema($table, $field, false);
            });
        }
        return $field->id;
    }

    public static function updateField($id, $request) {
        $crud_id = $request->crud_id;
        
        $field = CrudFields::find($id);

        // Update the Schema
        // Change Column Name if Different
        $crud = Crud::find($crud_id);
        if($field->colname != $request->colname) {
            Schema::table($crud->name_db, function ($table) use ($field, $request) {
                $table->renameColumn($field->colname, $request->colname);
            });
        }
        
		$isFieldTypeChange = false;

        // Update Context in CrudFields
        $field->colname = $request->colname;
        $field->label = $request->label;
        $field->crud = $request->crud_id;
        $field->field_type = $request->field_type;
		if($field->field_type != $request->field_type) {
			$isFieldTypeChange = true;
		}
        if($request->unique) {
            $field->unique = true;
        } else {
            $field->unique = false;
        }
        $field->defaultvalue = $request->defaultvalue;
        if($request->minlength == "") {
			$request->minlength = 0;
		}
		if($request->maxlength == "" || $request->maxlength == 0) {
			if(in_array($request->field_type, [1, 8, 16, 17, 19, 20, 22, 23 ])) {
				$request->maxlength = 256;
			} else if(in_array($request->field_type, [14])) {
				$request->maxlength = 20;
			} else if(in_array($request->field_type, [3, 6, 10, 13])) {
				$request->maxlength = 11;
			}
		}
		$field->minlength = $request->minlength;
		if($request->maxlength != null && $request->maxlength != "") {
			$field->maxlength = $request->maxlength;
		}
        if($request->required) {
            $field->required = true;
        } else {
            $field->required = false;
        }
        if($request->field_type == 7 || $request->field_type == 15 || $request->field_type == 18 || $request->field_type == 20) {
            if($request->popup_value_type == "table") {
                $field->popup_vals = "@".$request->popup_vals_table;
            } else if($request->popup_value_type == "list") {
                $request->popup_vals_list = json_encode($request->popup_vals_list);
                $field->popup_vals = $request->popup_vals_list;
            }
        } else {
			$field->popup_vals = "";
		}
        $field->save();

		$field->crud_obj = $crud;

        Schema::table($crud->name_db, function ($table) use ($field, $isFieldTypeChange) {
            Crud::create_field_schema($table, $field, true, $isFieldTypeChange);
        });
    }

	public static function getCrudFields($crudName) {
        $crud = Crud::where('name', $crudName)->first();
        $fields = DB::table('crud_fields')->where('crud', $crud->id)->get();
        $ftypes = CrudFieldTypes::getFTypes();
		
		$fields_popup = array();
        $fields_popup['id'] = null;
        
		foreach($fields as $f) {
			$f->field_type_str = array_search($f->field_type, $ftypes);
            $fields_popup [ $f->colname ] = $f;
        }
		return $fields_popup;
    }

	public static function getFieldValue($field, $value) {
        $external_table_name = substr($field->popup_vals, 1);
		if(Schema::hasTable($external_table_name)) {
			$external_value = DB::table($external_table_name)->where('id', $value)->get();
			if(isset($external_value[0])) {
                $external_crud = DB::table('cruds')->where('name_db', $external_table_name)->first();
                if(isset($external_crud->view_col)) {
                    $external_value_viewcol_name = $external_crud->view_col;
				    return $external_value[0]->$external_value_viewcol_name;
                } else {
                    if(isset($external_value[0]->{"name"})) {
                        return $external_value[0]->name;
                    } else if(isset($external_value[0]->{"title"})) {
                        return $external_value[0]->title;
                    }
                }
			} else {
				return $value;
			}
		} else {
			return $value;
		}
    }
	
	public static function listingColumnAccessScan($crud_name, $listing_cols) {
        $crud = Crud::get($crud_name);
		$listing_cols_temp = array();
		foreach ($listing_cols as $col) {
			if($col == 'id') {
				$listing_cols_temp[] = $col;
			} else if(Crud::hasFieldAccess($crud->id, $crud->fields[$col]['id'])) {
				$listing_cols_temp[] = $col;
			}
		}
		return $listing_cols_temp;
    }
}
