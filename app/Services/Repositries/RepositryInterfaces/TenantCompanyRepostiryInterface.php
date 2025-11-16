<?php 

namespace App\Services\Repositries\RepositryInterfaces;

use App\Models\CompanyModule\TenantCompany;
use Illuminate\Http\Request;

interface TenantCompanyRepostiryInterface
{
    public function index(array $filter = []);
    public function list();
    public function getSignupList(array $filters = [], Request $request) ;
    public function getCompanyList(array $filters = [], Request $request) ;
    public function hide(TenantCompany $company) : bool;
    public function getCompanyByEmail(string $email);
    public function findById(int $companyId) : ?TenantCompany;
    public function findByIdOrFail(int $companyId) : TenantCompany;
    public function findEvenTrashed(int $companyId) : ?TenantCompany;
    public function duplicate(TenantCompany $company, array $data);
    public function delete(TenantCompany $company);
}