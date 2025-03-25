<?php

use App\Http\Controllers\CompanyModule\PackageController;
use Illuminate\Support\Facades\Route;

Route::controller(PackageController::class)->prefix('package')->group(function () {
    Route::post('add', 'store');
    Route::put('update', 'update');
    Route::get('all', 'index');
    Route::get('show/{id}', 'show');
});
