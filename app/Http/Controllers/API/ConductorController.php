<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ride;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ConductorController extends Controller
{
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
        return $user->createToken($request->device_name)->plainTextToken;
    }

    public function logout(Request $request)
    {

        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logout successful',
        ]);
    }

    public function depart()
    {

    }

    public function arrive()
    {

    }

    public function checkSchedules(Request $request)
    {

        $arrDates = [
            0 => Carbon::parse($request->date, 'UTC')->startOfDay(),
            1 => Carbon::parse($request->date, 'UTC')->endOfDay()
        ];

        // return $arrDates;

        $rides = Ride::join('buses', 'bus_id', 'buses.id')
            ->where('buses.conductor_id', $request->user()->id)
            ->whereBetween('rides.ride_date', [$arrDates[0], $arrDates[1]])
            ->get();

        return response()->json(['rides' => $rides, 'dates' => $arrDates]);
    }
}
