<?php

namespace App\Models\SystemConfigurationModels;

use PixelApp\Models\PixelBaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use RuntimeCaching\Interfaces\ParentModelRuntimeCacheInterfaces\NeededFromChildes;

class Ranking extends PixelBaseModel implements NeededFromChildes
{
    use HasFactory;
    protected $table = "ranking";
    const ROUTE_PARAMETER_NAME = "ranking";
    protected $fillable = [
        "name", "status"
    ];

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
    protected $casts = [
        'status' => 'boolean',
    ];


}
