<?php

use App\Http\Controllers\CompanyModule\CompanyManagementController;
use App\Models\UsersModule\User;
use Illuminate\Support\Facades\Route;

Route::controller(CompanyManagementController::class)
    ->middleware("auth:api")    
    ->prefix('company')->group(function () {

        //company general rotues
        Route::delete('delete/{companyId}', 'delete'); // force deleting route
        Route::get('show/{companyId}', 'show');
        Route::get('company-default-admin/re-verify-emailVerify/{companyId}', 'resendDefaultAdminEmailVerification');
        Route::put('updateEmail/{companyId}', 'updateCompanyEmail');
        Route::delete('hide/{companyId}', 'hide'); //soft deleting route
        // Route::get('hidden-list', 'companyHiddenList');

        //signup list routes
        Route::get('signup-list', 'signupList');
        Route::put('signup-list/approve/{companyId}',  'approveComapny' );
        Route::put('signup-list/reject/{companyId}',   'rejectCompany' );


        //company list routes
        Route::get('company-list', 'companyList');
        Route::put('update-company-list-status/{companyId}', 'changeCompanyListStatus');
    });
 