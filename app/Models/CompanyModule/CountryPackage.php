<?php

namespace App\Models\CompanyModule;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PixelApp\Models\Interfaces\OptionalRelationsInterfaces\BelongsToCountry;
use PixelApp\Models\Traits\OptionalRelationsTraits\BelongsToCountryMethods;

class CountryPackage extends BaseModel implements BelongsToCountry
{
    use HasFactory , BelongsToCountryMethods;
    
    protected $fillable = ['package_id', 'country_id', 'old_monthly_price', 'monthly_price', 'annual_price', 'old_annual_price'];

    public function package()

    {
        return $this->belongsTo(Package::class);
    }
 
}
