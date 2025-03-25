<?php

namespace App\Models\CompanyModule;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Package extends BaseModel
{
    use HasFactory;
    // protected $fillable = [
    //     'name',
    //     'show',
    //     'monthly_price',
    //     'annual_price',
    //     'monthly_discount',
    //     'annual_discount',
    //     'privileges'
    // ];
    protected $fillable = [
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

    public function countryPackages()
    {
        return $this->hasMany(CountryPackage::class);
    }
}
