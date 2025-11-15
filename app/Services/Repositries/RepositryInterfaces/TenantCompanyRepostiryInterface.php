<?php 

namespace App\Services\Repositries\RepositryInterfaces;

interface TenantCompanyRepostiryInterface
{
    public function getSignupList(array $filters = [], $request) ;
    
    public function getCompanyList(array $filters = []);
}