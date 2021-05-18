<?php

namespace App\Http\Controllers\API;

use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Exception;
use Illuminate\Support\Facades\Validator;

class PassengerController extends Controller
{
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:16',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
            'first_name' => 'required',
            'last_name' => 'required',
            'contact' => 'required',
            'address' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->messages(), 422);
        }

        try{
            DB::beginTransaction();
            $user = User::create($request->only('name', 'email', 'password'));
            $user->passengerProfile()->create($request->except('name', 'email', 'password', 'password_confirmation'));
            DB::commit();
        }catch(Exception $e)
        {
            DB::rollBack();

            return response()->json([
                'error' => "There seems to be an error in the server.",
                'for_developer' => $e->getMessage()
            ]);
        }

        $user->assignRole('passenger');
        //$user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Go to your email and verify your account',
            'username' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->messages(), 422);
        }

        $credentials = request(['email', 'password']);
        $newCredentials = array_merge($credentials, ['active' => 1]);

        if(!Auth::attempt($newCredentials)){
            return response()->json([
                'message' => 'Given data is invalid',
                'errors' => [
                    'password' => [
                        'The password doesn\'t match'
                    ],
                    'active' => [
                        'Your account is inactive',
                    ],
                ],
            ], 422);
        };

        $user = User::where('email', $request->email)->first();
        return response()->json([
            'token' => $user->createToken($request->email)->plainTextToken,
            'profile' => $user->passengerProfile,
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {

        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logout successful',
        ]);
    }

    public function updateAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|max:16',
            'email' => 'nullable|unique:users,email,'.$request->user()->id,
            'password' => 'required|min:8|confirmed',
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'contact' => 'nullable',
            'address' => 'nullable'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->messages(), 422);
        }

        $request->user()->update($request->only('name', 'email', 'password'));
        $request->user()->passengerProfile()->update($request->except('name', 'email', 'password', 'password_confirmation'));

        return response()->json([
            'message' => 'Account successfully updated',
            'profile' => $request->user()->passengerProfile,
            'user' => $request->user(),
        ]);
    }

    public function retrievePoints()
    {
        return request()->user()->passengerProfile->points;
    }
}
