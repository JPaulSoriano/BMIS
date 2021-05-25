<?php

namespace App\Http\Controllers\API;

use App\Ride;
use App\User;
use App\Route;
use App\Booking;
use App\Terminal;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\RideService;
use App\Services\BookingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\Booking\StoreBookingRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Rides as RideResource;
use App\Http\Resources\Bookings as BookingResource;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{

    private BookingService $bookingService;
    private RideService $rideService;

    public function __construct(BookingService $bookingService, RideService $rideService)
    {
        $this->bookingService = $bookingService;
        $this->rideService = $rideService;
    }

    function generateNumber()
    {
        $number = mt_rand(00000000000, 9999999999);

        if(Booking::whereBookingCode($number)->exists()) $this->generateNumber();

        return $number;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $bookings = request()->user()->bookings->sortBy('travel_date');

        return response()->json(BookingResource::collection($bookings));
    }

    public function bookByCash(Request $request)
    {
        $today = now()->toDateString();

        $validator = Validator::make($request->all(),[
            'ride_id' => 'required|exists:rides,id',
            'start_terminal_id' => 'required|exists:terminals,id',
            'end_terminal_id' => 'required|exists:terminals,id',
            'travel_date' => 'required|after:'.$today,
            'pax' => 'nullable|numeric|min:1'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->messages(), 422);
        }

        $ride = Ride::findOrFail($request->ride_id);
        $start = $request->start_terminal_id;
        $end = $request->end_terminal_id;
        $travelDate = $request->travel_date;

        //Check if seats is still available
        $occupiedSeats = $this->bookingService->getOccupiedSeats($ride, $start, $end, $travelDate);

        $availableSeats = $ride->bus->bus_seat - $occupiedSeats;

        if($request->pax > $availableSeats){
            return response()->json(['error' => 'You cannot book more than available']);
        }

        //Check auto_confirm
        if($ride->auto_confirm)
        {
            $status = "confirmed";
        }

        $totalPoints = 0;

        // if($ride->company->activate_point == 1)
        // {
        //     $totalKm = $ride->route->getTotalKm($start, $end);
        //     $totalPoints = $totalKm/10 * $ride->bus->busClass->point;
        //     $request->user()->passengerProfile->points += $totalPoints;
        //     $request->user()->push();
        // }

        $number = $this->generateNumber();

        $booking = $request->user()->bookings()->create([
            'booking_code' => $number,
            'ride_id' => $ride->id,
            'start_terminal_id' => $start,
            'end_terminal_id' => $end,
            'travel_date' => $travelDate,
            'pax' => $request->pax,
            'points' => $totalPoints,
            'status' => $status ?? 'new',
        ]);

        $booking->sale()->create([
            'rate' => $ride->bus->busClass->rate,
            'payment' => $this->bookingService->computeFare($ride, $request->pax, $start, $end),
        ]);

        // return redirect()->route('bookings.my.bookings');
        return response()->json(new BookingResource($booking));
    }

    public function bookByPoints(Request $request)
    {
        $today = now()->toDateString();

        $validator = Validator::make($request->all(),[
            'ride_id' => 'required|exists:rides,id',
            'start_terminal_id' => 'required|exists:terminals,id',
            'end_terminal_id' => 'required|exists:terminals,id',
            'travel_date' => 'required|after:'.$today,
            'pax' => 'nullable|numeric|min:1'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->messages(), 422);
        }

        $ride = Ride::findOrFail($request->ride_id);
        $start = $request->start_terminal_id;
        $end = $request->end_terminal_id;
        $travelDate = $request->travel_date;

        //Check if seats is still available
        $occupiedSeats = $this->bookingService->getOccupiedSeats($ride, $start, $end, $travelDate);

        $availableSeats = $ride->bus->bus_seat - $occupiedSeats;

        if($request->pax > $availableSeats){
            return response()->json(['error' => 'You cannot book more than available']);
        }

        //Check auto_confirm
        if($ride->auto_confirm)
        {
            $status = "confirmed";
        }

        $totalPoints = 0;

        if($ride->company->activate_point == 1)
        {
            $fare = $this->bookingService->computeFare($ride, $request->pax, $start, $end);
            $points = $request->user()->passengerProfile->points;
            if($fare > $points){
                return response()->json(['error' => 'You do not have enough points']);
            }else{
                $points -= $fare;
                $request->user()->passengerProfile->points = $points;
                $request->user()->push();
            }
        }

        $number = $this->generateNumber();

        $booking = $request->user()->bookings()->create([
            'booking_code' => $number,
            'ride_id' => $ride->id,
            'start_terminal_id' => $start,
            'end_terminal_id' => $end,
            'travel_date' => $travelDate,
            'pax' => $request->pax,
            'points' => $totalPoints,
            'status' => $status ?? 'new',
        ]);

        $booking->sale()->create([
            'rate' => $ride->bus->busClass->rate,
            'payment' => $this->bookingService->computeFare($ride, $request->pax, $start, $end),
        ]);

        // return redirect()->route('bookings.my.bookings');
        return response()->json(new BookingResource($booking));
    }

    public function book()
    {
        $rides = collect();

        if(request('start') && request('end') && request('travel_date')){
            $rides = $this->rideService->getRidesByTerminals(request('start'), request('end'), request('travel_date'));
        }

        $ride = $rides->where('ride_id', request('ride_id'));

        return response()->json(RideResource::collection($ride));
    }

    public function getTerminals()
    {
        return response()->json(Terminal::all());
    }

    public function searchRides()
    {
        $rides = collect();

        if(request('start') && request('end') && request('travel_date')){
            $rides = $this->rideService->getRidesByTerminals(request('start'), request('end'), request('travel_date'));
        }

        return response()->json(RideResource::collection($rides));
    }

    public function computeFare()
    {
        $ride = Ride::findOrFail(request('ride_id'));
        $pax = request('pax');
        $km_minus = (int)request('total_km') - 5;
        $flat_rate = $ride->bus->busClass->flat_rate;
        $rate = $ride->bus->busClass->rate;

        $total_fare = (($km_minus * $rate) + $flat_rate) * $pax;

        return $total_fare;
    }

    public function getBooking()
    {
        $booking = request()->user()->bookings->sortBy('travel_date')->first();
        return response()->json(new BookingResource($booking));
    }

    public function cancelBooking($book_code)
    {
        $booking = Booking::whereBookingCode($book_code)->first();
        if($booking->canBeCancelled()){
            $totalPoints = $booking->sale->payment;
            $booking->passenger->passengerProfile->points += $totalPoints;
            $booking->status = 'cancelled by user';
            $booking->push();
            return response()->json([
                'message' => 'You cancelled your booking',
            ]);
        }else{
            return response()->json([
                'error' => 'Your booking cannot be cancelled anymore',
            ]);
        }
    }
}
