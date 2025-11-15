<?php

namespace App\Models\CompanyModule;

use App\Models\BaseModel; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PixelApp\Models\Interfaces\OptionalRelationsInterfaces\BelongsToBranch;
use PixelApp\Models\SystemConfigurationModels\Branch;
use PixelApp\Models\Traits\OptionalRelationsTraits\BelongsToBranchMethods;

class CompanyBranch extends BaseModel
{
    use HasFactory ;
    
    public function branch() : BelongsTo
    {
        return $this->belongsTo(Branch::class)->select('id', 'name');
    }
}
