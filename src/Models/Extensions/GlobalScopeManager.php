<?php
/**
 * User: Ing. Oswaldo Montes Severiche
 * Date: 4/11/19
 * Time: 11:13 a. m.
 */

namespace Mappweb\Mappweb\Models\Extensions;


use Mappweb\Mappweb\Models\Scopes\OrderGlobalScope;

trait GlobalScopeManager
{
    public static function bootGlobalScopeManager()
    {
        static::addGlobalScope(new OrderGlobalScope);
    }
}