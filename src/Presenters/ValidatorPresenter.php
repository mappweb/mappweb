<?php

namespace Mappweb\Mappweb\Presenters;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ValidatorPresenter
{
    public $valid = true;

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $pieces = preg_split('/(?=[A-Z])/', $name);

        Arr::forget($pieces, 0);

        $rowName = Str::lower(implode('_', $pieces));

        return $this->validate($arguments[0], $rowName, $arguments[1]);
    }

    /**
     * @param $row
     * @param $name
     * @param $rules
     * @return mixed
     */
    public function validate($row, $name, $rules)
    {
        $value = $row[$name];

        if ($this->isValid(["$name" => $value], ["$name" => $rules])){
            return $value;
        }

        echo $this->renderIconFail();
    }

    /**
     * @param array $fields
     * @param array $rules
     * @return bool
     */
    private function isValid(array $fields, array $rules)
    {
        $validator = Validator::make($fields, $rules);

        if ($validator->fails()){
            $this->valid = false;
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    private function renderIconFail()
    {
        return '<i class="fa fa-close text-danger"></i>';
    }
}