<?php 

namespace App\Services\CompanyModule;

use App\Services\Repositries\RepositryInterfaces\TenantCompanyRepostiryInterface;
use PixelApp\Models\ModelConfigs\TenantCompanyConfig;

class CompanyManagementService
{

    protected function initTenantCompanyManagementRepostiry() : TenantCompanyRepostiryInterface
    {
        return app(TenantCompanyRepostiryInterface::class);
    }

    public function getSignupList($request): array
    {
        $requestFilters = TenantCompanyConfig::getSignupListFilters();
        $data = $this->initTenantCompanyManagementRepostiry()->getSignupList($requestFilters, $request);

        return [
            'list' => $data,
            'statistics' => []
        ];
    }

    public function getCompanyList(): array
    {
        $requestFilters = TenantCompanyConfig::getCompanyListFilters();
        $data = $this->initTenantCompanyManagementRepostiry()->getCompanyList($requestFilters);

        return [
            'list' => $data,
            'statistics' => []
        ];
    }

    public function resendVerificationTokenToDefaultAdminEmail()
    {
        return (new DefaultAdminVerificationNotificationResendingService())->resend();
    }

    public function reVerifyEmail(CompanyDefaultAdmin $defaultAdmin)
    {
        return (new DefaultAdminVerificationNotificationResendingService())->setAuthenticatable($defaultAdmin)->resend();
    }
}