<?php

namespace  App\Services\CompanyModule\StatusChangerServices\CompanyTypeStatusChangers;

use App\Models\CompanyModule\TenantCompany;
use App\Http\Requests\CompanyModule\CompanyStatusUpdatingRequest;
use App\Services\CompanyModule\StatusChangerServices\CompanyTypeStatusChangers\Traits\TenantDefaultAdminNotificationMethods;
use PixelApp\Notifications\UserNotifications\StatusNotifications\InactiveRegistrationNotification;
use PixelApp\Services\UserEncapsulatedFunc\EmailAuthenticatableFuncs\StatusChangeableStatusChangers\StatusChangerTypes\SystemMemberAccountStatusChanger;

class CompanyAccountStatusChanger extends SystemMemberAccountStatusChanger
{

    use TenantDefaultAdminNotificationMethods;
    
    public function __construct(int $companyId)
    {
        $company = TenantCompany::findOrFail($companyId);
        parent::__construct($company);
    }
    
    protected function getRequestFormClass(): string
    {
        return  CompanyStatusUpdatingRequest::class;
    }

    protected function getNotificationClass() : ?string
    {
        return $this->model->status == "inactive" 
               ? InactiveRegistrationNotification::class
               : null;
    }
 
}
