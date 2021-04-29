<?php

namespace App\Services;

use App\Ride;

use App\Route;
use App\Booking;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Collection;

class RideService
{
    public function getRidesByTerminals($start, $end, $travelDate, $routes = null) : Collection
    {
        $dayName = Str::lower(Carbon::parse($travelDate)->dayName);

        $startRouteTerminalQuery = DB::table('route_terminal')->where('terminal_id', $start);
        $endRouteTerminalQuery = DB::table('route_terminal')->where('terminal_id', $end);

        //check if route exists
        if(!$routes)
            $routes = $this->getRoutesById($start, $end);

        //check available seats
        $bookingSeatsSubquery = Booking::selectRaw('SUM(pax)')
            ->join('rides as rides_join', 'ride_id', 'rides_join.id')
            ->join('route_terminal as booking_start_terminal',function($join){
                $join->on('rides_join.route_id', 'booking_start_terminal.route_id')
                    ->on('start_terminal_id', 'booking_start_terminal.terminal_id');
            })->join('route_terminal as booking_end_terminal', function($join){
                $join->on('rides_join.route_id', 'booking_end_terminal.route_id')
                    ->on('end_terminal_id', 'booking_end_terminal.terminal_id');
            })->where(function(Builder $query){
                $query->whereRaw('travel_date = ?');
            })->whereColumn([
                ['bookings.ride_id', '=', 'rides.id'],
                ['booking_start_terminal.order', '<', 'end_terminal.order'],
                ['booking_end_terminal.order', '>', 'start_terminal.order'],
            ])->whereRaw("bookings.status = 'confirmed'")
            ->toSql();

        $select = "*, rides.id as ride_id, ($bookingSeatsSubquery) as booked_seats";

        //check if there's available ride
        $ridesQuery = Ride::selectRaw($select, [$travelDate])
            ->joinSub($startRouteTerminalQuery, 'start_terminal', function($join){
                $join->on('rides.route_id', 'start_terminal.route_id');
            })->joinSub($endRouteTerminalQuery, 'end_terminal', function($join){
                $join->on('rides.route_id', 'end_terminal.route_id');
            })->whereHas('route', function(Builder $query) use ($routes){
                $query->whereIn('id', $routes);
            })->where(function(Builder $query) use ($travelDate, $dayName){
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
            });

        $rides = $ridesQuery->with('bus')->get();

        return $rides;
    }

    public function getRoutesById($start, $end) : array
    {
            //check if route exists
            return Route::whereHas('terminals', function (Builder $query) use ($start) {
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
    }

}
