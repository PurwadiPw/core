<?php

namespace Pw\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Pw\Core\Helpers\CoreHelper;

class Menu extends Model
{
    protected $table = 'core_menus';
    
    protected $guarded = [
        
    ];
}
