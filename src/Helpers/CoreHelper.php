<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 12/03/17
 * Time: 8:48
 */

namespace Pw\Core\Helpers;

use DB;
use Log;

use Pw\Core\Models\Crud;
use Collective\Html\HtmlBuilder;

class CoreHelper
{
    // $names = CoreHelper::generateCrudNames($crud_name);
    public static function generateCrudNames($module, $crud_name, $table, $icon) {
        $array = array();
        $crud_name = trim($crud_name);
        $crud_name = str_replace(" ", "_", $crud_name);

        $array['module'] = $module;
        $array['crud'] = studly_case($crud_name);
        $array['label'] = studly_case($crud_name);
        $array['table'] = $table; //strtolower($crud_name, 1);
        $array['model'] = studly_case($crud_name);
        $array['fa_icon'] = $icon;
        $array['controller'] = $array['crud']."Controller";
        $array['singular_l'] = strtolower(str_singular($crud_name));
        $array['singular_c'] = ucfirst(str_singular($crud_name));

        return (object) $array;
    }

    // $tables = CoreHelper::getDBTables([]);
    public static function getDBTables($remove_tables = []) {
        if(env('DB_CONNECTION') == "sqlite") {
            $tables_sqlite = DB::select('select * from sqlite_master where type="table"');
            $tables = array();
            foreach ($tables_sqlite as $table) {
                if($table->tbl_name != 'sqlite_sequence') {
                    $tables[] = $table->tbl_name;
                }
            }
        } else if(env('DB_CONNECTION') == "pgsql") {
            $tables_pgsql = DB::select("SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE' AND table_schema = 'public' ORDER BY table_name;");
            $tables = array();
            foreach ($tables_pgsql as $table) {
                $tables[] = $table->table_name;
            }
        } else if(env('DB_CONNECTION') == "mysql") {
            $tables = DB::select('SHOW TABLES');
        } else {
            $tables = DB::select('SHOW TABLES');
        }

        $tables_out = array();
        foreach ($tables as $table) {
            $table = (Array)$table;
            $tables_out[] = array_values($table)[0];
        }
        $remove_tables2 = array(
            'backups',
            'core_configs',
            'core_menus',
            'migrations',
            'cruds',
            'crud_fields',
            'crud_field_types',
            'password_resets',
            'permissions',
            'permission_role',
            'role_crud',
            'role_crud_fields',
            'role_user'
        );
        $remove_tables = array_merge($remove_tables, $remove_tables2);
        $remove_tables = array_unique($remove_tables);
        $tables_out = array_diff($tables_out, $remove_tables);

        $tables_out2 = array();
        foreach ($tables_out as $table) {
            $tables_out2[$table] = $table;
        }

        return $tables_out2;
    }

    // $cruds = CoreHelper::getCrudNames([]);
    public static function getCrudNames($remove_cruds = []) {
        $cruds = Crud::all();

        $cruds_out = array();
        foreach ($cruds as $crud) {
            $cruds_out[] = $crud->name;
        }
        $cruds_out = array_diff($cruds_out, $remove_cruds);

        $cruds_out2 = array();
        foreach ($cruds_out as $crud) {
            $cruds_out2[$crud] = $crud;
        }

        return $cruds_out2;
    }

    // CoreHelper::parseValues($field['popup_vals']);
    public static function parseValues($value) {
        // return $value;
        $valueOut = "";
        if (strpos($value, '[') !== false) {
            $arr = json_decode($value);
            foreach ($arr as $key) {
                $valueOut .= "<div class='label label-primary'>".$key."</div> ";
            }
        } else if (strpos($value, ',') !== false) {
            $arr = array_map('trim', explode(",", $value));
            foreach ($arr as $key) {
                $valueOut .= "<div class='label label-primary'>".$key."</div> ";
            }
        } else if (strpos($value, '@') !== false) {
            $valueOut .= "<b data-toggle='tooltip' data-placement='top' title='From ".str_replace("@", "", $value)." table' class='text-primary'>".$value."</b>";
        } else if ($value == "") {
            $valueOut .= "";
        } else {
            $valueOut = "<div class='label label-primary'>".$value."</div> ";
        }
        return $valueOut;
    }

    // CoreHelper::log("info", "", $commandObject);
    public static function log($type, $text, $commandObject) {
        if($commandObject) {
            $commandObject->$type($text);
        } else {
            if($type == "line") {
                $type = "info";
            }
            Log::$type($text);
        }
    }

    // CoreHelper::recurse_copy("", "");
    public static function recurse_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst, 0777, true);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    CoreHelper::recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    // ignore files
                    if(!in_array($file, [".DS_Store"])) {
                        copy($src . '/' . $file, $dst . '/' . $file);
                    }
                }
            }
        }
        closedir($dir);
    }

    // CoreHelper::recurse_delete("");
    public static function recurse_delete($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir."/".$object))
                        CoreHelper::recurse_delete($dir."/".$object);
                    else
                        unlink($dir."/".$object);
                }
            }
            rmdir($dir);
        }
    }

    // Generate Random Password
    // $password = CoreHelper::gen_password();
    public static function gen_password($chars_min=6, $chars_max=8, $use_upper_case=false, $include_numbers=false, $include_special_chars=false) {
        $length = rand($chars_min, $chars_max);
        $selection = 'aeuoyibcdfghjklmnpqrstvwxz';
        if($include_numbers) {
            $selection .= "1234567890";
        }
        if($include_special_chars) {
            $selection .= "!@\"#$%&[]{}?|";
        }
        $password = "";
        for($i=0; $i<$length; $i++) {
            $current_letter = $use_upper_case ? (rand(0,1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];
            $password .=  $current_letter;
        }
        return $password;
    }

    // CoreHelper::img($upload_name);
    public static function img($upload_name) {
        $upload = \App\Modules\Content\Models\Upload::where('name', $upload_name)->first();
        if(isset($upload->id)) {
            return url("files/".$upload->hash.DIRECTORY_SEPARATOR.$upload->name);
        } else {
            return "";
        }
    }

    // CoreHelper::imgSrc($upload_name);
    public static function imgSrc($upload_name, $class = false) {
        $upload = \App\Modules\Content\Models\Upload::where('name', $upload_name)->first();
        if(isset($upload->id)) {
            $file = url("files/".$upload->hash.DIRECTORY_SEPARATOR.$upload->name);
            return '<img src="'.$file.'" alt="'.$upload->caption.'" class="'.$class.'">';
        } else {
            return "";
        }
    }

    // CoreHelper::createThumbnail($filepath, $thumbpath, $thumbnail_width, $thumbnail_height);
    public static function createThumbnail($filepath, $thumbpath, $thumbnail_width, $thumbnail_height, $background=false) {
        list($original_width, $original_height, $original_type) = getimagesize($filepath);
        if ($original_width > $original_height) {
            $new_width = $thumbnail_width;
            $new_height = intval($original_height * $new_width / $original_width);
        } else {
            $new_height = $thumbnail_height;
            $new_width = intval($original_width * $new_height / $original_height);
        }
        $dest_x = intval(($thumbnail_width - $new_width) / 2);
        $dest_y = intval(($thumbnail_height - $new_height) / 2);
        if ($original_type === 1) {
            $imgt = "ImageGIF";
            $imgcreatefrom = "ImageCreateFromGIF";
        } else if ($original_type === 2) {
            $imgt = "ImageJPEG";
            $imgcreatefrom = "ImageCreateFromJPEG";
        } else if ($original_type === 3) {
            $imgt = "ImagePNG";
            $imgcreatefrom = "ImageCreateFromPNG";
        } else {
            return false;
        }
        $old_image = $imgcreatefrom($filepath);
        $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height); // creates new image, but with a black background
        // figuring out the color for the background
        if(is_array($background) && count($background) === 3) {
            list($red, $green, $blue) = $background;
            $color = imagecolorallocate($new_image, $red, $green, $blue);
            imagefill($new_image, 0, 0, $color);
            // apply transparent background only if is a png image
        } else if($background === 'transparent' && $original_type === 3) {
            imagesavealpha($new_image, TRUE);
            $color = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
            imagefill($new_image, 0, 0, $color);
        }
        imagecopyresampled($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
        $imgt($new_image, $thumbpath);
        return file_exists($thumbpath);
    }

    // CoreHelper::print_menu_editor($menu)
    public static function print_menu_editor($menu) {
        $editing = \Collective\Html\FormFacade::open(['route' => [config('core.adminRoute').'.menus.destroy', $menu->id], 'method' => 'delete', 'style'=>'display:inline']);
        $editing .= '<button class="btn btn-xs btn-danger pull-right"><i class="fa fa-times"></i></button>';
        $editing .= \Collective\Html\FormFacade::close();
        if($menu->type != "crud") {
            $info = (object) array();
            $info->id = $menu->id;
            $info->name = $menu->name;
            $info->url = $menu->url;
            $info->type = $menu->type;
            $info->icon = $menu->icon;

            $editing .= '<a class="editMenuBtn btn btn-xs btn-success pull-right" info=\''.json_encode($info).'\'><i class="fa fa-edit"></i></a>';
        }
        $str = '<li class="dd-item dd3-item" data-id="'.$menu->id.'">
			<div class="dd-handle dd3-handle"></div>
			<div class="dd3-content"><i class="fa '.$menu->icon.'"></i> '.$menu->name.' '.$editing.'</div>';

        $childrens = \Pw\Core\Models\Menu::where("parent", $menu->id)->orderBy('hierarchy', 'asc')->get();

        if(count($childrens) > 0) {
            $str .= '<ol class="dd-list">';
            foreach($childrens as $children) {
                $str .= CoreHelper::print_menu_editor($children);
            }
            $str .= '</ol>';
        }
        $str .= '</li>';
        return $str;
    }

    // CoreHelper::print_menu($menu)
    public static function print_menu($menu, $active = false) {
        $childrens = \Pw\Core\Models\Menu::where("parent", $menu->id)->where("is_backend", 1)->where("active", 1)->orderBy('hierarchy', 'asc')->get();

        $treeview = "";
        $subviewSign = "";
        if(count($childrens)) {
            $treeview = " class=\"treeview\"";
            $subviewSign = '';
        }
        $active_str = '';
        if($active) {
            $active_str = 'class="active"';
        }

        if ($menu->url == '#') {
            $url = 'javascript:void(0);';
        }else{
            $crud_name = studly_case($menu->url);
            $crud_module = \Pw\Core\Models\Crud::where('name', $crud_name)->first();
            $url = url($crud_module->module . '/' . $menu->url );
        }
        $str = '<li'.$treeview.' '.$active_str.'><a href="'.$url.'"><i class="fa fa-lg fa-fw '.$menu->icon.'"></i> <span>'.CoreHelper::real_crud_name($menu->name).'</span> '.$subviewSign.'</a>';

        if(count($childrens)) {
            $str .= '<ul class="treeview-menu">';
            foreach($childrens as $children) {
                $str .= CoreHelper::print_menu($children);
            }
            $str .= '</ul>';
        }
        $str .= '</li>';
        return $str;
    }

    // CoreHelper::print_menu_topnav($menu)
    public static function print_menu_topnav($menu, $active = false) {
        $childrens = \Pw\Core\Models\Menu::where("parent", $menu->id)->orderBy('hierarchy', 'asc')->get();

        $treeview = "";
        $treeview2 = "";
        $subviewSign = "";
        if(count($childrens)) {
            $treeview = " class=\"dropdown\"";
            $treeview2 = " class=\"dropdown-toggle\" data-toggle=\"dropdown\"";
            $subviewSign = ' <span class="caret"></span>';
        }
        $active_str = '';
        if($active) {
            $active_str = 'class="active"';
        }

        $str = '<li '.$treeview.''.$active_str.'><a '.$treeview2.' href="'.url(config("core.adminRoute") . '/' . $menu->url ) .'">'.CoreHelper::real_crud_name($menu->name).$subviewSign.'</a>';

        if(count($childrens)) {
            $str .= '<ul class="dropdown-menu" role="menu">';
            foreach($childrens as $children) {
                $str .= CoreHelper::print_menu_topnav($children);
            }
            $str .= '</ul>';
        }
        $str .= '</li>';
        return $str;
    }

    // CoreHelper::laravel_ver()
    public static function laravel_ver() {
        $var = \App::VERSION();

        if(starts_with($var, "5.2")) {
            return 5.2;
        } else if(starts_with($var, "5.3")) {
            return 5.3;
        } else if(substr_count($var, ".") == 3) {
            $var = substr($var, 0, strrpos($var, "."));
            return $var."-str";
        } else {
            return floatval($var);
        }
    }

    public static function real_crud_name($name){
        $name = str_replace('_', ' ', $name);
        return $name;
    }

    // CoreHelper::getLineWithString()
    public static function getLineWithString($fileName, $str) {
        $lines = file($fileName);
        foreach ($lines as $lineNumber => $line) {
            if (strpos($line, $str) !== false) {
                return $line;
            }
        }
        return -1;
    }

    // CoreHelper::getLineWithString2()
    public static function getLineWithString2($content, $str) {
        $lines = explode(PHP_EOL, $content);
        foreach ($lines as $lineNumber => $line) {
            if (strpos($line, $str) !== false) {
                return $line;
            }
        }
        return -1;
    }

    // CoreHelper::setenv("CACHE_DRIVER", "array");
    public static function setenv($param, $value) {

        $envfile = CoreHelper::openFile('.env');
        $line = CoreHelper::getLineWithString('.env', $param.'=');
        $envfile = str_replace($line, $param . "=" . $value."\n", $envfile);
        file_put_contents('.env', $envfile);

        $_ENV[$param] = $value;
        putenv($param . "=" . $value);
    }

    public static function openFile($from) {
        $md = file_get_contents($from);
        return $md;
    }

    // CoreHelper::availableLang()
    public static function availableLang()
    {
        $langs = config('core.locales');
        return $langs;
    }

    // CoreHelper::stringBetween()
    public static function stringBetween($string, $start, $end){
        $re = '/\<?= (.*?)\?>/';
        preg_match_all($re, $string, $matches, PREG_SET_ORDER, 0);
        $arr = [];
        for ($i=0; $i < count($matches); $i++) { 
            if (substr($matches[$i][1], 0, 1) == '$') {
                $arr[] = $matches[$i][1];
            }
        }
        return $arr;
    }

    // CoreHelper::uniqueArr()
    public static function uniqueArr($array) {
        foreach($array as $key => $value) {
            foreach($array as $key2 => $value2) {
                if($key != $key2 && $value === $value2) {
                    unset($array[$key]);
                }
            }
        }
        return $array;
    }

    // CoreHelper::fileName('PREFIX', 'EXTENSION')
    public static function fileName($prefix, $ext) { 
        $s = strtoupper(md5(uniqid(rand(),true))); 
        $guidText = 
            substr($s,0,8) . '-' . 
            substr($s,8,4) . '-' . 
            substr($s,12,4). '-' . 
            substr($s,16,4). '-' . 
            substr($s,20); 
        return $prefix.'-'.$guidText.'.'.$ext;
    }
}
