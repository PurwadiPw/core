<?php

namespace Pw\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pw\Core\Helpers\CoreHelper;
use Pw\Core\Translatable;

class Page extends Model
{

	use SoftDeletes;
	use Translatable;

    protected $table = 'core_pages';
    
    protected $guarded = [
        
    ];

    protected $dates = ['deleted_at'];

    public $translatedAttributes = [
        'title', 
        'slug', 
        'body', 
        'meta_title', 
        'meta_description',
        'og_title', 
        'og_description'
    ];

    public function trans()
    {
        return $this->hasMany('Pw\Core\Models\PageTranslation');
    }
}
