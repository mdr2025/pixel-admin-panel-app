<?php

namespace App\Http\Controllers\CompanyModule;

use App\Http\Controllers\Controller;
use App\Models\CompanyModule\Package;
use AuthorizationManagement\PolicyManagement\Policies\BasePolicy; 
use PixelApp\Helpers\PixelGlobalHelpers;
use Spatie\QueryBuilder\QueryBuilder;

class PackageController extends Controller
{
    function index()
    {
        $fillableAttributes = (new Package())->getFillable();
        $data = QueryBuilder::for(Package::class)
            ->allowedFilters($fillableAttributes)
            ->with('countryPackages:id,monthly_price,annual_price')
            ->paginate(request()->pageSize ?? 10);
        // $statistics = $this->statistics(Company::class, $request, 'companies');
        return response()->success([
            'list' => $data,
            // 'statistics' => $statistics
        ]);
        $packages = Package::with('countryPackages:id,monthly_price,annual_price')->get();
        return response()->json([
            "data" => $packages
        ]);
    }
    function list()
    {
        $packages = Package::get(['id', 'name']);
        return response()->json([
            "data" => $packages
        ]);
    }
    function store(PackageRequest $request)
    {
        BasePolicy::check('create', Package::class);
        $package = Package::create($request->all());
        return response()->json([
            "data" => $package
        ]);
    }

    function show($id)
    {
        $package = Package::find($id) ?? PixelGlobalHelpers::notfound();
        return response()->json([
            "data" => $package
        ]);
    }

    function update(PackageRequest $request)
    {
        $package = Package::find($request->id)
            ->update($request->all());
        return response()->json([
            "data" => $package
        ]);
    }
}
