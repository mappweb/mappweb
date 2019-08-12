<?php
/**
 * User: Ing. Oswaldo Montes Severiche
 * Date: 2019-08-10
 * Time: 17:39
 */

namespace Mappweb\Mappweb\Database;

use Illuminate\Database\Schema\Blueprint;

class BaseBlueprint extends Blueprint
{
    public function createdByAndUpdatedBy()
    {
        $this->unsignedInteger('created_by');
        $this->unsignedInteger('updated_by');
    }
}