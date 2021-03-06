<?php

namespace App\Http\Controllers\Admin;

use App\BusCompanyProfile;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Profile\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile');
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if (!is_null($request->input('current_password'))) {
            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = Hash::make($request->input('new_password'));
            } else {
                return redirect()->back()->withInput();
            }
        }

        $user->save();


        if($user->hasRole('admin'))
        {
            if($request->company_name){

                if(count($user->companyProfile))
                {
                    $company = BusCompanyProfile::find($user->companyProfile->first()->id);
                    $company->update(
                    $request->only([
                            'company_name',
                            'company_address',
                            'company_contact',
                            'company_mission',
                            'company_profile',
                            'activate_point'
                            ]
                        )
                    );

                    if(!$request->activate_point) $company->update(['activate_point' => 0]);
                }
                else
                {
                    $company = BusCompanyProfile::create(
                        $request->only([
                                'company_name',
                                'company_address',
                                'company_contact',
                                'company_mission',
                                'company_profile',
                                'activate_point'
                            ]
                        )
                    );
                    $user->companyProfile()->attach($company);
                }
            }
        }


        return redirect()->route('admin.profile')->withSuccess('Profile updated successfully.');
    }
}
