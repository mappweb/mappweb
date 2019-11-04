<?php
/**
 * User: Ing. Oswaldo Montes Severiche
 * Date: 4/11/19
 * Time: 11:13 a. m.
 */

namespace Mappweb\Mappweb\Models\Extensions;


use Illuminate\Database\Eloquent\Builder;

trait GlobalScopeManager
{
    protected $allowOrderByGlobalScope = true;

    protected $orderBy = 'created_at';

    protected $direction = 'asc';

    public static function bootGlobalScopeManager()
    {
        if (self::orderByAllowed()){
            static::addGlobalScope('order_by', function (Builder $builder){
                $builder->orderBy(self::getOrderBy(), self::getDirection());
            });
        }
    }

    protected function orderByAllowed()
    {
        return $this->allowOrderByGlobalScope;
    }

    protected function getOrderBy()
    {
        return $this->orderBy;
    }

    protected function getDirection()
    {
        return $this->direction;
    }
}