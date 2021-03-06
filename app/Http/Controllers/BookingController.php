<?php

namespace App\Http\Controllers;

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
        if (Auth::user()->companyProfile->count() == 0)
            return redirect()->route('admin.profile')->withErrors(['error' => 'Provide company profile first']);
        $travel_date = null;

        if (request('travel_date')) {
            $travel_date = request('travel_date');
        }

        $bookings = Booking::query();

        $bookings = $bookings->select('*', 'bookings.id as book_id')
            ->join('rides', 'ride_id', 'rides.id')
            ->join('bus_company_profiles as company', 'rides.company_id', 'company.id')
            ->where('company.id', Auth::user()->company()->id)
            ->when($travel_date, function ($query) {
                return $query->where('travel_date', request('travel_date'));
            })
            ->orderBy('bookings.updated_at', 'desc')
            ->orderBy('travel_date', 'asc');

        if (request('status') && request('status') != 'all') {
            $bookings->where('status', request('status'));
        }

        $bookings = $bookings->get();
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

        if (request('start') && request('end') && request('travel_date')) {
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

        if ($request->pax > $availableSeats) {
            return redirect()->back()->withErrors('You cannot book more than available');
        }

        //Check auto_confirm
        if ($ride->auto_confirm) {
            $status = "confirmed";
        }

        //store to database
        $booking = Booking::create([
            'passenger_id' => 17, //Change to passenger_id from api
            'ride_id' => $ride->id,
            'start_terminal_id' => $start,
            'end_terminal_id' => $end,
            'travel_date' => $travelDate,
            'pax' => $request->pax,
            'status' => $status ?? 'new',
        ]);

        $booking->sale()->create([
            'rate' => $ride->bus->busClass->rate,
            'payment' => $ride->getTotalPayment($start, $end) * $request->pax,
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

        return view('bookings.book', [
            'ride' => $ride,
            'start_terminal' => $startTerminal,
            'end_terminal' => $endTerminal,
            'travel_date' => $travelDate,
            'available_seats' => $availableSeats
        ]);
    }

    public function confirm(Booking $booking)
    {
        $booking->status = "confirmed";
        $booking->reason = null;
        $booking->push();

        return redirect()->back();
    }

    public function reject(Request $request, Booking $booking)
    {
        $booking->status = "rejected";
        $booking->reason = $request->reason;
        $payment = $booking->sale->payment;
        if (!empty($booking->passenger->busPoints) && $booking->passenger->busPoints->find(Auth::user()->company()->id)) {
            $prev_points = $booking->passenger->busPoints->find($booking->ride->company->id)->pivot->points;
            $booking->passenger->busPoints()->updateExistingPivot(Auth::user()->company()->id, ['points' => $prev_points + $payment]);
        } else {
            $booking->passenger->busPoints()->attach([Auth::user()->company()->id => ['points' => $payment]]);
        }

        $booking->push();

        return redirect()->back();
    }
}
