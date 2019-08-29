<?php
/**
 * Created by PhpStorm.
 * User: Diego
 * Date: 4/04/2019
 * Time: 9:38 AM
 */

namespace Mappweb\Mappweb\Helpers;

use Illuminate\Http\Request;

class Util
{
    /**
     * Update or Create a Model
     * @param $class
     * @param $request
     * @param null $id
     * @return mixed
     */
    public static function updateOrCreate($class, $request, $id = null){
        return $class::updateOrCreate((is_array($id))?$id:['id' => $id], ($request instanceof Request)?$request->all():$request);
    }

    /**
     * Add toast message to array data
     *
     * @param array $data
     * @param bool  $destroy
     */
    public static function addToastToData(array &$data, $destroy = false)
    {
        if ($data['success']) {
            $data['toast']['type'] = 'success';
            $data['toast']['title'] = __('MappWeb::toast.title.success');
            $data['toast']['message'] = __('MappWeb::toast.body.success');

            if ($destroy){
                $data['toast']['message'] = __('MappWeb::toast.body_delete.error');
            }
        } else {
            $data['toast']['type'] = 'error';
            $data['toast']['title'] = __('MappWeb::toast.title.error');
            $data['toast']['message'] = __('MappWeb::toast.body.error');

            if ($destroy){
                $data['toast']['message'] = __('MappWeb::toast.body_delete.error');
            }
        }
    }
}