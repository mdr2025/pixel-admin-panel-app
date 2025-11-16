<?php 

namespace App\Services\Repositries\RepositryTypes;

use App\Models\CompanyModule\TenantCompany;
use App\Services\Repositries\RepositryInterfaces\TenantCompanyRepostiryInterface;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class TenantCompanyRepostiry implements TenantCompanyRepostiryInterface
{

    protected function initTenantCompanyQueryBuilder() : QueryBuilder
    {
        return QueryBuilder::for(TenantCompany::class);
    }

    public function getSignupList(array $filters = [], Request $request) 
    {
        $query = $this->initTenantCompanyQueryBuilder()
                      ->with('contacts')
                      ->allowedFilters([...$filters])
                      ->scopes('signup');

        $this->applyEmailVerificationFilter($query, $request);

        return $query->paginate($request->pageSize ?? 10);
    }

    private function applyEmailVerificationFilter($query, Request $request) 
    {
        $status = $request->input('filter.email_verified_at');

        if($status == 'verified')
        {
            $query->whereNotNull('email_verified_at');
            return ;
        }
    
        $query->whereNull('email_verified_at');
    }


    public function getCompanyList(array $filters = [], Request $request) 
    {
        return $this->initTenantCompanyQueryBuilder()
                    ->with('contacts')
                    ->allowedFilters(
                        [...$filters]
                    )
                    ->scopes('approved')
                    ->paginate($request->pageSize ?? 10);
    }

    public function index(array $filter = [])
    {
        return $this->initTenantCompanyQueryBuilder()
                    ->allowedFilters([...$filter])
                    ->datesFiltering()
                    ->customOrdering()
                    ->paginate(request()->pageSize ?? 10);
    }

    public function list()
    {
        return $this->initTenantCompanyQueryBuilder()
                    ->allowedFilters(['name'])
                    ->customOrdering('created_at', 'desc')
                    ->get(['id' , "name" , "company_id"]);
    }

    /**
     * Soft deleting method
     */
    public function hide(TenantCompany $company) : bool
    {
        return $company->delete();
    }

    public function findEvenTrashed(int $companyId) : ?TenantCompany
    {
        return TenantCompany::withTrashed()->where("id" , $companyId)->first();
    }
    public function delete(TenantCompany $company)
    {
        /**
         * @todo to ask
         */
        //temprary
        return true;
        return $company->forceDelete();
    }

    public function duplicate(TenantCompany $company, array $data)
    {
         /**
         * @todo to ask
         */
        //temprary
        return true;

        $copy = $company->replicate()->fill($data);
        return $copy->save();
    }

    public function getCompanyByEmail(string $email)
    {
        return TenantCompany::whereAdminEmail($email)->first();
    }

    public function findById(int $companyId): ?TenantCompany
    {
        return TenantCompany::find($companyId);
    }

    public function findByIdOrFail(int $companyId): TenantCompany
    {
        return TenantCompany::findOrFail($companyId);
    }
}