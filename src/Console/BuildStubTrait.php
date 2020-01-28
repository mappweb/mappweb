<?php
/**
 * User: Ing. Oswaldo Montes Severiche
 * Date: 25/01/20
 * Time: 5:55 p. m.
 */

namespace Mappweb\Mappweb\Console;


use Illuminate\Support\Str;

trait BuildStubTrait
{
    protected function replaceModelName(&$stub)
    {
        $stub = str_replace('DummyModel', Str::camel($this->getNameInput()), $stub);
    }

    protected function replacePluralModelName(&$stub)
    {
        $stub = str_replace('DummyPluralModel', $this->getPluralModelName(), $stub);
    }

    protected function replaceSnakeModelName(&$stub)
    {
        $stub = str_replace('DummySnakeModel', Str::snake($this->getNameInput()), $stub);
    }

    protected function replaceSnakePluralModelName(&$stub)
    {
        $stub = str_replace('DummySnakePluralModel', Str::snake($this->getPluralModelName()), $stub);
    }

    protected function replaceKebabModelName(&$stub)
    {
        $stub = str_replace('DummyKebabModel', Str::kebab($this->getNameInput()), $stub);
    }

    protected function replaceKebabPluralModelName(&$stub)
    {
        $stub = str_replace('DummyKebabPluralModel', Str::kebab($this->getPluralModelName()), $stub);
    }

    protected function getPluralModelName()
    {
        return Str::plural($this->getNameInput());
    }
}