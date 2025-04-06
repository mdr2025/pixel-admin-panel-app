<?php

namespace  App\Services\CompanyModule\StatusChangerServices;

use PixelApp\Models\CompanyModule\CompanyDefaultAdmin;
use PixelApp\Notifications\UserNotifications\StatusNotifications\InactiveRegistrationNotification;
use PixelApp\Notifications\UserNotifications\StatusNotifications\RejectedRegistrationNotification;
use PixelApp\Services\UserEncapsulatedFunc\EmailAuthenticatableFuncs\StatusChangeableStatusChangers\AccountStatusChanger as BaseAccountStatusChanger;

abstract class AccountStatusChanger extends BaseAccountStatusChanger
{
  
    //Here We get the convenient Notification Class by mapping it to status value
    // that is more dynamic and with this solution there is no need to more if conditions
    protected static $statusNotificationMap = [ 
        'inactive' => InactiveRegistrationNotification::class,
        'rejected' => RejectedRegistrationNotification::class,
    ];
  
    protected function getTenantDefaultAdmin() : ?CompanyDefaultAdmin
    {
        return $this->model->defaultAdmin ;
    }

    protected function sendNotification(string $notificationClass) : void
    {
        $this->getTenantDefaultAdmin()?->notify(new $notificationClass); 
    }
}
