<?php

namespace App\Services\CompanyModule\StatusChangerServices\CompanyTypeStatusChangers\SignUpCompanyStatusChangerServices;

use App\Models\CompanyModule\TenantCompany;
use App\Services\CompanyModule\StatusChangerServices\CompanyTypeStatusChangers\Traits\TenantDefaultAdminNotificationMethods;
use PixelApp\Notifications\UserNotifications\StatusNotifications\RejectedRegistrationNotification;
use PixelApp\Services\UserEncapsulatedFunc\EmailAuthenticatableFuncs\StatusChangeableStatusChangers\StatusChangerTypes\SignUpAccountStatusChangerServices\SignUpAccountRejectingService as BaseSignUpAccountRejectingService;

class SignUpAccountRejectingService extends BaseSignUpAccountRejectingService
{
    use TenantDefaultAdminNotificationMethods;

    public function __construct(int $companyId)
    {
        $company = TenantCompany::findOrFail($companyId);
        parent::__construct($company);
    }

    protected function getNotificationClass() : ?string
    {
        return $this->model->status == "rejected" 
               ? RejectedRegistrationNotification::class
               : null;
    }
}
