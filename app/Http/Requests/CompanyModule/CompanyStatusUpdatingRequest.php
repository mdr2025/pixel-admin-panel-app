<?php

namespace App\Http\Requests\CompanyModule;

use App\Models\CompanyModule\TenantCompany; 
use Illuminate\Validation\Rule;
use ValidatorLib\CustomFormRequest\BaseFormRequest;

class CompanyStatusUpdatingRequest extends BaseFormRequest
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

    public function messages()
    {
        return [
            "status.required" => "Status has not been sent !",
            "status.in" => "Invalid status value!"
        ];
    }

    protected function getAcceptedAccountStatusChangableValues() : array
    {
        return (new TenantCompany())->getAcceptedAccountStatusChangableValues();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($data)
    {
        return [
            'status' => ["required", "string" ,   Rule::in( $this->getAcceptedAccountStatusChangableValues() )],
        ];
    }
}
