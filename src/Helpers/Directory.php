<?php
/**
 * Created by PhpStorm.
 * User: Diego
 * Date: 29/04/2019
 * Time: 9:29 AM
 */

namespace Mappweb\Mappweb\Helpers;
use File;


class Directory
{
    /**
     * Create directories if not exist
     *
     * @param $path
     */
    public static function existOrCreate($path){
        if(!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
    }
}