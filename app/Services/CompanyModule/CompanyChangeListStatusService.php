<?php

namespace App\Services\CompanyModule;

use App\Models\CompanyModule\TenantCompany;
use PixelApp\Helpers\PixelGlobalHelpers;

class CompanyChangeListStatusService
{
    protected $company, $request;
    function __construct($request)
    {
        $this->company = TenantCompany::find($request->id);
        $this->request = $request;
    }
 
    function updateCompanyStatus()
    {
        $company = $this->company ?? PixelGlobalHelpers::notFound();
        $company->is_active = $this->request->is_active;
        $company->save();
        return $company->is_active;
    }
    
    function checkCompanyStatus()
    {
        if ($this->company->is_active == true) {
            return "company status is active";
        } else {
            return "company status is inactive";
        }
    }
    function update()
    {
        $this->updateCompanyStatus();
        $this->checkCompanyStatus();
        return response()->json([
            "message" => $this->checkCompanyStatus(),
        ]);
    }
}
