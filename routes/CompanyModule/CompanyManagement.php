<?php

use App\Http\Controllers\CompanyModule\CompanyManagementController;
use Illuminate\Support\Facades\Route;

Route::controller(CompanyManagementController::class)->prefix('company')->group(function () {
    Route::get('signup-list', 'signupList');
    Route::get('list', 'companyList');
    // Route::get('hidden-list', 'companyHiddenList');
    Route::delete('hide/{company}', 'hide');
    Route::delete('delete/{company}', 'delete');
    Route::put('update-register-status', 'updateRegisterStatus');
    Route::put('update-list-status', 'updateCompanyListStatus');
    // Route::put('updateEmail/{company_id}', 'updateCompanyEmail');
    // Route::post('resendEmailVerify', 'resendEmailVerify');
});
