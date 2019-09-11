<?php
/**
 * Created by PhpStorm.
 * User: Diego
 * Date: 29/04/2019
 * Time: 9:29 AM
 */

namespace Mappweb\Mappweb\Helpers;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


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
     * Get current directory
     *
     * @return string
     */
    public function getPath()
    {
        return "{$this->path}";
    }

    /**
     * Get current file path
     *
     * @return string
     */
    public function getFilePath()
    {
        if ($this->file instanceof UploadedFile){
            return "{$this->getPath()}{$this->file->getClientOriginalName()}";
        }

        return "{$this->getPath()}{$this->file}";
    }

    /**
     * Check if file exist on disk
     *
     * @param string $disk
     * @return bool
     */
    public function check($disk = 'public')
    {
        if (Storage::disk($disk)->exists($this->getFilePath())){
            return true;
        }

        return false;
    }

    /**
     * Move current file to other path
     *
     * @param string $toPath
     * @param string $disk
     * @return bool
     */
    public function move($toPath, $disk = 'public')
    {
        if ($this->check()){
            return Storage::disk($disk)->move($this->getFilePath(), $toPath);
        }

        return false;
    }
}