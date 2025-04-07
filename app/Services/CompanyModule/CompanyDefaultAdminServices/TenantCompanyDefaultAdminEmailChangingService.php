<?php

namespace App\Services\CompanyModule\CompanyDefaultAdminServices;

use App\Models\CompanyModule\TenantCompany;
use Exception;
use PixelApp\Http\Requests\UserManagementRequests\CompanyDefaultAdminChangeEmailRequest;
use PixelApp\Models\CompanyModule\CompanyDefaultAdmin;
use PixelApp\Services\UserEncapsulatedFunc\EmailAuthenticatableFuncs\EmailChangerService\EmailChangerService as BaseEmailChangerService;
use PixelApp\Events\TenancyEvents\TenantCompanyEvents\TenantDefaultAdminNewEmailHavingEvent;

class TenantCompanyDefaultAdminEmailChangingService  extends BaseEmailChangerService
{ 
    protected TenantCompany $tenant;

    public function __construct(int $companyId)
    {
        $this->setTenantCompany($companyId);

        if(!$defaultAdmin = $this->getTenantCompanyDefaultAdmin())
        {
            throw new Exception("The tenant company with id = $companyId doesn't have a default admin !");
        }
        
        parent::__construct($defaultAdmin);

    }

    protected function setTenantCompany($companyId) : void
    {
        $this->tenant = TenantCompany::findOrFail($companyId);
    }

    protected function getTenantCompanyDefaultAdmin() :  ?CompanyDefaultAdmin
    {
        return $this->tenant->defaultAdmin;
    }
   
    protected function getRequestFormClass(): string
    {
        return CompanyDefaultAdminChangeEmailRequest::class ;
    }

    protected function fireCommittingEvents() : void
    {
        $tenant = $this->tenant;

        $this->emailChanger->callOnEmailChange(function() use ($tenant)
        {
            event(new TenantDefaultAdminNewEmailHavingEvent($tenant));
        });
    }

}