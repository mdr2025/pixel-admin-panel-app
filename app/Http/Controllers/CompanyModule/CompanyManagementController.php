<?php

namespace App\Http\Controllers\CompanyModule;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyModule\ChangeCompanyListStatusRequest;
use App\Http\Requests\CompanyModule\ChangeCompanyStatusRequest;
use App\Models\CompanyModule\TenantCompany;
use App\Services\CompanyModule\CompanyChangeListStatusService;
use App\Services\CompanyModule\CompanyChangeRegisterStatusService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use PixelApp\Http\Resources\AuthenticationResources\CompanyAuthenticationResources\ModelsResources\TenantCompanyResource;
use PixelApp\Http\Resources\SingleResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CompanyManagementController extends Controller
{
    function signupList(Request $request)
    {
        $data = QueryBuilder::for(TenantCompany::class)->with('contacts')
            ->allowedFilters([
                AllowedFilter::callback('name', function (Builder $query, $value) {
                        $query->where('first_name', 'like', "{$value}%")
                            ->orWhere('last_name', 'like', "{$value}%")
                            ->orWhere('admin_email', 'like', "{$value}%")
                            ->orWhere('name', 'like', "{$value}%")
                            ->orWhere('company_id', 'like', "{$value}%")
                            ->orWhereHas('contacts', function ($query) use ($value) {
                                $query->where('contact_No', 'like', "{$value}%");
                        });
                    }),
                AllowedFilter::exact('first_name'),
                AllowedFilter::exact('last_name'),
                AllowedFilter::exact('admin_email'),
                AllowedFilter::exact('registration_status')
            ])
            ->where('registration_status', 'pending')
            ->when($request->has('filter.email_verified_at'), function ($query) use ($request) {
                if ($request->input('filter.email_verified_at') == 'verified') {
                    return $query->whereNotNull('email_verified_at');
                } elseif ($request->input('filter.email_verified_at') == 'not verified') {
                    return $query->whereNull('email_verified_at');
                }
            })
            ->paginate($request->pageSize ?? 10);
        // $statistics = $this->statistics(Company::class, $request, 'signup_requests');

        return Response::success(['list' => $data, 'statistics' => []]);
    }

    function companyList(Request $request)
    { 
        $data = QueryBuilder::for(TenantCompany::class)
            ->with('contacts')
            ->allowedFilters(
                [
                    AllowedFilter::callback('details', function (Builder $query, $value) {
                        $query->where('first_name', 'like', "%" . $value . "%")
                            ->orWhere('last_name', 'like', "%" . $value . "%")
                            ->orWhere('admin_email', 'like', "%" . $value . "%")
                            ->orWhere('name', 'like', "%" . $value . "%")
                            ->orWhere('company_id', 'like', "%" . $value . "%")
                            ->orWhereHas('contacts', function ($query) use ($value) {
                                $query->where('contact_No', 'like', "%" . $value . "%");
                            });
                    }),
                    'first_name',
                    'last_name',
                    'admin_email',
                    'registration_status',
                    'is_active',
                    // 'country.name',
                    'branches_no',
                    'company_domain',
                    'package_status'
                ]
            )
            ->isApproved()
            ->paginate($request->pageSize ?? 10);
        // $statistics = $this->statistics(Company::class, $request, 'signup_requests');

        return Response::success(['list' => $data, 'statistics' => []]);
    }

    function updateRegisterStatus(ChangeCompanyStatusRequest $request)
    {
        return (new CompanyChangeRegisterStatusService($request))->update();
    }

    function updateCompanyListStatus(ChangeCompanyListStatusRequest $request)
    {
        return (new CompanyChangeListStatusService($request))->update();
    }
  
    // public function show(Request $request)
    // {
    //     return (new TenantCompanyResource( tenant() ));

    //     $token = $request->bearerToken();
    //     $item = TenantCompany::with( 'country')->where('verification_token' , $token)->get();
    //     return new SingleResource($item);
    // }

    public function hide($id)
    {
        $company = TenantCompany::findOrFail($id);
        $company->delete();

        $response = [
            "message" => "Deleted Successfully",
            "status" => "success"
        ];
        return response()->json($response, 200);
    }

    public function delete($id)
    {
        $company = TenantCompany::withTrashed()->find($id)->forceDelete();

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

//    function updateCompanyEmail($id, CompanyEmailRequest $request)
//    {
//        $data = $request->all();
//        $company = TenantCompany::findOrFail($id)->update(['admin_email' => $request->admin_email]);
//        event(new ResendEmailTokenEvent($company));
//        return response()->json([
//            "message" => "sent"
//        ]);
//    }

//    function resendEmailVerify(CompanyEmailRequest $request)
//    {
//        $company = TenantCompany::whereAdminEmail($request->admin_email)->first();
//        event(new ResendEmailTokenEvent($company));
//        return response()->json([
//            "message" => "sent"
//        ]);
//    }
}
