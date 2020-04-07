<?php

namespace Mappweb\Mappweb\Http\Controllers;

use Mappweb\Mappweb\Traits\RequestValidationTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, RequestValidationTrait;

    protected $checkPermissions = false;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        if ($this->checkPermissions){

            $this->middleware(function ($request, $next){

                if (!$this->userHasPermission()){

                    if ($request->wantsJson()){
                        return response()->json(['error' => __('global.error.403')], 403);
                    }

                    abort(403);
                }

                return $next($request);
            });
        }
    }

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

}
