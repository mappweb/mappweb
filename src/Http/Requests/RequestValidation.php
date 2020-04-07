<?php


namespace Mappweb\Mappweb\Http\Requests;


use Mappweb\Mappweb\Traits\RequestValidationTrait;
use Illuminate\Foundation\Http\FormRequest;


class RequestValidation  extends FormRequest
{

    use RequestValidationTrait;

    /**
     * @var bool
     */
    protected $checkPermissions = false;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->checkPermissions){
            if (!$this->userHasPermission()){
                return  false;
            }
        }
        return true;
    }

    /**
     * @param $resource
     * @return array
     */
    protected function resourceMethodsMapToPermissions($resource)
    {
        return [
            'store' => "Store$resource",
            'update' => "Update$resource",
        ];
    }


}
