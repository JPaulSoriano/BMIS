<?php

namespace App\Http\Controllers\API;

use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PassengerController extends Controller
{
    //
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:16',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create($validated);

        $user->assignRole('passenger');
        $user->sendEmailVerificationNotification();
        return response()->json([
            'message' => 'OK',
            'username' => $user->name,
            'email' => $user->email,
        ], 200);
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'Given data is invalid',
                'errors' => [
                    'password' => [
                        'The password doesn\'t match'
                    ],
                ],
            ], 422);
        };

        return $request;

        $user = User::where('email', $request->email)->first();
        $authToken = $user->createToken('mobile-token')->plainTextToken;

        return response()->json([
            'access_token' => $authToken,
        ]);
    }

    public function test()
    {
        return "Ok token";
    }
}
