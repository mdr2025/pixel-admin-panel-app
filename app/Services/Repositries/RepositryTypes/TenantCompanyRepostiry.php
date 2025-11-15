<?php 

namespace App\Services\Repositries\RepositryTypes;

use App\Models\CompanyModule\TenantCompany;
use App\Services\Repositries\RepositryInterfaces\TenantCompanyRepostiryInterface;
use Spatie\QueryBuilder\QueryBuilder;

class TenantCompanyRepostiry implements TenantCompanyRepostiryInterface
{

    protected function initTenantCompanyQueryBuilder() : QueryBuilder
    {
        return QueryBuilder::for(TenantCompany::class);
    }

    public function getSignupList(array $filters = [], $request) 
    {
        $query = $this->initTenantCompanyQueryBuilder()
                      ->with('contacts')
                      ->allowedFilters([...$filters])
                      ->where('status', TenantCompany::REGISTRATIONS_DEFAULT_STATUS);

        $this->applyEmailVerificationFilter($query, $request);

        return $query->paginate(request()->pageSize ?? 10);
    }

    private function applyEmailVerificationFilter($query, $request)
    {
        $status = $request->input('filter.email_verified_at');

        if($status == 'verified')
        {
            $query->whereNotNull('email_verified_at');
            return ;
        }
    
        $query->whereNull('email_verified_at');
    }


    public function getCompanyList(array $filters = [])
    {
        return $this->initTenantCompanyQueryBuilder()
                    ->with('contacts')
                    ->allowedFilters(
                        [...$filters]
                    )
                    ->isApproved()
                    ->paginate(request()->pageSize ?? 10);
    }
}