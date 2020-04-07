<?php


namespace Mappweb\Mappweb\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait RequestValidationTrait
{

    /**
     * @param $resource
     * @return array
     */
    protected function resourceMethodsMapToPermissions($resource)
    {
        return [
            'index' => "View$resource",
            'create' => "Create$resource",
            'store' => "Create$resource",
            'show' => "View$resource",
            'edit' => "Update$resource",
            'update' => "Update$resource",
            'destroy' => "Delete$resource",
        ];
    }

    /**
     * @return string
     */
    protected function getRouteName()
    {
        return request()->route()->getName();
    }

    /**
     * @return string
     */
    protected function getActionMethod()
    {
        return request()->route()->getActionMethod();
    }

    /**
     * @return string
     */
    protected function getResourceFromRouteName()
    {
        $routeName = $this->getRouteName();

        $pointPosition = strpos($routeName, '.');

        $resource = Str::substr($routeName, 0, $pointPosition);

        $resources = (preg_split('/([-\_])/', $resource));

        $append = '';

        foreach ($resources as $resource) {
            $append = $append . Str::ucfirst(preg_replace('/([-\_])/', '', $resource));
        }

        return $append;
    }

    /**
     * @return bool
     */
    protected function userHasPermission()
    {
        try {
            if (Auth::check()){
                $user = Auth::user();
                $actionNameMethod = $this->getActionMethod();
                $resource = $this->getResourceFromRouteName();
                return $user->{'can'. $this->resourceMethodsMapToPermissions($resource)[$actionNameMethod]}();
            }
        } catch (\Exception $exception){
            return false;
        }
    }
}
