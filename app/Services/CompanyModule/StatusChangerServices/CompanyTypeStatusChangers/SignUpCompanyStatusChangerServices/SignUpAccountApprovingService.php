<?php

namespace App\Services\CompanyModule\StatusChangerServices\CompanyTypeStatusChangers\SignUpCompanyStatusChangerServices;

use App\Http\Requests\CompanyModule\SignupAccountApprovingRequest; 
use App\Models\CompanyModule\TenantCompany;
use PixelApp\Events\TenancyEvents\TenantCompanyEvents\TenantCompanyApprovingEvents\ApprovedByAdminPanel;
use PixelApp\Services\UserEncapsulatedFunc\EmailAuthenticatableFuncs\StatusChangeableStatusChangers\StatusChangerTypes\SignUpAccountStatusChangerServices\SignUpAccountApprovingService as BaseSignUpAccountApprovingService;

/**
 * @property TenantCompany $model
 */
class SignUpAccountApprovingService extends BaseSignUpAccountApprovingService
{
    
    public function __construct(int $companyId)
    {
        $company = TenantCompany::findOrFail($companyId);
        parent::__construct($company);
    }
  
    protected function getRequestFormClass(): string
    {
        return SignupAccountApprovingRequest::class;
    }
    
    /**
     * @return bool
     */
    protected function sendStatusChangingNotification(): void
    {  
        event(new ApprovedByAdminPanel($this->model));
    }
}
