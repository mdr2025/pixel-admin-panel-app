<?php
 
namespace App\Models\CompanyModule;

use PixelApp\Models\SystemConfigurationModels\CountryModule\Country;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory; 

class CountryPackage extends BaseModel
{
    use HasFactory;
    protected $fillable = ['package_id', 'country_id', 'old_monthly_price', 'monthly_price', 'annual_price', 'old_annual_price'];
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
