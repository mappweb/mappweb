<?php
/**
 * Created by PhpStorm.
 * User: Diego
 * Date: 4/04/2019
 * Time: 9:38 AM
 */

namespace mappweb\mappweb\Helpers;

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
            $data['toast']['tipo'] = 'success';
            $data['toast']['titulo'] = __('MappWeb::toast.title.success');
            $data['toast']['mensaje'] = __('MappWeb::toast.body.success');

            if ($destroy){
                $data['toast']['mensaje'] = __('MappWeb::toast.body_delete.error');
            }
        } else {
            $data['toast']['tipo'] = 'error';
            $data['toast']['titulo'] = __('MappWeb::toast.title.error');
            $data['toast']['mensaje'] = __('MappWeb::toast.body.error');

            if ($destroy){
                $data['toast']['mensaje'] = __('MappWeb::toast.body_delete.error');
            }
        }
    }
}