<?php

namespace App\Http\Requests\CompanyModule;

 
use ValidatorLib\CustomFormRequest\BaseFormRequest;

class CompanyDefaultAdminChangeEmailRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($data)
    {
        return [
            "email" => [ "required" , "email" ],
        ];
    }
}
