<?php
/**
 * Created by PhpStorm.
 * User: Diego
 * Date: 29/04/2019
 * Time: 9:29 AM
 */

namespace mappweb\mappweb\Helpers;
use File;


class Directory
{
    public static function existOrCreate($path){
        if(!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
    }
}