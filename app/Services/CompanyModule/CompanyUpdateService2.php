<?php

namespace App\Services\CompanyModule;

use App\Models\CompanyModule\TenantCompany;
use PixelApp\Helpers\PixelGlobalHelpers;

class CompanyUpdateService2
{
    protected $company, $request;
    function __construct($request)
    {
        $this->company = TenantCompany::find($request->id);
        $this->request = $request->except($this->company->exceptData);
    }

    function updateCompany()
    {
        $company = $this->company ?? PixelGlobalHelpers::notFound();
        $data = $this->request;
        $data['logo'] = request()->logo ?? $company->logo;
        $company->update($data);
        return $company;
    }
    function update()
    {
        if ($this->updateCompany()) {
            return response()->json([
                "message" => "company has been updated successfully",
            ]);
        } else {
            return response()->json([
                "message" => "company has not been updated successfully",
            ]);
        }
    }
}
