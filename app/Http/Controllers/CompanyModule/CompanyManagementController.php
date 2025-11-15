<?php

namespace App\Http\Controllers\CompanyModule;

use App\Http\Controllers\Controller;
use App\Models\CompanyModule\TenantCompany;
use App\Models\UsersModule\User;
use App\Services\CompanyModule\CompanyDefaultAdminServices\DefaultAdminVerificationNotificationResendingService;
use App\Services\CompanyModule\CompanyDefaultAdminServices\TenantCompanyDefaultAdminEmailChangingService;
use App\Services\CompanyModule\StatusChangerServices\CompanyTypeStatusChangers\CompanyAccountStatusChanger;
use App\Services\CompanyModule\StatusChangerServices\CompanyTypeStatusChangers\SignUpCompanyStatusChangerServices\SignUpAccountApprovingService;
use App\Services\CompanyModule\StatusChangerServices\CompanyTypeStatusChangers\SignUpCompanyStatusChangerServices\SignUpAccountRejectingService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use PixelApp\Http\Resources\AuthenticationResources\CompanyAuthenticationResources\ModelsResources\TenantCompanyResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CompanyManagementController extends Controller
{
    // function signupList(Request $request)
    // {

    //     $data = QueryBuilder::for(TenantCompany::class)->with('contacts')
    //         ->allowedFilters([
    //             AllowedFilter::callback('name', function (Builder $query, $value) {
    //                     $query->where('first_name', 'like', "{$value}%")
    //                         ->orWhere('last_name', 'like', "{$value}%")
    //                         ->orWhere('admin_email', 'like', "{$value}%")
    //                         ->orWhere('name', 'like', "{$value}%")
    //                         ->orWhere('company_id', 'like', "{$value}%")
    //                         ->orWhereHas('contacts', function ($query) use ($value) {
    //                             $query->where('contact_No', 'like', "{$value}%");
    //                     });
    //                 }),
    //             AllowedFilter::exact('first_name'),
    //             AllowedFilter::exact('last_name'),
    //             AllowedFilter::exact('admin_email'),
    //             AllowedFilter::exact('status')
    //         ])
    //         ->where('status', 'pending')
    //         ->when($request->has('filter.email_verified_at'), function ($query) use ($request) {
    //             if ($request->input('filter.email_verified_at') == 'verified') {
    //                 return $query->whereNotNull('email_verified_at');
    //             } elseif ($request->input('filter.email_verified_at') == 'not verified') {
    //                 return $query->whereNull('email_verified_at');
    //             }
    //         })
    //         ->paginate($request->pageSize ?? 10);
    //     // $statistics = $this->statistics(Company::class, $request, 'signup_requests');

    //     return Response::success(['list' => $data, 'statistics' => []]);
    // }

    // function companyList(Request $request)
    // { 
    //     $data = QueryBuilder::for(TenantCompany::class)
    //         ->with('contacts')
    //         ->allowedFilters(
    //             [
    //                 AllowedFilter::callback('details', function (Builder $query, $value) {
    //                     $query->where('first_name', 'like', "%" . $value . "%")
    //                         ->orWhere('last_name', 'like', "%" . $value . "%")
    //                         ->orWhere('admin_email', 'like', "%" . $value . "%")
    //                         ->orWhere('name', 'like', "%" . $value . "%")
    //                         ->orWhere('company_id', 'like', "%" . $value . "%")
    //                         ->orWhereHas('contacts', function ($query) use ($value) {
    //                             $query->where('contact_No', 'like', "%" . $value . "%");
    //                         });
    //                 }),
    //                 'first_name',
    //                 'last_name',
    //                 'admin_email',
    //                 'status',
    //                 // 'country.name',
    //                 'branches_no',
    //                 'domain',
    //                 'package_status'
    //             ]
    //         )
    //         ->isApproved()
    //         ->paginate($request->pageSize ?? 10);
    //     // $statistics = $this->statistics(Company::class, $request, 'signup_requests');

    //     return Response::success(['list' => $data, 'statistics' => []]);
    // }

    public function approveComapny(int $companyId) : JsonResponse
    {
        return (new SignUpAccountApprovingService($companyId))->change();
    }

    public function rejectCompany(int $companyId) : JsonResponse
    {
        return (new SignUpAccountRejectingService($companyId))->change();
    }

    function changeCompanyListStatus(int $companyId): JsonResponse
    {
        return (new CompanyAccountStatusChanger($companyId))->change();
    }
  
    public function show(int $companyId)
    { 
        $tenant = TenantCompany::findOrFail($companyId);
        return (new TenantCompanyResource($tenant ));

        // $token = $request->bearerToken();
        // $item = TenantCompany::with( 'country')->where('verification_token' , $token)->get();
        // return new SingleResource($item);
    }

    public function hide($companyId)
    {
        $company = TenantCompany::findOrFail($companyId);
        $company->delete();

        $response = [
            "message" => "Deleted Successfully",
            "status" => "success"
        ];
        return response()->json($response, 200);
    }

    public function delete($companyId)
    {
        $company = TenantCompany::withTrashed()->find($companyId)->forceDelete();

        $response = [
            "message" => "Deleted Successfully",
            "status" => "success"
        ];
        return response()->json($response, 200);
    }

    // public function duplicate(CompanyRequest $request, $id)
    // {
    //     $data = $request->all();
    //     $recored = TenantCompany::find($id);
    //     $copy = $recored->replicate()->fill($data);
    //     $copy->save();

    //     $response = [
    //         "message" => "duplicated Successfully",
    //         "status" => "success"
    //     ];
    //     return response()->json($response, 200);
    // }

   function updateCompanyEmail(int $companyId): JsonResponse
   {
       return (new TenantCompanyDefaultAdminEmailChangingService($companyId))->change(); 
   }

   function resendDefaultAdminEmailVerification(int $companyId): JsonResponse
   {
        return (new DefaultAdminVerificationNotificationResendingService($companyId))->resend();
   }
}
