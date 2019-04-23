<?php

namespace mappweb\mappweb\Helpers;

use Collective\Html\HtmlBuilder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Html\Builder;

class Table extends Builder
{
    /**
     * @var Model $class
     */
    public $class;

    public function __construct(Repository $config, Factory $view, HtmlBuilder $html)
    {
        parent::__construct($config, $view, $html);
    }


    public function addColumns()
    {
        $columns = $this->class::getColumnsTable();

        foreach ($columns as $column) {
            $this->addColumn($column);
        }

        $this->addAction(['title' => __('global.accion')]);
    }

    public function addParameters()
    {
        $this->parameters([
            'responsive' => true,
            'language' => [
                'url' => '/template/js/lang/dataTable/i18n/Spanish.lang'
            ],
            'drawCallback' => 'function(){ ADMIN.ELEMENTS.body.trigger("tooltips.init"); }'
        ]);
    }

    public function setAjax($url)
    {
        $this->ajax([
            'url' => $url,
            'type' => 'GET',
            'data' => 'function(d) { d.key = "value"; }',
        ]);
    }

}