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
        $validated = $request->validate([
            'name' => 'required|max:16',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'first_name' => 'required',
            'last_name' => 'required',
            'contact' => 'required',
            'address' => 'required'
        ]);

        $data = collect($validated);
        try{
            DB::beginTransaction();
            $user = User::create($data->only('name', 'email', 'password')->toArray());
            $user->passengerProfile()->create($data->except('name', 'email', 'password')->toArray());
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
            'message' => 'OK',
            'username' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

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
        $authToken = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'access_token' => $authToken,
            'email' => $user->email,
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

    public function test()
    {
        return response()->json([
            'test' => 'Test is Successful. Authentication Ok. Verified Ok',
        ]);
    }
}
