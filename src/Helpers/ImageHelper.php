<?php
/**
 * Created by PhpStorm.
 * User: Diego
 * Date: 6/11/2019
 * Time: 9:12 AM
 */

namespace Mappweb\Mappweb\Helpers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use \Intervention\Image\Facades\Image;

class ImageHelper
{
    /**
     * Update or Create a Image
     *
     * @param $request
     * @param $input_name
     * @param $field_name
     * @param $class
     * @param null $id
     */
    public static function updateOrCreate(Request &$request, $input_name, $field_name, $class, $id = null)
    {

        if ($request->hasFile("{$input_name}")) {

            $name = uniqid();
            $file = $request->file("{$input_name}");
            $binary = Image::make($file->getPathname())->resize(300, 200)->encode();
            if (!is_array($file) && is_null($id)) {
                $request->merge(["{$field_name}" => static::handleImage($name, $file, $binary)]);
            }

            if (!is_array($file) && !is_null($id)) {
                $object = $class::find($id);
                if (!Str::contains($object->{"$field_name"}, $file->getClientOriginalName())) {
                    File::delete($object->{"$field_name"});
                    $url = str_replace('storage', '', substr($object->{"$field_name"}, 1, (strripos($object->{"$field_name"}, '/') + 1)));
                    $request->merge(["{$field_name}" => static::handleImage($name, $file, $binary, $url)]);
                }
            }

        }

    }


    /**
     * Update or Create a Image
     *
     * @param $request
     * @param $input_name
     * @param $data
     * @param $field_name
     * @param $class
     */
    public static function createMultiple(&$request, $input_name, $field_name, $class = \stdClass::class, $data = [])
    {
        if ($request->hasFile("{$input_name}")) {
            $name = uniqid();
            $files = $request->file("{$input_name}");
            if (is_array($files)) {
                foreach ($files as $file) {
                    $binary = Image::make($file->getPathname())->resize(300, 200)->encode();
                    $data["{$field_name}"] = static::handleImage($name, $file, $binary);
                    Util::updateOrCreate($class, $data);
                }
            }
        }
    }

    /**
     * @param $name
     * @param $file
     * @param $binary
     * @param $url
     * @return string
     */
    private static function handleImage($name, $file, $binary, $url = '')
    {
        $file_name = $file->getClientOriginalName();
        $directory = new Directory($name, $file_name);
        if (($url != '')) {
            $directory = $url;
        }
        Storage::disk('public')->put($directory->getFilePath(), (string)$binary, 'public');
        return 'storage/' . $directory->getFilePath();
    }


    /**
     * @param $url
     * @return string|null
     */
    public static function hasDefaultFile($url)
    {
        return (!is_null($url)) ? asset($url) : null;
    }

}