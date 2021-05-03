<?php

namespace App\Services;

use App\Ride;
use App\Booking;
use App\Terminal;
use Illuminate\Database\Eloquent\Builder;

class BookingService
{

    public function getOccupiedSeats(Ride $ride, $start, $end, $travelDate) : int
    {
        $startTerminal = $ride->route->terminals->where('id', $start)->first();
        $endTerminal = $ride->route->terminals->where('id', $end)->first();

        return Booking::join('rides', 'rides.id', 'ride_id')
            ->join('route_terminal as start_terminal', function($join){
                $join->on('rides.route_id', 'start_terminal.route_id')
                    ->on('start_terminal_id', 'start_terminal.terminal_id');
            })->join('route_terminal as end_terminal', function($join){
                $join->on('rides.route_id', 'end_terminal.route_id')
                    ->on('end_terminal_id', 'end_terminal.terminal_id');
            })->where([
                ['ride_id', '=', $ride->id],
                ['start_terminal.order', '<', $endTerminal->pivot->order],
                ['end_terminal.order', '>', $startTerminal->pivot->order],
            ])->where(function(Builder $query) use ($travelDate){
                $query->where('travel_date', $travelDate);
            })->whereRaw("bookings.status = 'confirmed'")
            ->sum('pax');
    }



}
