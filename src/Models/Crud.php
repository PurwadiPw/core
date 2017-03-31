<?php

namespace Pw\Core\Models;

use DB;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Log;
use Pw\Core\Facades\Module;
use Pw\Core\Helpers\CoreHelper;

class Crud extends Model
{
    protected $table = 'cruds';

    protected $fillable = [
        "module", "name", "name_db", "label", "view_col", "model", "controller", "is_gen", "fa_icon",
    ];

    protected $hidden = [

    ];

    public static function generateBase($module, $crud_name, $table, $icon)
    {

        $names = CoreHelper::generateCrudNames($module, $crud_name, $table, $icon);

        // Check is Generated
        $is_gen = false;
        if (file_exists(base_path('app/Modules/' . ($names->module) . '/Http/Controllers/' . ($names->controller) . ".php"))) {
            if (($names->model == "User" || $names->model == "Role" || $names->model == "Permission") && file_exists(base_path('app/Models/' . ($names->model) . ".php"))) {
                $is_gen = true;
            } else if (file_exists(base_path('app/Modules/' . ($names->module) . '/Models/' . ($names->model) . ".php"))) {
                $is_gen = true;
            }
        }
        $crud = Crud::where('name', $names->crud)->first();
        if (!isset($crud->id)) {
            $crud = Crud::create([
                'module'     => $names->module,
                'name'       => $names->crud,
                'label'      => title_case(str_replace('_', ' ', snake_case($names->label))),
                'name_db'    => $names->table,
                'view_col'   => "",
                'model'      => $names->model,
                'controller' => $names->controller,
                'fa_icon'    => $names->fa_icon,
                'is_gen'     => $is_gen,

            ]);
        }
        return $crud->id;
    }

    public static function generate($module = null, $crud_name, $crud_name_db, $view_col, $faIcon = "fa-cube", $fields)
    {

        $names  = CoreHelper::generateCrudNames($module, $crud_name, $crud_name_db, $faIcon);
        $fields = Crud::format_fields($fields);

        if (substr_count($view_col, " ") || substr_count($view_col, ".")) {
            throw new Exception("Unable to generate migration for " . ($names->crud) . " : Invalid view_column_name. 'This should be database friendly lowercase name.'", 1);
        } else if (!Crud::validate_view_column($fields, $view_col)) {
            throw new Exception("Unable to generate migration for " . ($names->crud) . " : view_column_name not found in field list.", 1);
        } else {
            // Check is Generated
            $is_gen = false;
            if ($module != null) {
            	$ctrlDir = 'Modules/'.$names->module.'/Http/Controllers/' . ($names->controller) . '.php';
            	$mdlDir = 'Modules/'.$names->module.'/Models/' . ($names->model) . ".php";
            }else{
            	$ctrlDir = 'Http/Controllers/' . ($names->controller) . '.php';
            	$mdlDir = 'Models/' . ($names->model) . ".php";
            }
            if (file_exists(app_path($ctrlDir))) {
                if (($names->model == "User" || $model == "Role" || $model == "Permission") && file_exists(app_path($mdlDir))) {
                    $is_gen = true;
                } else if (file_exists(app_path($mdlDir))) {
                    $is_gen = true;
                }
            }

            $crud = Crud::where('name', $names->crud)->first();
            if (!isset($crud->id)) {
                $crud = Crud::create([
                    'module'     => $names->module,
                    'name'       => $names->crud,
                    'label'      => $names->label,
                    'name_db'    => $names->table,
                    'view_col'   => $view_col,
                    'model'      => $names->model,
                    'controller' => $names->controller,
                    'is_gen'     => $is_gen,
                    'fa_icon'    => $faIcon,
                ]);
            }

            $ftypes = CrudFieldTypes::getFTypes();

            Schema::create($names->table, function (Blueprint $table) use ($fields, $crud, $ftypes) {
                $table->increments('id');
                foreach ($fields as $field) {

                    $mod = CrudFields::where('crud', $crud->id)->where('colname', $field->colname)->first();
                    if (!isset($mod->id)) {
                        if ($field->field_type == "Multiselect" || $field->field_type == "Taginput") {

                            if (is_string($field->defaultvalue) && starts_with($field->defaultvalue, "[")) {
                                $field->defaultvalue = json_decode($field->defaultvalue);
                            }

                            if (is_string($field->defaultvalue) || is_int($field->defaultvalue)) {
                                $dvalue = json_encode([$field->defaultvalue]);
                            } else {
                                $dvalue = json_encode($field->defaultvalue);
                            }
                        } else {
                            $dvalue = $field->defaultvalue;
                            if (is_string($field->defaultvalue) || is_int($field->defaultvalue)) {
                                $dvalue = $field->defaultvalue;
                            } else if (is_array($field->defaultvalue) && is_object($field->defaultvalue)) {
                                $dvalue = json_encode($field->defaultvalue);
                            }
                        }

                        $pvalues = $field->popup_vals;
                        if (is_array($field->popup_vals) || is_object($field->popup_vals)) {
                            $pvalues = json_encode($field->popup_vals);
                        }

                        $field_obj = CrudFields::create([
                            'crud'         => $crud->id,
                            'colname'      => $field->colname,
                            'label'        => $field->label,
                            'field_type'   => $ftypes[$field->field_type],
                            'unique'       => $field->unique,
                            'defaultvalue' => $dvalue,
                            'minlength'    => $field->minlength,
                            'maxlength'    => $field->maxlength,
                            'required'     => $field->required,
                            'popup_vals'   => $pvalues,
                        ]);
                        $field->id       = $field_obj->id;
                        $field->crud_obj = $crud;
                    }

                    // Schema::dropIfExists($names->table);

                    Crud::create_field_schema($table, $field);
                }

                if ($crud->name_db == "users") {
                    $table->rememberToken();
                }

                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    public static function validate_view_column($fields, $view_col)
    {
        $found = false;
        foreach ($fields as $field) {
            if ($field->colname == $view_col) {
                $found = true;
                break;
            }
        }
        return $found;
    }

    public static function create_field_schema($table, $field, $update = false, $isFieldTypeChange = false)
    {
        if (is_numeric($field->field_type)) {
            $ftypes            = CrudFieldTypes::getFTypes();
            $field->field_type = array_search($field->field_type, $ftypes);
        }
        if (!is_string($field->defaultvalue)) {
            $defval = json_encode($field->defaultvalue);
        } else {
            $defval = $field->defaultvalue;
        }
        Log::debug('Crud:create_field_schema (' . $update . ') - ' . $field->colname . " - " . $field->field_type
            . " - " . $defval . " - " . $field->maxlength);

        switch ($field->field_type) {
            case 'Address':
                $var = null;
                if ($field->maxlength == 0) {
                    if ($update) {
                        $var = $table->text($field->colname)->change();
                    } else {
                        $var = $table->text($field->colname);
                    }
                } else {
                    if ($update) {
                        $var = $table->string($field->colname, $field->maxlength)->change();
                    } else {
                        $var = $table->string($field->colname, $field->maxlength);
                    }
                }
                if ($field->defaultvalue != "") {
                    $var->default($field->defaultvalue);
                } else if ($field->required) {
                    $var->default("");
                }
                break;
            case 'Checkbox':
                if ($update) {
                    $var = $table->boolean($field->colname)->change();
                } else {
                    $var = $table->boolean($field->colname);
                }
                if ($field->defaultvalue == "true" || $field->defaultvalue == "false" || $field->defaultvalue == true || $field->defaultvalue == false) {
                    if (is_string($field->defaultvalue)) {
                        if ($field->defaultvalue == "true") {
                            $field->defaultvalue = true;
                        } else {
                            $field->defaultvalue = false;
                        }
                    }
                    $var->default($field->defaultvalue);
                } else if ($field->required) {
                    $field->defaultvalue = false;
                }
                break;
            case 'Currency':
                if ($update) {
                    $var = $table->double($field->colname, 15, 2)->change();
                } else {
                    $var = $table->double($field->colname, 15, 2);
                }
                if ($field->defaultvalue != "") {
                    $var->default($field->defaultvalue);
                } else if ($field->required) {
                    $var->default("0.0");
                }
                break;
            case 'Date':
                if ($update) {
                    $var = $table->date($field->colname)->change();
                } else {
                    $var = $table->date($field->colname);
                }
                if ($field->defaultvalue != "" && !starts_with($field->defaultvalue, "date")) {
                    $var->default($field->defaultvalue);
                } else if ($field->required) {
                    $var->default("1970-01-01");
                }
                break;
            case 'Datetime':
                if ($update) {
                    // Timestamp Edit Not working - http://stackoverflow.com/questions/34774628/how-do-i-make-doctrine-support-timestamp-columns
                    // Error Unknown column type "timestamp" requested. Any Doctrine type that you use has to be registered with \Doctrine\DBAL\Types\Type::addType()
                    // $var = $table->timestamp($field->colname)->change();
                } else {
                    $var = $table->timestamp($field->colname);
                }
                // $table->timestamp('created_at')->useCurrent();
                if (isset($var) && $field->defaultvalue != "" && !starts_with($field->defaultvalue, "date")) {
                    $var->default($field->defaultvalue);
                } else if ($field->required) {
                    $var->default("1970-01-01 01:01:01");
                }
                break;
            case 'Decimal':
                $var = null;
                if ($update) {
                    $var = $table->decimal($field->colname, 15, 3)->change();
                } else {
                    $var = $table->decimal($field->colname, 15, 3);
                }
                if ($field->defaultvalue != "") {
                    $var->default($field->defaultvalue);
                } else if ($field->required) {
                    $var->default("0.0");
                }
                break;
            case 'Dropdown':
                if ($field->popup_vals == "") {
                    if (is_int($field->defaultvalue)) {
                        if ($update) {
                            $var = $table->integer($field->colname)->unsigned()->change();
                        } else {
                            $var = $table->integer($field->colname)->unsigned();
                        }
                        $var->default($field->defaultvalue);
                        break;
                    } else if (is_string($field->defaultvalue)) {
                        if ($update) {
                            $var = $table->string($field->colname)->change();
                        } else {
                            $var = $table->string($field->colname);
                        }
                        $var->default($field->defaultvalue);
                        break;
                    }
                }
                $popup_vals = json_decode($field->popup_vals);
                if (starts_with($field->popup_vals, "@")) {
                    $foreign_table_name = str_replace("@", "", $field->popup_vals);
                    if ($update) {
                        $var = $table->integer($field->colname)->unsigned()->change();
                        if ($field->defaultvalue == "" || $field->defaultvalue == "0") {
                            $var->default(1);
                        } else {
                            $var->default($field->defaultvalue);
                        }
                        $table->dropForeign($field->crud_obj->name_db . "_" . $field->colname . "_foreign");
                        $table->foreign($field->colname)->references('id')->on($foreign_table_name);
                    } else {
                        $var = $table->integer($field->colname)->unsigned();
                        if ($field->defaultvalue == "" || $field->defaultvalue == "0") {
                            $var->default(1);
                        } else {
                            $var->default($field->defaultvalue);
                        }
                        $table->foreign($field->colname)->references('id')->on($foreign_table_name);
                    }
                } else if (is_array($popup_vals)) {
                    if ($update) {
                        $var = $table->string($field->colname)->change();
                    } else {
                        $var = $table->string($field->colname);
                    }
                    if ($field->defaultvalue != "") {
                        $var->default($field->defaultvalue);
                    } else if ($field->required) {
                        $var->default("");
                    }
                } else if (is_object($popup_vals)) {
                    // ############### Remaining
                    if ($update) {
                        $var = $table->integer($field->colname)->unsigned()->change();
                    } else {
                        $var = $table->integer($field->colname)->unsigned();
                    }
                    // if(is_int($field->defaultvalue)) {
                    //     $var->default($field->defaultvalue);
                    //     break;
                    // }
                }
                break;
            case 'Email':
                $var = null;
                if ($field->maxlength == 0) {
                    if ($update) {
                        $var = $table->string($field->colname, 100)->change();
                    } else {
                        $var = $table->string($field->colname, 100);
                    }
                } else {
                    if ($update) {
                        $var = $table->string($field->colname, $field->maxlength)->change();
                    } else {
                        $var = $table->string($field->colname, $field->maxlength);
                    }
                }
                if ($field->defaultvalue != "") {
                    $var->default($field->defaultvalue);
                } else if ($field->required) {
                    $var->default("");
                }
                break;
            case 'File':
                if ($update) {
                    $var = $table->integer($field->colname)->change();
                } else {
                    $var = $table->integer($field->colname);
                }
                if ($field->defaultvalue != "" && is_numeric($field->defaultvalue)) {
                    $var->default($field->defaultvalue);
                } else if ($field->required) {
                    $var->default(0);
                }
                break;
            case 'Files':
                if ($update) {
                    $var = $table->string($field->colname, 256)->change();
                } else {
                    $var = $table->string($field->colname, 256);
                }
                if (is_string($field->defaultvalue) && starts_with($field->defaultvalue, "[")) {
                    $var->default($field->defaultvalue);
                } else if (is_array($field->defaultvalue)) {
                    $var->default(json_encode($field->defaultvalue));
                } else {
                    $var->default("[]");
                }
                break;
            case 'Float':
                if ($update) {
                    $var = $table->float($field->colname)->change();
                } else {
                    $var = $table->float($field->colname);
                }
                if ($field->defaultvalue != "") {
                    $var->default($field->defaultvalue);
                } else if ($field->required) {
                    $var->default("0.0");
                }
                break;
            case 'HTML':
                if ($update) {
                    $var = $table->string($field->colname, 10000)->change();
                } else {
                    $var = $table->string($field->colname, 10000);
                }
                if ($field->defaultvalue != null) {
                    $var->default($field->defaultvalue);
                } else if ($field->required) {
                    $var->default("");
                }
                break;
            case 'Image':
                if ($update) {
                    $var = $table->integer($field->colname)->change();
                } else {
                    $var = $table->integer($field->colname);
                }
                if ($field->defaultvalue != "" && is_numeric($field->defaultvalue)) {
                    $var->default($field->defaultvalue);
                } else if ($field->required) {
                    $var->default(1);
                }
                break;
            case 'Integer':
                $var = null;
                if ($update) {
                    $var = $table->integer($field->colname, false)->unsigned()->change();
                } else {
                    $var = $table->integer($field->colname, false)->unsigned();
                }
                if ($field->defaultvalue != "") {
                    $var->default($field->defaultvalue);
                } else if ($field->required) {
                    $var->default("0");
                }
                break;
            case 'Mobile':
                $var = null;
                if ($field->maxlength == 0) {
                    if ($update) {
                        $var = $table->string($field->colname)->change();
                    } else {
                        $var = $table->string($field->colname);
                    }
                } else {
                    if ($update) {
                        $var = $table->string($field->colname, $field->maxlength)->change();
                    } else {
                        $var = $table->string($field->colname, $field->maxlength);
                    }
                }
                if ($field->defaultvalue != "") {
                    $var->default($field->defaultvalue);
                } else if ($field->required) {
                    $var->default("");
                }
                break;
            case 'Multiselect':
                if ($update) {
                    $var = $table->string($field->colname, 256)->change();
                } else {
                    $var = $table->string($field->colname, 256);
                }
                if (is_array($field->defaultvalue)) {
                    $field->defaultvalue = json_encode($field->defaultvalue);
                    $var->default($field->defaultvalue);
                } else if (is_string($field->defaultvalue) && starts_with($field->defaultvalue, "[")) {
                    $var->default($field->defaultvalue);
                } else if ($field->defaultvalue == "" || $field->defaultvalue == null) {
                    $var->default("[]");
                } else if (is_string($field->defaultvalue)) {
                    $field->defaultvalue = json_encode([$field->defaultvalue]);
                    $var->default($field->defaultvalue);
                } else if (is_int($field->defaultvalue)) {
                    $field->defaultvalue = json_encode([$field->defaultvalue]);
                    //echo "int: ".$field->defaultvalue;
                    $var->default($field->defaultvalue);
                } else if ($field->required) {
                    $var->default("[]");
                }
                break;
            case 'Name':
                $var = null;
                if ($field->maxlength == 0) {
                    if ($update) {
                        $var = $table->string($field->colname)->change();
                    } else {
                        $var = $table->string($field->colname);
                    }
                } else {
                    if ($update) {
                        $var = $table->string($field->colname, $field->maxlength)->change();
                    } else {
                        $var = $table->string($field->colname, $field->maxlength);
                    }
                }
                if ($field->defaultvalue != "") {
                    $var->default($field->defaultvalue);
                } else if ($field->required) {
                    $var->default("");
                }
                break;
            case 'Password':
                $var = null;
                if ($field->maxlength == 0) {
                    if ($update) {
                        $var = $table->string($field->colname)->change();
                    } else {
                        $var = $table->string($field->colname);
                    }
                } else {
                    if ($update) {
                        $var = $table->string($field->colname, $field->maxlength)->change();
                    } else {
                        $var = $table->string($field->colname, $field->maxlength);
                    }
                }
                if ($field->defaultvalue != "") {
                    $var->default($field->defaultvalue);
                } else if ($field->required) {
                    $var->default("");
                }
                break;
            case 'Radio':
                $var = null;
                if ($field->popup_vals == "") {
                    if (is_int($field->defaultvalue)) {
                        if ($update) {
                            $var = $table->integer($field->colname)->unsigned()->change();
                        } else {
                            $var = $table->integer($field->colname)->unsigned();
                        }
                        $var->default($field->defaultvalue);
                        break;
                    } else if (is_string($field->defaultvalue)) {
                        if ($update) {
                            $var = $table->string($field->colname)->change();
                        } else {
                            $var = $table->string($field->colname);
                        }
                        $var->default($field->defaultvalue);
                        break;
                    }
                }
                if (is_string($field->popup_vals) && starts_with($field->popup_vals, "@")) {
                    if ($update) {
                        $var = $table->integer($field->colname)->unsigned()->change();
                    } else {
                        $var = $table->integer($field->colname)->unsigned();
                    }
                    break;
                }
                $popup_vals = json_decode($field->popup_vals);
                if (is_array($popup_vals)) {
                    if ($update) {
                        $var = $table->string($field->colname)->change();
                    } else {
                        $var = $table->string($field->colname);
                    }
                    if ($field->defaultvalue != "") {
                        $var->default($field->defaultvalue);
                    } else if ($field->required) {
                        $var->default("");
                    }
                } else if (is_object($popup_vals)) {
                    // ############### Remaining
                    if ($update) {
                        $var = $table->integer($field->colname)->unsigned()->change();
                    } else {
                        $var = $table->integer($field->colname)->unsigned();
                    }
                    // if(is_int($field->defaultvalue)) {
                    //     $var->default($field->defaultvalue);
                    //     break;
                    // }
                }
                break;
            case 'String':
                $var = null;
                if ($field->maxlength == 0) {
                    if ($update) {
                        $var = $table->string($field->colname)->change();
                    } else {
                        $var = $table->string($field->colname);
                    }
                } else {
                    if ($update) {
                        $var = $table->string($field->colname, $field->maxlength)->change();
                    } else {
                        $var = $table->string($field->colname, $field->maxlength);
                    }
                }
                if ($field->defaultvalue != null) {
                    $var->default($field->defaultvalue);
                } else if ($field->required) {
                    $var->default("");
                }
                break;
            case 'Taginput':
                $var = null;
                if ($update) {
                    $var = $table->string($field->colname, 1000)->change();
                } else {
                    $var = $table->string($field->colname, 1000);
                }
                if (is_string($field->defaultvalue) && starts_with($field->defaultvalue, "[")) {
                    $field->defaultvalue = json_decode($field->defaultvalue);
                }

                if (is_string($field->defaultvalue)) {
                    $field->defaultvalue = json_encode([$field->defaultvalue]);
                    //echo "string: ".$field->defaultvalue;
                    $var->default($field->defaultvalue);
                } else if (is_array($field->defaultvalue)) {
                    $field->defaultvalue = json_encode($field->defaultvalue);
                    //echo "array: ".$field->defaultvalue;
                    $var->default($field->defaultvalue);
                } else if ($field->required) {
                    $var->default("");
                }
                break;
            case 'Textarea':
                $var = null;
                if ($field->maxlength == 0) {
                    if ($update) {
                        $var = $table->text($field->colname)->change();
                    } else {
                        $var = $table->text($field->colname);
                    }
                } else {
                    if ($update) {
                        $var = $table->string($field->colname, $field->maxlength)->change();
                    } else {
                        $var = $table->string($field->colname, $field->maxlength);
                    }
                    if ($field->defaultvalue != "") {
                        $var->default($field->defaultvalue);
                    } else if ($field->required) {
                        $var->default("");
                    }
                }
                break;
            case 'TextField':
                $var = null;
                if ($field->maxlength == 0) {
                    if ($update) {
                        $var = $table->string($field->colname)->change();
                    } else {
                        $var = $table->string($field->colname);
                    }
                } else {
                    if ($update) {
                        $var = $table->string($field->colname, $field->maxlength)->change();
                    } else {
                        $var = $table->string($field->colname, $field->maxlength);
                    }
                }
                if ($field->defaultvalue != "") {
                    $var->default($field->defaultvalue);
                } else if ($field->required) {
                    $var->default("");
                }
                break;
            case 'URL':
                $var = null;
                if ($field->maxlength == 0) {
                    if ($update) {
                        $var = $table->string($field->colname)->change();
                    } else {
                        $var = $table->string($field->colname);
                    }
                } else {
                    if ($update) {
                        $var = $table->string($field->colname, $field->maxlength)->change();
                    } else {
                        $var = $table->string($field->colname, $field->maxlength);
                    }
                }
                if ($field->defaultvalue != "") {
                    $var->default($field->defaultvalue);
                } else if ($field->required) {
                    $var->default("");
                }
                break;
        }

        // set column unique
        if ($update) {
            if ($isFieldTypeChange) {
                if ($field->unique && $var != null && $field->maxlength < 256) {
                    $table->unique($field->colname);
                }
            }
        } else {
            if ($field->unique && $var != null && $field->maxlength < 256) {
                $table->unique($field->colname);
            }
        }
    }

    public static function format_fields($fields)
    {
        $out = array();
        foreach ($fields as $field) {
            $obj             = (Object) array();
            $obj->colname    = $field[0];
            $obj->label      = $field[1];
            $obj->field_type = $field[2];

            if (!isset($field[3])) {
                $obj->unique = 0;
            } else {
                $obj->unique = $field[3];
            }
            if (!isset($field[4])) {
                $obj->defaultvalue = '';
            } else {
                $obj->defaultvalue = $field[4];
            }
            if (!isset($field[5])) {
                $obj->minlength = 0;
            } else {
                $obj->minlength = $field[5];
            }
            if (!isset($field[6])) {
                $obj->maxlength = 0;
            } else {
                // Because maxlength above 256 will not be supported by Unique
                if ($obj->unique) {
                    $obj->maxlength = 250;
                } else {
                    $obj->maxlength = $field[6];
                }
            }
            if (!isset($field[7])) {
                $obj->required = 0;
            } else {
                $obj->required = $field[7];
            }
            if (!isset($field[8])) {
                $obj->popup_vals = "";
            } else {
                if (is_array($field[8])) {
                    $obj->popup_vals = json_encode($field[8]);
                } else {
                    $obj->popup_vals = $field[8];
                }
            }
            $out[] = $obj;
        }
        return $out;
    }

    /**
     * Get Crud by crud name
     * $crud = Crud::get($crud_name);
     **/
    public static function get($crud_name)
    {
        $crud = null;
        if (is_int($crud_name)) {
            $crud = Crud::find($crud_name);
        } else {
            $crud = Crud::where('name', $crud_name)->first();
        }

        if (isset($crud)) {
            $crud    = $crud->toArray();
            $fields  = CrudFields::where('crud', $crud['id'])->orderBy('sort', 'asc')->get()->toArray();
            $fields2 = array();
            foreach ($fields as $field) {
                $fields2[$field['colname']] = $field;
            }
            $crud['fields'] = $fields2;
            return (object) $crud;
        } else {
            return null;
        }
    }

    /**
     * Get Crud by table name
     * $crud = Crud::getByTable($table_name);
     **/
    public static function getByTable($table_name)
    {
        $crud = Crud::where('name_db', $table_name)->first();
        if (isset($crud)) {
            $crud = $crud->toArray();
            return Crud::get($crud['name']);
        } else {
            return null;
        }
    }

    /**
     * Get Array for Dropdown, Multiselect, Taginput, Radio from Crud getByTable
     * $array = Crud::getDDArray($crud_name);
     **/
    public static function getDDArray($crud_name)
    {
        $crud = Crud::where('name', $crud_name)->first();
        if (isset($crud)) {
            $model_name = ucfirst(str_singular($crud_name));
            if ($model_name == "User" || $model_name == "Role" || $model_name == "Permission") {
                $model = "App\\Models\\" . ucfirst(str_singular($crud_name));
            } else {
                $model = "App\\Models\\" . ucfirst(str_singular($crud_name));
            }

            $result = $model::all();
            $out    = array();
            foreach ($result as $row) {
                $view_col      = $crud->view_col;
                $out[$row->id] = $row->{$view_col};
            }
            return $out;
        } else {
            return array();
        }
    }

    public static function validateRules($crud_name, $request, $isEdit = false)
    {
        $crud  = Crud::get($crud_name);
        $rules = [];
        if (isset($crud)) {
            $ftypes = CrudFieldTypes::getFTypes2();
            foreach ($crud->fields as $field) {
                if (isset($request->{$field['colname']})) {
                    $col = "";
                    if ($field['required']) {
                        $col .= "required|";
                    }
                    if (in_array($ftypes[$field['field_type']], array("Currency", "Decimal"))) {
                        // No min + max length
                    } else {
                        if ($field['minlength'] != 0) {
                            $col .= "min:" . $field['minlength'] . "|";
                        }
                        if ($field['maxlength'] != 0) {
                            $col .= "max:" . $field['maxlength'] . "|";
                        }
                    }
                    if ($field['unique'] && !$isEdit) {
                        $col .= "unique:" . $crud->name_db . ",deleted_at,NULL";
                    }
                    // 'name' => 'required|unique|min:5|max:256',
                    // 'author' => 'required|max:50',
                    // 'price' => 'decimal',
                    // 'pages' => 'integer|max:5',
                    // 'genre' => 'max:500',
                    // 'description' => 'max:1000'
                    if ($col != "") {
                        $rules[$field['colname']] = trim($col, "|");
                    }
                }
            }
            return $rules;
        } else {
            return $rules;
        }
    }

    public static function insert($crud_name, $request)
    {
        $crud   = Crud::get($crud_name);
        $module = Module::where('slug', $crud->module);

        if (isset($crud)) {
            $model_name = ucfirst(str_singular($crud_name));
            if ($model_name == "User" || $model_name == "Role" || $model_name == "Permission") {
                $model = "App\\Models\\" . ucfirst(str_singular($crud_name));
            } else {
                $model = "App\\Modules\\" . $module['name'] . "\\Models\\" . ucfirst(str_singular($crud_name));
            }

            // Delete if unique rows available which are deleted
            $old_row      = null;
            $uniqueFields = CrudFields::where('crud', $crud->id)->where('unique', '1')->get()->toArray();
            foreach ($uniqueFields as $field) {
                Log::debug("insert: " . $crud->name_db . " - " . $field['colname'] . " - " . $request->{$field['colname']});
                $old_row = DB::table($crud->name_db)->whereNotNull('deleted_at')->where($field['colname'], $request->{$field['colname']})->first();
                if (isset($old_row->id)) {
                    Log::debug("deleting: " . $crud->name_db . " - " . $field['colname'] . " - " . $request->{$field['colname']});
                    DB::table($crud->name_db)->whereNotNull('deleted_at')->where($field['colname'], $request->{$field['colname']})->delete();
                }
            }

            $row = new $model;
            if (isset($old_row->id)) {
                // To keep old & new row id remain same
                $row->id = $old_row->id;
            }
            $row = Crud::processDBRow($crud, $request, $row);
            $row->save();
            return $row->id;
        } else {
            return null;
        }
    }

    public static function updateRow($crud_name, $request, $id)
    {
        $crud = Crud::get($crud_name);
        if (isset($crud)) {
            $model_name = ucfirst(str_singular($crud_name));
            if ($model_name == "User" || $model_name == "Role" || $model_name == "Permission") {
                $model = "App\\Models\\" . ucfirst(str_singular($crud_name));
            } else {
                $model = "App\\Models\\" . ucfirst(str_singular($crud_name));
            }
            //$row = new $crud_path;
            $row = $model::find($id);
            $row = Crud::processDBRow($crud, $request, $row);
            $row->save();
            return $row->id;
        } else {
            return null;
        }
    }

    public static function processDBRow($crud, $request, $row)
    {
        $ftypes = CrudFieldTypes::getFTypes2();

        foreach ($crud->fields as $field) {
            if (isset($request->{$field['colname']}) || isset($request->{$field['colname'] . "_hidden"})) {

                switch ($ftypes[$field['field_type']]) {
                    case 'Checkbox':
                        #TODO: Bug fix
                        if (isset($request->{$field['colname']})) {
                            $row->{$field['colname']} = true;
                        } else if (isset($request->{$field['colname'] . "_hidden"})) {
                            $row->{$field['colname']} = false;
                        }
                        break;
                    case 'Date':
                        if ($request->{$field['colname']} != "") {
                            $date                         = $request->{$field['colname']};
                            $d2                           = date_parse_from_format("d/m/Y", $date);
                            $request->{$field['colname']} = date("Y-m-d", strtotime($d2['year'] . "-" . $d2['month'] . "-" . $d2['day']));
                        }
                        $row->{$field['colname']} = $request->{$field['colname']};
                        break;
                    case 'Datetime':
                        #TODO: Bug fix
                        if ($request->{$field['colname']} != "") {
                            $date                         = $request->{$field['colname']};
                            $d2                           = date_parse_from_format("d/m/Y h:i A", $date);
                            $request->{$field['colname']} = date("Y-m-d H:i:s", strtotime($d2['year'] . "-" . $d2['month'] . "-" . $d2['day'] . " " . substr($date, 11)));
                        }
                        $row->{$field['colname']} = $request->{$field['colname']};
                        break;
                    case 'Multiselect':
                        #TODO: Bug fix
                        $row->{$field['colname']} = json_encode($request->{$field['colname']});
                        break;
                    case 'Password':
                        $row->{$field['colname']} = bcrypt($request->{$field['colname']});
                        break;
                    case 'Taginput':
                        #TODO: Bug fix
                        $row->{$field['colname']} = json_encode($request->{$field['colname']});
                        break;
                    case 'Files':
                        $files  = json_decode($request->{$field['colname']});
                        $files2 = array();
                        foreach ($files as $file) {
                            $files2[] = "" . $file;
                        }
                        $row->{$field['colname']} = json_encode($files2);
                        break;
                    default:
                        $row->{$field['colname']} = $request->{$field['colname']};
                        break;
                }
            }
        }
        return $row;
    }

    public static function itemCount($crud_name)
    {
        $crud = Crud::get($crud_name);
        if (isset($crud)) {
            $model_name = ucfirst(str_singular($crud_name));
            if ($model_name == "User" || $model_name == "Role" || $model_name == "Permission") {
                if (file_exists(base_path('app/Models/' . $model_name . ".php"))) {
                    $model = "App\\Models\\" . $model_name;
                    return $model::count();
                } else {
                    return "Tidak ada model";
                }
            } else {
                if (file_exists(base_path('app/Models/' . $model_name . ".php"))) {
                    $model = "App\\Models\\" . $model_name;
                    return $model::count();
                } else {
                    return "Tidak ada model";
                }
            }

        } else {
            return 0;
        }
    }

    /**
     * Get Crud Access for all roles
     * $roles = Crud::getRoleAccess($id);
     **/
    public static function getRoleAccess($crud_id, $specific_role = 0)
    {
        $crud = Crud::find($crud_id);
        $crud = Crud::get($crud->name);

        if ($specific_role) {
            $roles_arr = DB::table('roles')->where('id', $specific_role)->get();
        } else {
            $roles_arr = DB::table('roles')->get();
        }
        $roles = array();

        $arr_field_access = array(
            'invisible' => 0,
            'readonly'  => 1,
            'write'     => 2,
        );

        foreach ($roles_arr as $role) {
            // get Current Crud permissions for this role

            $crud_perm = DB::table('role_crud')->where('role_id', $role->id)->where('crud_id', $crud->id)->first();
            if (isset($crud_perm->id)) {
                // set db values
                $role->view   = $crud_perm->acc_view;
                $role->create = $crud_perm->acc_create;
                $role->edit   = $crud_perm->acc_edit;
                $role->delete = $crud_perm->acc_delete;
            } else {
                $role->view   = false;
                $role->create = false;
                $role->edit   = false;
                $role->delete = false;
            }

            // get Current Crud Fields permissions for this role

            $role->fields = array();
            foreach ($crud->fields as $field) {
                // find role field permission
                $field_perm = DB::table('role_crud_fields')->where('role_id', $role->id)->where('field_id', $field['id'])->first();

                if (isset($field_perm->id)) {
                    $field['access'] = $arr_field_access[$field_perm->access];
                } else {
                    $field['access'] = 0;
                }
                $role->fields[$field['id']] = $field;
                //$role->fields[$field['id']] = $field_perm->access;
            }
            $roles[] = $role;
        }
        return $roles;
    }

    /**
     * Get Crud Access for role and access type
     * Crud::hasAccess($crud_id, $access_type, $user_id);
     **/
    public static function hasAccess($crud_id, $access_type = "view", $user_id = 0)
    {
        $roles = array();

        if (is_string($crud_id)) {
            $crud    = Crud::get($crud_id);
            $crud_id = $crud->id;
        }

        if ($access_type == null || $access_type == "") {
            $access_type = "view";
        }

        if ($user_id) {
            $user = \App\Models\User::find($user_id);
            if (isset($user->id)) {
                $roles = $user->roles();
            }
        } else {
            $roles = \Auth::user()->roles();
        }
        foreach ($roles->get() as $role) {
            $crud_perm = DB::table('role_crud')->where('role_id', $role->id)->where('crud_id', $crud_id)->first();
            if (isset($crud_perm->id)) {
                if (isset($crud_perm->{"acc_" . $access_type}) && $crud_perm->{"acc_" . $access_type} == 1) {
                    return true;
                } else {
                    continue;
                }
            } else {
                continue;
            }
        }
        return false;
    }

    /**
     * Get Crud Field Access for role and access type
     * Crud::hasFieldAccess($crud_id, $field_id, $access_type, $user_id);
     **/
    public static function hasFieldAccess($crud_id, $field_id, $access_type = "view", $user_id = 0)
    {
        $roles = array();

        // \Log::debug("crud_id: ".$crud_id." field_id: ".$field_id." access_type: ".$access_type);

        if (\Auth::guest()) {
            return false;
        }

        if (is_string($crud_id)) {
            $crud    = Crud::get($crud_id);
            $crud_id = $crud->id;
        }

        if (is_string($field_id)) {
            $field_object = CrudFields::where('crud', $crud_id)->where('colname', $field_id)->first();
            $field_id     = $field_object->id;
        }

        if ($access_type == null || $access_type == "") {
            $access_type = "view";
        }

        if ($user_id) {
            $user = \App\Models\User::find($user_id);
            if (isset($user->id)) {
                $roles = $user->roles();
            }
        } else {
            $roles = \Auth::user()->roles();
        }

        $hasCrudAccess = false;

        foreach ($roles->get() as $role) {
            $crud_perm = DB::table('role_crud')->where('role_id', $role->id)->where('crud_id', $crud_id)->first();
            if (isset($crud_perm->id)) {
                if ($access_type == "view" && isset($crud_perm->{"acc_" . $access_type}) && $crud_perm->{"acc_" . $access_type} == 1) {
                    $hasCrudAccess = true;
                    break;
                } else if ($access_type == "write" && ((isset($crud_perm->{"acc_create"}) && $crud_perm->{"acc_create"} == 1) || (isset($crud_perm->{"acc_edit"}) && $crud_perm->{"acc_edit"} == 1))) {
                    $hasCrudAccess = true;
                    break;
                } else {
                    continue;
                }
            } else {
                continue;
            }
        }
        if ($hasCrudAccess) {
            $crud_field_perm = DB::table('role_crud_fields')->where('role_id', $role->id)->where('field_id', $field_id)->first();
            if (isset($crud_field_perm->access)) {
                if ($access_type == "view" && ($crud_field_perm->{"access"} == "readonly" || $crud_field_perm->{"access"} == "write")) {
                    return true;
                } else if ($access_type == "write" && $crud_field_perm->{"access"} == "write") {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
        return false;
    }

    /**
     * Get Crud Access for all roles
     * Crud::setDefaultRoleAccess($crud_id, $role_id);
     **/
    public static function setDefaultRoleAccess($crud_id, $role_id, $access_type = "readonly")
    {
        $crud = Crud::find($crud_id);
        $crud = Crud::get($crud->name);

        Log::debug('Crud:setDefaultRoleAccess (' . $crud_id . ', ' . $role_id . ', ' . $access_type . ')');

        $role = DB::table('roles')->where('id', $role_id)->first();

        $access_view   = 0;
        $access_create = 0;
        $access_edit   = 0;
        $access_delete = 0;
        $access_fields = "invisible";

        if ($access_type == "full") {
            $access_view   = 1;
            $access_create = 1;
            $access_edit   = 1;
            $access_delete = 1;
            $access_fields = "write";

        } else if ($access_type == "readonly") {
            $access_view   = 1;
            $access_create = 0;
            $access_edit   = 0;
            $access_delete = 0;

            $access_fields = "readonly";
        }

        $now = date("Y-m-d H:i:s");

        // 1. Set Crud Access

        $crud_perm = DB::table('role_crud')->where('role_id', $role->id)->where('crud_id', $crud->id)->first();
        if (!isset($crud_perm->id)) {
            DB::insert('insert into role_crud (role_id, crud_id, acc_view, acc_create, acc_edit, acc_delete, created_at, updated_at) values (?, ?, ?, ?, ?, ?, ?, ?)', [$role->id, $crud->id, $access_view, $access_create, $access_edit, $access_delete, $now, $now]);
        } else {
            DB::table('role_crud')->where('role_id', $role->id)->where('crud_id', $crud->id)->update(['acc_view' => $access_view, 'acc_create' => $access_create, 'acc_edit' => $access_edit, 'acc_delete' => $access_delete]);
        }

        // 2. Set Crud Fields Access

        foreach ($crud->fields as $field) {
            // find role field permission
            $field_perm = DB::table('role_crud_fields')->where('role_id', $role->id)->where('field_id', $field['id'])->first();
            if (!isset($field_perm->id)) {
                DB::insert('insert into role_crud_fields (role_id, field_id, access, created_at, updated_at) values (?, ?, ?, ?, ?)', [$role->id, $field['id'], $access_fields, $now, $now]);
            } else {
                DB::table('role_crud_fields')->where('role_id', $role->id)->where('field_id', $field['id'])->update(['access' => $access_fields]);
            }
        }
    }

    /**
     * Get Crud Access for all roles
     * Crud::setDefaultFieldRoleAccess($field_id, $role_id);
     **/
    public static function setDefaultFieldRoleAccess($field_id, $role_id, $access_type = "readonly")
    {
        $field = CrudFields::find($field_id);
        $crud  = Crud::get($field->crud);

        $role = DB::table('roles')->where('id', $role_id)->first();

        $access_fields = "invisible";

        if ($access_type == "full") {
            $access_fields = "write";

        } else if ($access_type == "readonly") {
            $access_fields = "readonly";
        }

        $now = date("Y-m-d H:i:s");

        // find role field permission
        $field_perm = DB::table('role_crud_fields')->where('role_id', $role->id)->where('field_id', $field->id)->first();
        if (!isset($field_perm->id)) {
            DB::insert('insert into role_crud_fields (role_id, field_id, access, created_at, updated_at) values (?, ?, ?, ?, ?)', [$role->id, $field->id, $access_fields, $now, $now]);
        } else {
            DB::table('role_crud_fields')->where('role_id', $role->id)->where('field_id', $field->id)->update(['access' => $access_fields]);
        }
    }
}
