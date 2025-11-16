<?php

namespace App\Models\ModelConfigs;

class PackageConfig
{
    public static function getFilters(): array
    {
        return [
            'name',
            'description',
            'invoices_count',
            'employees_count',
            'clients_count',
            'vendors_count',
            'inventories_count',
            'treasueries_count',
            'assets_count',
            'quotations_count',
            'banks_accounts_count',
            'purchase_order_count',
            'attachments_size',
            'free_subscrip_period',
            'grace_period',
            'products_count',
        ];
    }

    public static function getRelations(): array
    {
        return [
            'countryPackages:id,monthly_price,annual_price',
        ];
    }
}
