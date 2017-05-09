<?php

namespace Pw\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pw\Core\Helpers\CoreHelper;
use Pw\Core\Translatable;

class Menu extends Model
{

	use SoftDeletes;
	use Translatable;

    protected $table = 'core_menus';
    
    protected $guarded = [
        
    ];

    protected $dates = ['deleted_at'];

    public $translatedAttributes = ['name', 'url'];

    public function trans()
    {
        return $this->hasMany('Pw\Core\Models\MenuTranslation');
    }

    public function buildMenu($type, $menu, $parentid = 0)
    {
        $result = null;
        foreach ($menu as $item) {
            if ($item->parent == $parentid) {
            	$delete = '';
            	if ($item->is_backend == 1) {
            		$delete = 'style="display: none;"';
            	}
                $result .= '<li class="dd-item" data-id="'.$item->id.'">
                                <div class="dd-handle dd3-handle">
                                    Drag
                                </div>
                                <div class="dd3-content">
                                    '.$item->name.'
                                    <span class="pull-right">
                                        <form novalidate="novalidate" method="POST" action="'.route('developer.menus.destroy', $item->id).'">
                                            <input type="hidden" value="DELETE" name="_method">
                                            '.csrf_field().'
                                            <button '.$delete.' type="submit" data-original-title="Hapus" data-placement="left" title="" rel="tooltip" class="btn btn-xs btn-danger">
                                            	<i class="fa fa-trash txt-color-white"></i>
                                            </button>
                                            <a href="'.url("developer/menus?type=".$item->type."&id=".$item->id).'" data-original-title="Edit" data-placement="left" title="" rel="tooltip" class="btn btn-xs btn-warning">
                                                <i class="fa fa-pencil txt-color-white"></i>
                                            </a>
                                        </form>
                                    </span>
                                </div>
                                '.$this->buildMenu($type, $menu, $item->id).'
                            </li>';
            }
        }
        return $result ? "\n<ol class=\"dd-list\">\n$result</ol>\n" : null;
    }

    public function getHTML($type, $items)
    {
        return $this->buildMenu($type, $items);
    }
}
