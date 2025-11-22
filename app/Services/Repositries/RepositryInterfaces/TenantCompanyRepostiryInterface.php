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
    public function getCompanyByEmail(string $email);
    public function findById(int $companyId) : ?TenantCompany;
    public function findByIdOrFail(int $companyId) : TenantCompany;
}