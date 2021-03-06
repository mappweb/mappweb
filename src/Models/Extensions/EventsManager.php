<?php
/**
 * User: Ing. Oswaldo Montes Severiche
 * Date: 2019-08-10
 * Time: 17:18
 */

namespace Mappweb\Mappweb\Models\Extensions;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait EventsManager
{
    /**
     *
     */
    public static function bootEventsManager()
    {
        static::creating(function ($model){
            if ($model->allowUuid){
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }

            self::addCreatedBy($model);
        });

        static::saving(function ($model){
            self::addUpdatedBy($model);
        });

        static::updating(function ($model){
           self::addUpdatedBy($model);
        });

        static::deleting(function ($model){
            self::addUpdatedBy($model);
        });
    }

    /**
     * @param $model
     */
    protected static function addUpdatedBy(&$model)
    {
        if ($model->addUpdatedBy){
            $model->updated_by = Auth::id()?? 0;
        }
    }

    /**
     * @param $model
     */
    protected static function addCreatedBy(&$model)
    {
        if ($model->addCreatedBy){
            $model->created_by = Auth::id()?? 0;
        }
    }
}