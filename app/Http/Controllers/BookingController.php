<?php

namespace App\Http\Controllers;

use App\Ride;
use App\Route;
use App\Booking;
use App\Terminal;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\BookingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\Booking\StoreBookingRequest;
use App\Services\RideService;
use Illuminate\Database\Query\Builder as QueryBuilder;

class BookingController extends Controller
{

    private BookingService $bookingService;
    private RideService $rideService;

    public function __construct(BookingService $bookingService, RideService $rideService)
    {
        $this->bookingService = $bookingService;
        $this->rideService = $rideService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bookings = Booking::when(request('travel_date'), function($query){
                return $query->where('travel_date', request('travel_date'));
            })->get();
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $rides = collect();

        if(request('start') && request('end') && request('travel_date')){
            $rides = $this->rideService->getRidesByTerminals(request('start'), request('end'), request('travel_date'));
        }

        $terminals = Terminal::all();

        return view('bookings.create', compact('rides', 'terminals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookingRequest $request)
    {
        $ride = Ride::findOrFail($request->ride_id);
        $start = $request->start_terminal_id;
        $end = $request->end_terminal_id;
        $travelDate = $request->travel_date;

        //Check if seats is still available
        $occupiedSeats = $this->bookingService->getOccupiedSeats($ride, $start, $end, $travelDate);

        $availableSeats = $ride->bus->bus_seat - $occupiedSeats;

        if($request->pax > $availableSeats){
            return redirect()->back()->withErrors('You cannot book more than available');
        }
        //Check auto_confirm
        if($ride->auto_confirm)
        {
            $status = "confirmed";
        }

        //store to database
        Booking::create([
            'passenger_id' => 17, //Change to passenger_id from api
            'ride_id' => $ride->id,
            'start_terminal_id' => $start,
            'end_terminal_id' => $end,
            'travel_date' => $travelDate,
            'pax' => $request->pax,
            'status' => $status,
        ]);

        return redirect()->route('bookings.my.bookings');
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

    public function book(Ride $ride, $start, $end, $travelDate)
    {
        $startTerminal = $ride->route->terminals->where('id', $start)->first();
        $endTerminal = $ride->route->terminals->where('id', $end)->first();

        $occupiedSeats = $this->bookingService->getOccupiedSeats($ride, $start, $end, $travelDate);

        $availableSeats = $ride->bus->bus_seat - $occupiedSeats;

        return view('bookings.book', ['ride' => $ride,
            'start_terminal' => $startTerminal,
            'end_terminal' => $endTerminal,
            'travel_date' => $travelDate,
            'available_seats' => $availableSeats]);
    }

    public function confirm(Booking $booking)
    {
        $booking->status = "confirmed";
        $booking->reason = null;
        $booking->save();

        return redirect()->back();
    }

    public function reject(Request $request, Booking $booking)
    {
        $booking->status = "rejected";
        $booking->reason = $request->reason;
        $booking->save();

        return redirect()->back();
    }
}
