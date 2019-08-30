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

    protected $path;
    protected $file;
    /**
     * Directory constructor.
     * @param $uuid
     * @param null $file
     * @param string $type
     */
    public function __construct($uuid, $file = null, $type = 'files')
    {
        $this->path = $type . '/' . substr($uuid, 0, 2) . '/' . substr($uuid, 2, 2) . '/' . substr($uuid, 4) . '/';
        $this->file = $file;
    }
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

    /**
     * @return string
     */
    public function getPath()
    {
        return "{$this->path}";
    }

    /**
     * @return string
     */
    public function getFilePath()
    {
        return "{$this->getPath()}".$this->file->getClientOriginalName();
    }
}