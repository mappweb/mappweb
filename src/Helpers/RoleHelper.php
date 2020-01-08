<?php


namespace Mappweb\Mappweb\Helpers;


use Illuminate\Support\Facades\Auth;

class RoleHelper
{
    /**
     * @param $permission
     */
    public static function validate($permission){
        if(!Auth::user()->hasPermission("$permission")){
            abort(403, __('Unauthorized.'));
        }
    }
}