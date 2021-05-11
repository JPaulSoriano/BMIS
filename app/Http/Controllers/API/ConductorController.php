<?php

namespace App\Http\Controllers\API;

use App\Ride;
use App\User;
use App\EmployeeRide;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ConductorController extends Controller
{
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

    public function depart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ride_id' => 'required|exists:rides,id',
            'terminal_id' => 'required|exists:terminals,id',
            'or_no' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->messages(), 422);
        }

        $ride = Ride::findOrFail($request->ride_id);

        $employee_ride = $ride->employeeRide()->create([
            'ride_code' => Str::uuid()->toString(),
            'conductor_id' => $request->user()->id,
            'driver_id' => $ride->bus->driver_id,
            'travel_date' => Carbon::now()->toDateString(),
        ]);

        $employee_ride->departure()->create([
            'terminal_id' => $request->terminal_id,
            'or_no' => $request->or_no,
        ]);

        return response()->json([
            'ride_code' => $employee_ride->ride_code,
            'message' => 'SuccessFul'
        ]);
    }

    public function arrive(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ride_code' => 'required|exists:employee_ride,ride_code',
            'terminal_id' => 'required|exists:terminals,id',
            'or_no' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->messages(), 422);
        }

        $employeeRide = EmployeeRide::where('ride_code', $request->ride_code)->first();


        $employeeRide->arrival()->create([
            'terminal_id' => $request->terminal_id,
            'or_no' => $request->or_no,
        ]);

        return response()->json([
            'message' => 'SuccessFul'
        ]);
    }

    public function checkSchedules(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->messages(), 422);
        }

        $arrDates = [
            0 => Carbon::parse($request->date, 'UTC')->startOfDay(),
            1 => Carbon::parse($request->date, 'UTC')->endOfDay()
        ];

        // return $arrDates;

        $rides = Ride::join('buses', 'bus_id', 'buses.id')
            ->where('buses.conductor_id', $request->user()->id)
            ->whereBetween('rides.ride_date', [$arrDates[0], $arrDates[1]])
            ->get();

        return response()->json($rides);
    }

    public function todaySchedule(Request $request)
    {

        $arrDates = [
            0 => Carbon::now()->startOfDay(),
            1 => Carbon::now()->endOfDay()
        ];

        // return $arrDates;

        $rides = Ride::join('buses', 'bus_id', 'buses.id')
            ->where('buses.conductor_id', $request->user()->id)
            ->whereBetween('rides.ride_date', [$arrDates[0], $arrDates[1]])
            ->get();

        return response()->json($rides);
    }

    public function getEmployeeProfile(Request $request)
    {
        return response()->json($request->user()->employeeProfile);
    }
}
