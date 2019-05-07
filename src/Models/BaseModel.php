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
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;


/**
 * Class BaseModel
 * @package Mappweb\Mappweb\Models
 */
class BaseModel extends Model implements Auditable
{
    use SoftDeletes, AuditableTrait;
}