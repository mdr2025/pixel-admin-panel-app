<?php

namespace App\Services\CompanyModule;

use App\Models\SystemSettings\UsersModule\User;
use App\Models\SystemSettings\UsersModule\UserProfile; 
use App\Models\CompanyModule\TenantCompany;
use Illuminate\Support\Facades\DB;
use PixelApp\Helpers\PixelGlobalHelpers;
use Throwable;

/**
 * for remove later
 */
class CompanyChangeRegisterStatusService
{
    protected $company, $request;
    function __construct($request)
    {
        $this->company = TenantCompany::find($request->company_id);
        $this->request = $request;
    }

    function generateCompanyId()
    {
        if (!$this->company->company_id) 
        {
            $companyId = 'CO-' . random_int(100000, 999999);
            if (codeExists($companyId, 'company_id')) {
                return $this->generateCompanyId();
            }
            return $companyId;
        }
        return $this->company->company_id;
    }

    function updateCompanyStatus()
    {
        $company = $this->company ?? PixelGlobalHelpers::notFound();
        $companyId = $this->generateCompanyId();
        $company->registration_status = $this->request->registration_status;
        $company->company_id = $companyId;
        $company->is_active = 1;
        $company->save();
        return $company->status;
    }
    function updateUser()
    {
        $user = User::where('email', $this->company->admin_email)->first();
        $user->email_verified_at = now();
        $user->save();
        return $user;
    }
    function sendEmail()
    {
        $companyId = explode('-', $this->company->company_id);
        $subject = "Congratulations! Your company account has been approved.";
        $message = "<p style=text-transform: capitalize;>
        <div>Congratulations!</div>
        <div>Your company account has been approved.</div>
        <div>Welcome to your organization!</div>
        <div>You can use the below provided company ID to access your company account at any time you login.</div>
        </p>
        <h3>Company ID :  <span style=text-decoration: underline;>{$companyId[1]}</span></h3>
        <div>Sincerely </div>
        <div>_______________</div>
        <div style=margin-top: 10px;>IGS Support Team</div>";
        sendEmailVerification($this->company, $subject, $message, null, 'admin_email');
    }

    // function tenant($domain)
    // {
    //     $tenant = Tenant::create(['id' => $domain]);
    //     $tenant->domains()->create(['domain' => $domain . env('TENANT_URL')]);
    // }

    function tenant($domain)
    {
        $tenant = Tenant::create(['id' => $domain]);
        $tenant->domains()->create([
            'domain' => $domain . env('API_SLUG', '-api')
        ]);
    }

    function checkCompanyStatus()
    {
        if ($this->company->registration_status == "approved") {
            $this->tenant($this->company->company_domain);
            $this->moveCompanyAdminForTenant();
            return $this->sendEmail();
        }
    }

    function moveCompanyAdminForTenant()
    {
        $company = $this->company;
        $centralUser = User::whereEmail($company->admin_email)->first(); //main databse
        $tenant = Tenant::find($company->company_domain);

        //must asyc function to handle the response
        $tenant->run(function () use ($centralUser) { //tenant
            try {
                DB::beginTransaction();
                $userId = User::insertGetId([
                    'first_name' => $centralUser->first_name,
                    'last_name' => $centralUser->last_name,
                    'name' => "{$centralUser->first_name} {$centralUser->last_name}",
                    'email' => $centralUser->email,
                    'password' => $centralUser->password,
                    'role_id' => 1,
                    'mobile' => $centralUser->mobile,
                    'email_verified_at' => now(),
                    'accepted_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'user_type' => "employee",
                    'status' => 1,
                ]);
                UserProfile::insert([
                    'picture' => $centralUser->profile->picture,
                    'country_id' => $centralUser->profile->country_id,
                    'user_id' => $userId,
                    'gender' => $centralUser->profile->gender,
                ]);
                DB::commit();
                //delete user from central databse
                DB::connection('mysql')->table("users")->where('email', $centralUser->email)->delete();
            } catch (Throwable $th) {
                DB::rollBack();
                throw $th;
            }
        }); 
    }

    function update()
    {
        $this->updateCompanyStatus();
        // $this->updateUser();
        $this->checkCompanyStatus();
        return response()->json([
            "message" => "Company Account Status Has been Updated",
        ]);
    }
}
