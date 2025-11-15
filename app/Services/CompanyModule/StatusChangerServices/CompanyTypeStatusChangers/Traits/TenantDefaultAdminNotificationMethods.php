<?php

namespace App\Services\CompanyModule\StatusChangerServices\CompanyTypeStatusChangers\Traits;

use PixelApp\Models\CompanyModule\CompanyDefaultAdmin;

trait TenantDefaultAdminNotificationMethods
{
    protected function getTenantDefaultAdmin() : ?CompanyDefaultAdmin
    {
        return $this->model->defaultAdmin ;
    }

    protected function sendNotification(string $notificationClass) : void
    {
        $this->getTenantDefaultAdmin()?->notify(new $notificationClass); 
    }
}