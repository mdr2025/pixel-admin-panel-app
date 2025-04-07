<?php

use App\Http\Controllers\CompanyModule\CompanyManagementController;
use Illuminate\Support\Facades\Route;

Route::controller(CompanyManagementController::class)->prefix('company')->group(function () {
    Route::get('signup-list', 'signupList');
    Route::get('signup-list/list', 'companyList');
    // Route::get('hidden-list', 'companyHiddenList');
    Route::delete('signup-list/hide/{companyId}', 'hide');
    Route::delete('signup-list/delete/{companyId}', 'delete');
    Route::put('signup-list/approve/{companyId}',  'aapproveComapny' );
    Route::put('signup-list/reject/{companyId}',   'rejectCompany' );
    Route::put('update-list-status/{companyId}', 'changeCompanyListStatus');
    Route::put('signup-list/updateEmail/{companyId}', 'updateCompanyEmail');
    Route::get('signup-list/resendEmailVerify/{companyId}', 'resendDefaultAdminEmailVerification');
});
