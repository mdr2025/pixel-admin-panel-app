<?php

namespace App\Http\Requests\CompanyModule_need_review;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
            'name' => 'required|string|unique:packages,name,' . $this->id . ',id',
            'description' => 'nullable|string',
            'invoices_count' => 'nullable|integer',
            'products_count' => 'nullable|integer',
            'employees_count' => 'nullable|integer',
            'clients_count' => 'nullable|integer',
            'vendors_count' => 'nullable|integer',
            'inventories_count' => 'nullable|integer',
            'treasueries_count' => 'nullable|integer',
            'assets_count' => 'nullable|integer',
            'quotations_count' => 'nullable|integer',
            'banks_accounts_count' => 'nullable|integer',
            'purchase_order_count' => 'nullable|integer',
            'attachments_size' => 'nullable|integer',
            // 'free_subscrip_period' => 'required|integer',
            'grace_period' => 'required|integer|max:30',
        ];
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            "errors" => $validator->errors()
        ]);

        throw new \Illuminate\Validation\ValidationException($validator, $response->setStatusCode(406));
    }

    public function messages()
    {
        return [
            "name.unique" => "The package name has already been taken"
        ];
    }
}
