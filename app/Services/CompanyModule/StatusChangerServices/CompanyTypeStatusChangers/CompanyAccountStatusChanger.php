<?php

namespace  App\Services\CompanyModule\StatusChangerServices\CompanyTypeStatusChangers;

use App\Models\CompanyModule\TenantCompany;
use App\Http\Requests\CompanyModule\CompanyStatusUpdatingRequest;
use PixelApp\Services\UserEncapsulatedFunc\EmailAuthenticatableFuncs\StatusChangeableStatusChangers\StatusChangerTypes\SystemMemberAccountStatusChanger;

class CompanyAccountStatusChanger extends SystemMemberAccountStatusChanger
{

    public function __construct(int $companyId)
    {
        $company = TenantCompany::findOrFail($companyId);
        parent::__construct($company);
    }
    
    protected function getRequestFormClass(): string
    {
        return  CompanyStatusUpdatingRequest::class;
    }
 
}
