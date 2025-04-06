<?php

namespace App\Services\CompanyModule;

use App\Models\CompanyModule\TenantCompany;
use Exception;
use PixelApp\Http\Requests\UserManagementRequests\CompanyDefaultAdminChangeEmailRequest;
use PixelApp\Models\CompanyModule\CompanyDefaultAdmin;
use PixelApp\Services\UserEncapsulatedFunc\EmailAuthenticatableFuncs\EmailChangerService\EmailChangerService as BaseEmailChangerService;

class TenantCompanyDefaultAdminEmailChangingService  extends BaseEmailChangerService
{ 
    public function __construct(int $companyId)
    {
        if($defaultAdmin = $this->getTenantCompanyDefaultAdmin($companyId))
        {
            parent::__construct($defaultAdmin);
        }

        throw new Exception("The tenant company with id = $companyId doesn't have a default admin !");
    }

    protected function getTenantCompanyDefaultAdmin($companyId) :  ?CompanyDefaultAdmin
    {
        $tenant = TenantCompany::findOrFail($companyId);
        return $tenant->defaultAdmin;
    }
   
    protected function getRequestFormClass(): string
    {
        return CompanyDefaultAdminChangeEmailRequest::class ;
    }
  
}