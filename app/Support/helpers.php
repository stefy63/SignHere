<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 22/03/17
 * Time: 23.05
 */

namespace App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class Helpers {

    public static function getMenu(){
        if(Auth::check()){
            $menus = \Auth::user()
                ->modules()
                ->where('active',true)
                ->orderBy('name')
                ->get(array('short_name','functions'));

            return $menus;
        }
        return false;
    }

    public static function getSubMenu($menu){
        $file = resource_path() . DIRECTORY_SEPARATOR . "views". DIRECTORY_SEPARATOR . $menu. DIRECTORY_SEPARATOR . $menu.".json";
        if(File::exists($file))
        {
            $json=File::get($file);
            return json_decode($json, true);
        }
        return false;
    }
}





