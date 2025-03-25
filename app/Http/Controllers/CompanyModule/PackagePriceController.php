<?php

namespace App\Http\Controllers\CompanyModule;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyModule\PackagePriceRequest;
use App\Models\CompanyModule\CountryPackage;
use PixelApp\Helpers\PixelGlobalHelpers;

class PackagePriceController extends Controller
{
    function index()
    {
        $packages = CountryPackage::with('country', 'package')->get();
        return response()->json([
            "data" => $packages
        ]);
    }
    function store(PackagePriceRequest $request)
    {
        foreach ($request->data as $data) {
            $package = new CountryPackage;
            $package->package_id = $request->package_id;
            $package->country_id = $data['country_id'];
            $package->currency_id = $data['currency_id'];
            $package->monthly_price = $data['monthly_price'];
            $package->annual_price = $data['annual_price'];
            $package->save();
        }
        return response()->json([
            "data" => "package price has been added success"
        ]);
    }

    function show($id)
    {
        $package = CountryPackage::with('country', 'package')->find($id) ?? PixelGlobalHelpers::notfound();
        return response()->json([
            "data" => $package
        ]);
    }

    function update(PackagePriceRequest $request)
    {
        $package = CountryPackage::find($request->id)
            ->update($request->all());
        return response()->json([
            "data" => $package
        ]);
    }
}
