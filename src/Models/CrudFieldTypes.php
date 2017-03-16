<?php

namespace Pw\Core\Models;

use Illuminate\Database\Eloquent\Model;

class CrudFieldTypes extends Model
{
    protected $table = 'crud_field_types';
    
    protected $fillable = [
        "name"
    ];
    
    protected $hidden = [
        
    ];
    
    // CrudFieldTypes::getFTypes()
    public static function getFTypes() {
        $fields = CrudFieldTypes::all();
        $fields2 = array();
        foreach ($fields as $field) {
            $fields2[$field['name']] = $field['id'];
        }
        return $fields2;
    }
    
    // CrudFieldTypes::getFTypes2()
    public static function getFTypes2() {
        $fields = CrudFieldTypes::all();
        $fields2 = array();
        foreach ($fields as $field) {
            $fields2[$field['id']] = $field['name'];
        }
        return $fields2;
    }
}
