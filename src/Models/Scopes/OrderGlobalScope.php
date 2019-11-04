<?php
/**
 * User: Ing. Oswaldo Montes Severiche
 * Date: 4/11/19
 * Time: 11:59 a. m.
 */

namespace Mappweb\Mappweb\Models\Scopes;



use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OrderGlobalScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if ($model->allowOrderByGlobalScope){
            $builder->orderBy($model->orderBy, $model->direction);
        }
    }
}