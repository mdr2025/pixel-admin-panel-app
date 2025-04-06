<?php

namespace App\Services\CompanyModule\StatusChangerServices\CompanyTypeStatusChangers\SignUpCompanyStatusChangerServices;

use App\Models\CompanyModule\TenantCompany;
use PixelApp\Services\UserEncapsulatedFunc\EmailAuthenticatableFuncs\StatusChangeableStatusChangers\StatusChangerTypes\SignUpAccountStatusChangerServices\SignUpAccountRejectingService as BaseSignUpAccountRejectingService;

class SignUpAccountRejectingService extends BaseSignUpAccountRejectingService
{
    public function __construct(int $companyId)
    {
        $company = TenantCompany::findOrFail($companyId);
        parent::__construct($company);
    }
}
