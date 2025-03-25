<?php

use App\Http\Controllers\CompanyModule\PackagePriceController;
use Illuminate\Support\Facades\Route;

Route::controller(PackagePriceController::class)->prefix('package-price')->group(function () {
    Route::post('add', 'store');
    Route::put('update', 'update');
    Route::get('all', 'index');
    Route::get('show/{id}', 'show');
});
