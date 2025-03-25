<?php

namespace App\Models\CompanyModule;

use App\Models\BaseModel; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PixelApp\Models\SystemConfigurationModels\Branch;

class CompanyBranch extends BaseModel
{
    use HasFactory;
    
    public function branch()
    {
        return $this->belongsTo(Branch::class)->select('id', 'name');
    }
}
