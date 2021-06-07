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

        if (Booking::whereBookingCode($number)->exists()) $this->generateNumber();

        return $number;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status)
    {
        $bookings = request()->user()->bookings;
        $today = Carbon::now()->format('Y-m-d');

        if ($status == 'active') {
            $bookings = $bookings
                ->filter(function ($book) use ($today) {
                    return ($book->status == 'confirmed' || $book->status == 'done') && $book->travel_date >= $today;
                });
        }

        if ($status == 'inactive') {
            $bookings = $bookings->where('travel_date', '<', $today);
        }

        if ($status == 'cancelled') {
            $bookings = $bookings->filter(function ($book) use ($today) {
                return ($book->status != 'confirmed' || $book->status != 'done');
            });
        }

        $bookings = $bookings->sortBy('travel_date');

        return response()->json(BookingResource::collection($bookings));
    }

    public function bookByCash(Request $request)
    {
        $today = now()->toDateString();

        $validator = Validator::make($request->all(), [
            'ride_id' => 'required|exists:rides,id',
            'start_terminal_id' => 'required|exists:terminals,id',
            'end_terminal_id' => 'required|exists:terminals,id',
            'travel_date' => 'required|after:' . $today,
            'pax' => 'nullable|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $ride = Ride::findOrFail($request->ride_id);
        $start = $request->start_terminal_id;
        $end = $request->end_terminal_id;
        $travelDate = $request->travel_date;

        //Check if seats is still available
        $occupiedSeats = $this->bookingService->getOccupiedSeats($ride, $start, $end, $travelDate);

        $availableSeats = $ride->bus->bus_seat - $occupiedSeats;

        if ($request->pax > $availableSeats) {
            return response()->json(['error' => 'You cannot book more than available']);
        }

        //Check auto_confirm
        if ($ride->auto_confirm) {
            $status = "confirmed";
        }

        $number = $this->generateNumber();

        $booking = $request->user()->bookings()->create([
            'booking_code' => $number,
            'ride_id' => $ride->id,
            'start_terminal_id' => $start,
            'end_terminal_id' => $end,
            'travel_date' => $travelDate,
            'pax' => $request->pax,
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

        $validator = Validator::make($request->all(), [
            'ride_id' => 'required|exists:rides,id',
            'start_terminal_id' => 'required|exists:terminals,id',
            'end_terminal_id' => 'required|exists:terminals,id',
            'travel_date' => 'required|after:' . $today,
            'pax' => 'nullable|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $ride = Ride::findOrFail($request->ride_id);
        $start = $request->start_terminal_id;
        $end = $request->end_terminal_id;
        $travelDate = $request->travel_date;

        //Check if seats is still available
        $occupiedSeats = $this->bookingService->getOccupiedSeats($ride, $start, $end, $travelDate);

        $availableSeats = $ride->bus->bus_seat - $occupiedSeats;

        if ($request->pax > $availableSeats) {
            return response()->json(['error' => 'You cannot book more than available']);
        }

        //Check auto_confirm
        if ($ride->auto_confirm) {
            $status = "confirmed";
        }

        $fare = $this->bookingService->computeFare($ride, $request->pax, $start, $end);

        if ($ride->company->activate_point == 1) {

            //$points = $request->user()->passengerProfile->points;
            $prev_points = $request->user()->busPoints->find($ride->company->id)->pivot->points;
            if ($fare > $prev_points) {
                return response()->json(['error' => 'You do not have enough points']);
            } else {

                $request->user()->busPoints()->updateExistingPivot($ride->company->id, ['points' => $prev_points - $fare]);

                // $points -= $fare;
                // $request->user()->passengerProfile->points = $points;
                // $request->user()->push();
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
            'status' => $status ?? 'new',
        ]);

        $booking->sale()->create([
            'rate' => $ride->bus->busClass->rate,
            'payment' => $fare,
        ]);

        // return redirect()->route('bookings.my.bookings');
        return response()->json(new BookingResource($booking));
    }

    public function book()
    {
        $rides = collect();

        if (request('start') && request('end') && request('travel_date')) {
            $rides = $this->rideService->getRidesByTerminals(request('start'), request('end'), request('travel_date'));
        }

        $ride = $rides->where('ride_id', request('ride_id'));

        return response()->json(RideResource::collection($ride));
    }

    public function getTerminals()
    {
        return response()->json(Terminal::orderBy('terminal_name')->get());
    }

    public function searchRides()
    {
        $rides = collect();

        if (request('start') && request('end') && request('travel_date')) {
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
        $date = Carbon::now()->format('Y-m-d');
        // $time = Carbon::now();
        // $ride = request()->user()->bookings->first()->ride;
        // $minutesToDestination = $ride->route->terminals->where('pivot.order', ($ride->route->terminals->count() - 1))->first()->pivot->minutes_from_departure;
        // $departure_time = Carbon::parse($date . ' ' . $ride->departure_time, 'UTC');
        // $time->subMinutes($minutesToDestination + 30)->format('H:i:s');

        // $book = Booking::hydrate(request()->user()->bookings->where('travel_date', '=', $date)->where('ride.departure_time', '>', $time)->where('status', 'confirmed')->sortBy('travel_date')->toArray())->first();


        $booking = request()->user()->bookings->filter(function ($book) use ($date) {
            return ($book->status == 'confirmed' || $book->status == 'done') && $book->travel_date >= $date;
        })->sortBy('travel_date')->first();
        if (!$booking) return null;
        return response()->json(new BookingResource($booking));
    }

    public function cancelBooking($book_code)
    {
        $booking = Booking::whereBookingCode($book_code)->first();
        if ($booking->canBeCancelled()) {
            if ($booking->ride->company->activate_point == 1) {
                $totalPoints = $booking->sale->payment;
                if (isset(request()->user()->busPoints) && !empty(request()->user()->busPoints)) {
                    $prev_points = request()->user()->busPoints->find($booking->ride->company->id)->pivot->points;
                    $booking->passenger->busPoints()->updateExistingPivot($booking->ride->company->id, ['points' => $prev_points + $totalPoints]);
                } else {
                    $booking->passenger->busPoints()->attach([$booking->ride->company->id => ['points' => $totalPoints]]);
                }
            }


            $booking->status = 'cancelled by user';
            $booking->push();
            return response()->json([
                'message' => 'You cancelled your booking',
            ]);
        } else {
            return response()->json([
                'error' => 'Your booking cannot be cancelled anymore',
            ]);
        }
    }

    public function test()
    {
        $date = Carbon::now()->format('Y-m-d');
        $booking = Booking::with('ride')->where('travel_date', '>=', $date)->where('status', 'confirmed')->orderBy('travel_date')->first();
        if (!$booking) return null;
        return response()->json(new BookingResource($booking));
    }
}
