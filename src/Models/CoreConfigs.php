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
		$row_lang = 'value_'.app()->getLocale();
		if(isset($row->{$row_lang})) {
			return $row->{$row_lang};
		} else {
			return false;
		}
	}
	
	// CoreConfigs::getAll();
	public static function getAll() {
		$configs = array();
		$configs_db = CoreConfigs::all();
		foreach ($configs_db as $row) {
			foreach (CoreHelper::availableLang() as $locale => $lang) {
				$row_lang = 'value_'.$locale;
				$configs[$locale][$row->key] = $row->{$row_lang};
			}
		}
		return (object) $configs;
	}
}
