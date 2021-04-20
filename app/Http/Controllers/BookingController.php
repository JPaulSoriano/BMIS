<?php

namespace App\Http\Controllers;

use App\Ride;
use App\Route;
use App\Booking;
use App\Http\Requests\Booking\StoreBook;
use App\Terminal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('bookings.index');
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
            //$rides = Ride::all();
            $start = request('start');
            $end = request('end');
            $travelDate = request('travel_date');
            $dayName = Str::lower(Carbon::parse($travelDate)->dayName);

            $startTerminalQuery = DB::table('route_terminal')->where('terminal_id', $start);
            $endTerminalQuery = DB::table('route_terminal')->where('terminal_id', $end);

            //check if route exists
            $routes = Route::whereHas('terminals', function (Builder $query) use ($start) {
                $query->where('terminals.id', $start);
            })->whereHas('terminals', function (Builder $query) use ($start, $end) {
                $query->where('terminals.id', $end)
                    ->where('order', '>', function (QueryBuilder $query) use ($start) {
                        $query->select('order')
                            ->from('route_terminal')
                            ->where('terminal_id', $start)
                            ->whereColumn('route_id', 'routes.id');
                    });
            })
                ->get()
                ->pluck('id')
                ->toArray();

            //check available seats

            //check if there's available ride
            $rideQuery = Ride::joinSub($startTerminalQuery, 'start_terminal', function($join){
                    $join->on('rides.route_id', 'start_terminal.route_id');
                })->joinSub($endTerminalQuery, 'end_terminal', function($join){
                    $join->on('rides.route_id', 'end_terminal.route_id');
                })->whereHas('route', function(Builder $query) use ($routes){
                    $query->whereIn('id', $routes);
                })->where(function(Builder $query) use ($travelDate, $dayName){
                    $query->where('ride_date', $travelDate)
                        ->orWhereHas('schedule', function(Builder $query) use ($travelDate, $dayName){
                            $query->where(function(Builder $query) use ($travelDate, $dayName){
                                $query->where('start_date', $travelDate)
                                    ->where($dayName, true);
                            })->orWhere(function(Builder $query) use ($travelDate){
                                $query->where('end_date', '>=', $travelDate)
                                    ->orWhereNull('end_date');
                            });
                        });
                });


            $rides = $rideQuery->with('bus')->get();

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
    public function store(StoreBook $request)
    {
        //
        $validated = $request->validate([
            'ride_id' => 'required|exists:rides,id',
            'start_terminal_id' => 'required|exists:terminals,id',
            'end_terminal_id' => 'required|exists:terminals,id',
            'travel_date' => 'required',
            'pax' => 'nullable|numeric|min:1|max:8'
        ]);

        //Check if seats is still available

        //store to database
        Booking::create([
            'passenger_id' => 17,
            'ride_id' => $request->ride_id,
            'start_terminal_id' => $request->start_terminal_id,
            'end_terminal_id' => $request->end_terminal_id,
            'travel_date' => $request->travel_date,
            'pax' => $request->pax,
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

    public function book(Ride $ride, $start, $end, $travel_date)
    {
        $start_terminal = Terminal::findOrFail($start);
        $end_terminal = Terminal::findOrFail($end);

        return view('bookings.book', ['ride' => $ride,
            'start_terminal' => $start_terminal,
            'end_terminal' => $end_terminal,
            'travel_date' => $travel_date]);
    }
}
