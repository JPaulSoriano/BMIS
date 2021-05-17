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
        //
        $travel_date = null;

        if(request('travel_date')){
            $travel_date = request('travel_date');
        }

        $bookings = Booking::select('*', 'bookings.id as book_id')
            ->join('rides', 'ride_id', 'rides.id')
            ->join('users', 'rides.user_id', 'users.id')
            ->where('users.id', Auth::user()->id)
            ->when($travel_date, function($query){
                return $query->where('travel_date', request('travel_date'));
            })->orderBy('bookings.updated_at', 'desc')
            ->orderBy('travel_date', 'asc')->get();
        return response()->json($bookings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $rides = collect();

        if(request('start') && request('end') && request('travel_date')){
            $rides = $this->rideService->getRidesByTerminals(request('start'), request('end'), request('travel_date'));
        }

        $terminals = Terminal::all();

        //return view('bookings.create', compact('rides', 'terminals'));
        return response()->json([
            'rides' => $rides,
            'terminals' => $terminals,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            $totalKm = $ride->route->getTotalKm($start, $end);
            $totalPoints = $totalKm/10 * $ride->bus->point;
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
            'payment' => $ride->getTotalPayment($start, $end) * $request->pax,
        ]);


        // return redirect()->route('bookings.my.bookings');
        return response()->json(new BookingResource($booking));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
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
}
