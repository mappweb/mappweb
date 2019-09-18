<?php

namespace Mappweb\Mappweb\Helpers;

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

    /**
     * Table constructor.
     * @param Repository $config
     * @param Factory $view
     * @param HtmlBuilder $html
     */
    public function __construct(Repository $config, Factory $view, HtmlBuilder $html)
    {
        parent::__construct($config, $view, $html);
    }


    /**
     *
     */
    public function addColumns()
    {
        $columns = $this->class::getColumnsTable();

        foreach ($columns as $column) {
            $this->addColumn($column);
        }

        $this->addAction(['title' => __('global.action')]);
    }

    /**
     * @param string $drawCallback
     */
    public function addParameters($drawCallback = 'function(){ }')
    {
        $this->parameters([
            'responsive' => true,
            'language' => [
                'url' => '//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json'
            ],
            'drawCallback' => $drawCallback
        ]);
    }

    /**
     * @param $url
     */
    public function setAjax($url)
    {
        $this->ajax([
            'url' => $url,
            'type' => 'GET',
            'data' => 'function(d) { d.key = "value"; }',
        ]);
    }

}