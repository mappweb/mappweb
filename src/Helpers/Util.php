<?php
/**
 * Created by PhpStorm.
 * User: Diego
 * Date: 4/04/2019
 * Time: 9:38 AM
 */

namespace mappweb\mappweb\Helpers;

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
        if(is_array($id))
            return $class::updateOrCreate($id, $request->all());
        else
            return $class::updateOrCreate(['id' => $id], $request->all());
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
            $data['toast']['titulo'] = __('toast.titulo.si');
            $data['toast']['mensaje'] = __('toast.mensaje.si');

            if ($destroy){
                $data['toast']['mensaje'] = __('toast.mensaje.eliminado.si');
            }
        } else {
            $data['toast']['tipo'] = 'error';
            $data['toast']['titulo'] = __('toast.titulo.no');
            $data['toast']['mensaje'] = __('toast.mensaje.no');

            if ($destroy){
                $data['toast']['mensaje'] = __('toast.mensaje.eliminado.no');
            }
        }
    }
}