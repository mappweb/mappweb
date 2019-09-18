<?php
/**
 * User: Ing. Oswaldo Montes Severiche
 * Date: 9/2/19
 * Time: 3:43 p. m.
 */

namespace Mappweb\Mappweb\Presenters;



use Illuminate\Support\Str;

class TablePresenter
{
    /**
     * Adds the edit and delete buttons in the table.
     *
     * @param $resource
     * @param array $params
     * @param bool $flag_edit
     * @param bool $flag_destroy
     * @return string
     */
    public function addEditDeleteActions($resource, $params = [], $flag_edit = true, $flag_destroy=true)
    {
        $_html = '';
        if($flag_edit) {
            $_html .= '<a class="open-modal" href="'. route($resource.'.edit', $params) .'" data-toggle="tooltip" data-placement="right" title="'. __('models/'.Str::singular($resource).'.action.edit') .'"><i class="fa fa-pencil text-inverse m-r-10"></i></a>';
            $_html .= '&nbsp;';
        }
        if($flag_destroy) {
            $_html .= '<a class="open-modal" href="'. route($resource.'.destroy-modal', $params) .'" data-toggle="tooltip" title="'. __('models/'.Str::singular($resource).'.action.delete') .'"><i class="fa fa-close text-danger"></i></a>';
        }

        return $_html;
    }
}