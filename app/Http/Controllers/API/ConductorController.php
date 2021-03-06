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
        if (EmployeeRide::whereRideCode($number)->exists()) $this->generateNumber();
        return $number;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $credentials = request(['email', 'password']);
        $newCredentials = array_merge($credentials, ['active' => 1]);

        if (!Auth::attempt($newCredentials)) {
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
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $ride = Ride::findOrFail($request->ride_id);
        $terminal_id = $ride->route->terminals->first()->id;

        $number = $this->generateNumber();
        $orNumber = $this->generateNumber();

        $employee_ride = $ride->employeeRide()->create([
            'ride_code' => $number,
            'conductor_id' => $request->user()->id,
            'driver_id' => $ride->bus->driver_id,
            'travel_date' => Carbon::now()->toDateString(),
        ]);

        $employee_ride->departure()->create([
            'terminal_id' => $terminal_id,
            'or_no' => $orNumber,
        ]);

        //Broadcast to passenger that bus depart

        return response()->json([
            'ride_code' => $employee_ride->ride_code,
            'message' => 'Successful'
        ]);
    }

    public function arrive(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ride_code' => 'required|exists:employee_ride,ride_code',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $orNumber = $this->generateNumber();
        $employeeRide = EmployeeRide::where('ride_code', $request->ride_code)->first();
        $terminal_id = $employeeRide->ride->route->terminals->map->pivot->sortByDesc('order')->first()->terminal_id;

        $employeeRide->arrival()->create([
            'terminal_id' => $terminal_id,
            'or_no' => $orNumber,
        ]);

        return response()->json([
            'message' => 'Successful'
        ]);
    }

    public function checkSchedules(Request $request)
    {

        $travelDate = Carbon::parse($request->date);
        $dayName = Str::lower($travelDate->copy()->dayName);
        $travelDate = $travelDate->toDateString();

        $rides = Ride::join('buses', 'bus_id', 'buses.id')
            ->where('buses.conductor_id', $request->user()->id)
            ->when($request->date, function ($query) use ($travelDate, $dayName) {
                $query->where(function (Builder $query) use ($travelDate, $dayName) {
                    $query->where('ride_date', $travelDate)
                        ->orWhereHas('schedule', function (Builder $query) use ($travelDate, $dayName) {
                            $query->where($dayName, true)
                                ->where(function (Builder $query) use ($travelDate) {
                                    $query->where('start_date', '<=', $travelDate);
                                })->where(function (Builder $query) use ($travelDate) {
                                    $query->where('end_date', '>=', $travelDate)
                                        ->orWhereNull('end_date');
                                });
                        });
                });
            })
            ->selectRaw('*, rides.id as ride_id')
            ->with(['route', 'route.terminals', 'bus.driver.employeeProfile'])
            ->get();

        $rides = $rides->map(function ($ride) {
            return ['ride' => $ride];
        });

        return response()->json($rides);
    }

    public function todaySchedule(Request $request)
    {
        $travelDate = Carbon::now();
        $dayName = Str::lower($travelDate->copy()->dayName);
        $travelDate = $travelDate->toDateString();

        $ride = Ride::join('buses', 'bus_id', 'buses.id')
            ->where('buses.conductor_id', $request->user()->id)
            ->where(function (Builder $query) use ($travelDate, $dayName) {
                $query->where('ride_date', $travelDate)
                    ->orWhereHas('schedule', function (Builder $query) use ($travelDate, $dayName) {
                        $query->where($dayName, true)
                            ->where(function (Builder $query) use ($travelDate) {
                                $query->where('start_date', '<=', $travelDate);
                            })->where(function (Builder $query) use ($travelDate) {
                                $query->where('end_date', '>=', $travelDate)
                                    ->orWhereNull('end_date');
                            });
                    });
            })
            ->with(['route', 'route.terminals', 'bus.driver.employeeProfile'])
            ->selectRaw('*, rides.id as ride_id')
            ->first();

        if (!$ride) return response()->json(['error' => 'No rides']);

        $booked = Booking::where('ride_id', $ride->ride_id);

        $aboard = (clone $booked)->where('aboard', 1)->sum('pax');
        $booked = $booked->sum('pax');

        $employeeRide = EmployeeRide::with(['departure', 'arrival'])
            ->where('ride_code', $request->ride_code)->first();


        return response()->json(['ride' => $ride, 'booked' => $booked, 'aboard' => $aboard, 'exists' => $employeeRide, 'date' => $travelDate]);
        // return response()->json(['ride' => $booked, 'error' => 'error'] );
    }

    public function getRide(Request $request, $id)
    {
        $ride = Ride::join('buses', 'bus_id', 'buses.id')
            ->where('rides.id', $id)
            ->selectRaw('*, rides.id as ride_id')
            ->with(['route', 'route.terminals', 'bus.driver.employeeProfile'])
            ->first();

        if (!$ride) return response()->json(['error' => 'No rides']);

        $booked = Booking::where('ride_id', $ride->id);

        $aboard = (clone $booked)->where('aboard', 1)->sum('pax');
        $booked = $booked->sum('pax');

        $employeeRide = EmployeeRide::where('ride_code', $request->ride_code)->with(['departure', 'arrival'])->first();

        return response()->json(['ride' => $ride, 'booked' => $booked, 'aboard' => $aboard, 'exists' => $employeeRide]);
    }

    public function getEmployeeProfile(Request $request)
    {
        return response()->json($request->user()->employeeProfile);
    }

    public function issueReceipt(Request $request, $book_code)
    {

        $booking = Booking::whereBookingCode($book_code);

        if (!$booking->exists()) {
            return response()->json(['error' => 'No bookings found!']);
        }
        $booking = $booking->first();

        $receipt = collect($booking->replicate()->only('booking_code', 'ride_id', 'passenger_id', 'start_terminal_id', 'end_terminal_id', 'pax'));

        if ($request->user()->company()->activate_point == 1) {
            $company_id = $request->user()->company()->id;
            $totalKm = $booking->ride->route->getTotalKm($booking->start_terminal_id, $booking->end_terminal_id);
            $totalPoints = $totalKm / 10 * $booking->ride->bus->busClass->point;
            $receipt = $receipt->merge(['points' => $totalPoints]);
            $booking->points = $totalPoints;

            $passenger = $booking->passenger;
            if (isset($booking->passenger->busPoints) && !empty($booking->passenger->busPoints->find($company_id))) {
                $prev_points = $passenger->busPoints->find($company_id)->pivot->points;
                $passenger->busPoints()->updateExistingPivot($company_id, ['points' => $prev_points + $totalPoints]);
            } else {
                $passenger->busPoints()->attach([$company_id => ['points' => $totalPoints]]);
            }
        }

        $booking->aboard =  1;
        $booking->status = 'done';
        $booking->push();

        //Send receipt to passenger

        return response()->json(['message' => 'Successful', 'points' => $totalPoints]);
    }

    public function getAllSchedules()
    {
        $start = Carbon::now();
        $end = Carbon::now()->addMonth();
        $rides = [];

        for ($i = $start; $i < $end; $i->addDay()) {
            $date_string = $i->toDateString();
            $date = Carbon::parse($date_string);
            $dayName = Str::lower($date->dayName);

            $ride = Ride::join('buses', 'bus_id', 'buses.id')
                ->where('buses.conductor_id', request()->user()->id)
                ->where(function (Builder $query) use ($date_string, $dayName) {
                    $query->where('ride_date', $date_string)
                        ->orWhereHas('schedule', function (Builder $query) use ($date_string, $dayName) {
                            $query->where($dayName, true)
                                ->where(function (Builder $query) use ($date_string) {
                                    $query->where('start_date', '<=', $date_string);
                                })->where(function (Builder $query) use ($date_string) {
                                    $query->where('end_date', '>=', $date_string)
                                        ->orWhereNull('end_date');
                                });
                        });
                })
                ->selectRaw('*, rides.id as ride_id')
                ->with(['route', 'route.terminals', 'bus.driver.employeeProfile'])
                ->get();

            if ($ride->count() > 0) {
                foreach ($ride as $r) {
                    $rides[] = [
                        'ride' => $r,
                        'date' => $date_string,
                    ];
                }
            }
        }

        return response()->json($rides);
    }
}
