<?php

namespace Pw\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Exception;
use Log;
use DB;
use Pw\Core\Helpers\CoreHelper;

class CoreConfigs extends Model
{   
	protected $table = 'core_configs';
	
	protected $fillable = [
		"key", "value"
	];
	
	protected $hidden = [
		
	];

	// CoreConfigs::getByKey('sitename');
	public static function getByKey($key) {
		$row = CoreConfigs::where('key',$key)->first();
		if(isset($row->value)) {
			return $row->value;
		} else {
			return false;
		}
	}
	
	// CoreConfigs::getAll();
	public static function getAll() {
		$configs = array();
		$configs_db = CoreConfigs::all();
		foreach ($configs_db as $row) {
			$configs[$row->key] = $row->value;
		}
		return (object) $configs;
	}
}
