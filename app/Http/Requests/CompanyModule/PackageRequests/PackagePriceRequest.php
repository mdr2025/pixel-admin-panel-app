<?php

namespace App\Http\Requests\CompanyModule\PackageRequests;

use App\Models\CompanyModule\CountryPackage;
use ValidatorLib\CustomFormRequest\BaseFormRequest;

class PackagePriceRequest extends BaseFormRequest
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
    public function rules()
    {
        return [
            'package_id' => ['required', 'exists:packages,id', $this->isTaken()],
            'data' => 'required|array',
            'data.*.country_id' => 'required|exists:countries,id',
            'data.*.currency_id' => 'required|exists:currencies,id',
            'data.*.monthly_price' => 'required|numeric',
            'data.*.annual_price' => 'required|numeric',

        ];
    }

    function isTaken()
    {
        return function ($attribute, $value, $fail) {
            $record = CountryPackage::where('package_id', $value)
                ->where('country_id', request()->input('data.*.country_id'))
                ->first();
            if ($record) {
                $fail('Duplicate prices are not allowed for same country');
            }
        };
    }
}
