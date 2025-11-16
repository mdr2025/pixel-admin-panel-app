<?php

use App\Http\Controllers\CompanyModule\CompanyManagementController;
use App\Models\UsersModule\User;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:api")    
    ->prefix('company')->group(function () {

        //company general rotues
        //Route::get("/" , [CompanyManagementController::class , 'index']); // to check if it is needed later
        //Route::get('list', [CompanyManagementController::class , 'list']); // to check if it is needed later
        Route::get('show/{company}', [CompanyManagementController::class , 'show']);
        Route::get('company-default-admin/re-verify-email/{company}', [CompanyManagementController::class ,'resendDefaultAdminEmailVerification']);
        Route::put('updateEmail/{company}', [CompanyManagementController::class ,'updateCompanyEmail']);
        Route::delete('hide/{company}', [CompanyManagementController::class ,'hide']); //soft deleting route
        // Route::get('hidden-list', 'companyHiddenList');
        Route::delete('delete/{company}', [CompanyManagementController::class , 'delete']); // force deleting route

        //signup list routes
        Route::get('signup-list', [CompanyManagementController::class ,'signupList']);
        Route::put('signup-list/approve/{company}',  [CompanyManagementController::class ,'approveComapny' ]);
        Route::put('signup-list/reject/{company}',  [CompanyManagementController::class , 'rejectCompany' ]);


        //company list routes
        Route::get('company-list', [CompanyManagementController::class ,'companyList']);
        Route::put('update-company-list-status/{company}', [CompanyManagementController::class ,'changeCompanyListStatus']);
    });
 