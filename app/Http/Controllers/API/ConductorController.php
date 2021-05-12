<?php

namespace App\Http\Controllers\API;

use App\Booking;
use App\Ride;
use App\User;
use App\EmployeeRide;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\PassengerHistory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ConductorController extends Controller
{
    function generateNumber()
    {
        $number = mt_rand(00000000000, 9999999999);
        if(EmployeeRide::whereRideCode($number)->exists()) $this->generateNumber();
        return $number;
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
            'profile' => $user->employeeProfile,
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

        $number = $this->generateNumber();

        $employee_ride = $ride->employeeRide()->create([
            'ride_code' => $number,
            'conductor_id' => $request->user()->id,
            'driver_id' => $ride->bus->driver_id,
            'travel_date' => Carbon::now()->toDateString(),
        ]);

        $employee_ride->departure()->create([
            'terminal_id' => $request->terminal_id,
            'or_no' => $request->or_no,
        ]);

        //Broadcast to passenger that bus depart

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

        $travelDate = Carbon::parse($request->date);
        $dayName = Str::lower($travelDate->copy()->dayName);
        $travelDate = $travelDate->toDateString();

        $rides = Ride::join('buses', 'bus_id', 'buses.id')
            ->where('buses.conductor_id', $request->user()->id)
            ->where('ride_date', $travelDate)
            ->where(function(Builder $query) use ($travelDate, $dayName){
                $query->where('ride_date', $travelDate)
                    ->orWhereHas('schedule', function(Builder $query) use ($travelDate, $dayName){
                        $query->where($dayName, true)
                            ->where(function(Builder $query) use ($travelDate, $dayName){
                                $query->where('start_date', '<=' ,$travelDate);
                            })->where(function(Builder $query) use ($travelDate, $dayName){
                                $query->where('end_date', '>=', $travelDate)
                                    ->orWhereNull('end_date');
                        });
                    });
            })
            ->with(['route', 'route.terminals', 'bus.driver.employeeProfile'])
            ->get();

        return response()->json($rides);
    }

    public function todaySchedule(Request $request)
    {
        $travelDate = Carbon::now();
        $dayName = Str::lower($travelDate->copy()->dayName);
        $travelDate = $travelDate->toDateString();


        $ride = Ride::join('buses', 'bus_id', 'buses.id')
            ->where('buses.conductor_id', $request->user()->id)
            ->where('ride_date', $travelDate)
            ->where(function(Builder $query) use ($travelDate, $dayName){
                $query->where('ride_date', $travelDate)
                    ->orWhereHas('schedule', function(Builder $query) use ($travelDate, $dayName){
                        $query->where($dayName, true)
                            ->where(function(Builder $query) use ($travelDate){
                                $query->where('start_date', '<=' ,$travelDate);
                            })->where(function(Builder $query) use ($travelDate){
                                $query->where('end_date', '>=', $travelDate)
                                    ->orWhereNull('end_date');
                        });
                    });
            })
            ->with(['route', 'route.terminals', 'bus.driver.employeeProfile'])
            ->first();

        if(!$ride) return response()->json(['error' => 'No rides']);

        $booked = Booking::where('ride_id', $ride->id);

        $aboard = (clone $booked)->where('aboard', 1)->sum('pax');
        $booked = $booked->sum('pax');

        $employeeRide = EmployeeRide::where('ride_code', $request->ride_code);
        if($employeeRide->exists()) $exists = 1;
        else $exists = 0;

        // return $date;
        return response()->json(['ride' => $ride, 'booked' => $booked, 'aboard' => $aboard, 'exists' => $exists] );
    }

    public function getEmployeeProfile(Request $request)
    {
        return response()->json($request->user()->employeeProfile);
    }

    public function issueReceipt(Request $request)
    {
        $booking = Booking::whereBookingCode(request('booking_code'));

        if(!$booking->exists())
        {
            return response()->json(['error' => 'No bookings found!']);
        }

        $receipt = collect($booking->replicate()->only('booking_code', 'ride_id', 'passenger_id', 'start_terminal_id', 'end_terminal_id', 'pax'));

        if($request->user()->company()->activate_point == 1)
        {
            $totalKm = $booking->ride->route->getTotalKm($booking->start_terminal_id, $booking->end_terminal_id);
            $totalPoints = $totalKm/10 * $booking->ride->bus->point;
            $receipt = $receipt->merge(['points' => $totalPoints]);
        }

        $booking->aboard =  1;
        $booking->save();

        PassengerHistory::create($receipt);

        //Send receipt to passenger

        return response()->json(['message' => 'Successful']);
    }
}
