<?php

use App\Http\Controllers\CompanyModule\CompanyManagementController;
use Illuminate\Support\Facades\Route;

Route::controller(CompanyManagementController::class)->prefix('company')->group(function () {
    Route::get('signup-list', 'signupList');
    Route::get('list', 'companyList');
    // Route::get('hidden-list', 'companyHiddenList');
    Route::delete('hide/{company}', 'hide');
    Route::delete('delete/{company}', 'delete');
    Route::put('signup-list/approve/{companyId}',  'aapproveComapny' );
    Route::put('signup-list/reject/{companyId}',   'rejectCompany' );
    Route::put('update-list-status/{companyId}', 'changeCompanyListStatus');
    Route::put('updateEmail/{companyId}', 'updateCompanyEmail');
    // Route::post('resendEmailVerify', 'resendEmailVerify');
});
