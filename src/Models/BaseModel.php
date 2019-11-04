<?php
/**
 * Created by PhpStorm.
 * User: Diego
 * Date: 7/05/2019
 * Time: 4:10 PM
 */

namespace Mappweb\Mappweb\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mappweb\Mappweb\Models\Extensions\EventsManager;
use Mappweb\Mappweb\Models\Extensions\GlobalScopeManager;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;


/**
 * Class BaseModel
 * @package Mappweb\Mappweb\Models
 */
class BaseModel extends Model implements Auditable
{
    use SoftDeletes, AuditableTrait, EventsManager, GlobalScopeManager;

    /**
     * Allow store created_by field to table
     * @var boolean $addCreatedBy
     */
    protected $addCreatedBy = true;

    /**
     * Allow store updated_by field to table
     * @var boolean $addUpdatedBy
     */
    protected $addUpdatedBy = true;

    /**
     * Allow uuid like primary key
     * @var bool $allowUuid
     */
    protected $allowUuid = true;

    /**
     * Allow add order by created at global scope
     *
     * @var bool $allowOrderByGlobalScope
     */
    protected $allowOrderByGlobalScope = true;

    /**
     * Field to apply order by
     *
     * @var string
     */
    protected $orderBy = 'created_at';

    /**
     * Direction of the order by field
     *
     * @var string
     */
    protected $direction = 'asc';

    /**
     * @return bool
     */
    public function getIncrementing()
    {
        if ($this->allowUuid){
            return false;
        }
        return true;
    }

    /**
     * @return string
     */
    public function getKeyType()
    {
        if ($this->allowUuid){
            return 'string';
        }
        return 'int';
    }
}