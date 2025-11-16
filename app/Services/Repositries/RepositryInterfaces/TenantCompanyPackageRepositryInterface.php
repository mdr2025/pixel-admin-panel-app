<?php 

namespace App\Services\Repositries\RepositryInterfaces;

use App\Models\CompanyModule\Package;

interface TenantCompanyPackageRepositryInterface
{
   
    public function findById(int $id): ?Package;
    public function update(Package $package, array $data): bool;
    public function store(array $data): Package;
    public function getCountPackages();
    public function getListPackages();
    public function getPackages(array $relations = [], array $filters = []);
}