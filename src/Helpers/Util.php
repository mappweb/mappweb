<?php
/**
 * Created by PhpStorm.
 * User: Diego
 * Date: 4/04/2019
 * Time: 9:38 AM
 */

namespace Mappweb\Mappweb\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
     * Update or Create a File
     * @param $object
     * @param $field
     * @param $input
     * @param Request $request
     */
    public static function updateOrCreateFile($object, $field, $input, &$request){

        if ($request->hasFile("{$input}")) {
            $file = $request->file("{$input}");
            if (is_null($object->{"$field"} ?? null)) {
                $name = (Str::length($object->id) > 4) ? $object->id : uniqid();
                $directory = new Directory($name, $file);
                $file->storeAs($directory->getPath(), $file->getClientOriginalName(), 'public');
                $request->merge([
                    "{$field}" => 'storage/' . $directory->getFilePath()
                ]);
            } else {
                if (!Str::contains($object->{"$field"} ?? '', $file->getClientOriginalName())) {
                    File::delete($object->{"$field"});
                    $url = str_replace('storage', '', substr($object->{"$field"}, 0, (strripos($object->{"$field"}, '/') + 1)));
                    $file->storeAs($url, $file->getClientOriginalName(), 'public');
                    $request->merge([
                        "{$field}" => 'storage' . $url . $file->getClientOriginalName()
                    ]);
                }
            }
        }
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
                $data['toast']['message'] = __('MappWeb::toast.body_delete.success');
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