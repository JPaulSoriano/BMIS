<?php

namespace App\Http\Controllers\Admin;

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

        $user->companyProfile()->updateOrCreate(['user_id' => Auth::user()->id],$request->only(['company_name', 'company_address', 'company_contact', 'company_mission', 'company_profile']));

        return redirect()->route('admin.profile')->withSuccess('Profile updated successfully.');
    }
}
