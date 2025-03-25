<?php

namespace App\Http\Requests\CompanyModule;

use App\Models\SystemAdminPanel\Company\CountryPackage;
use Illuminate\Foundation\Http\FormRequest;

class PackagePriceRequest extends FormRequest
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
