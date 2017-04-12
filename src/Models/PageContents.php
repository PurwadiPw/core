<?php

namespace Pw\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pw\Core\Helpers\CoreHelper;
use Pw\Core\Translatable;

class PageContents extends Model
{

	use SoftDeletes;
	use Translatable;

    protected $table = 'core_pages_contents';
    
    protected $guarded = [
        
    ];

    protected $dates = ['deleted_at'];

    public $translatedAttributes = [
        'title', 
        'content', 
    ];

    public function trans()
    {
        return $this->hasMany('Pw\Core\Models\PageContentsTranslation');
    }
}
