<?php

namespace App\Services\CompanyModule\PackageServices;

use App\Models\ModelConfigs\PackageConfig;
use App\Services\Repositries\RepositryInterfaces\TenantCompanyPackageRepositryInterface;
use App\Models\CompanyModule\Package;

class PackageService
{
    public function __construct(private TenantCompanyPackageRepositryInterface $packageRepository)
    {
    }

    public function getPackages(): array
    {
        return [
            'list' => $this->packageRepository->getPackages(
                PackageConfig::getRelations(),
                PackageConfig::getFilters(),
            ),
            'permissions' => [],
            'statistics' => [],
        ];
    }

    public function getListPackages(): array
    {
        return $this->packageRepository->getListPackages();
    }
    public function getCountPackages(): int
    {
        return $this->packageRepository->getCountPackages();
    }

    public function show(Package $package): array
    {
        $package->load(PackageConfig::getRelations());
        return [
            'item' => $package
        ];
    }

    public function store(array $data): Package
    {
        return $this->packageRepository->store($data);
    }

    public function update(Package $package, array $data): bool
    {
        return $this->packageRepository->update($package, $data);
    }

    public function findById(int $id): ?Package
    {
        return $this->packageRepository->findById($id);
    }
}
