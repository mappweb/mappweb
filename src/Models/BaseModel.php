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
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;


/**
 * Class BaseModel
 * @package Mappweb\Mappweb\Models
 */
class BaseModel extends Model implements Auditable
{
    use SoftDeletes, AuditableTrait, EventsManager;

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
}