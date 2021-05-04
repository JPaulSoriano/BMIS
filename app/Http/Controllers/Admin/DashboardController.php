<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Str;

class DashboardController extends Controller
{
    //
    public function index()
    {
        return view('admin.dashboard');
    }

    public function graph()
    {
        $company_id = Auth::user()->company()->id;

        $selectedDate = Carbon::parse(request('date'));

        $startDate = $selectedDate->copy()->startOfWeek();
        $endDate = $selectedDate->copy()->endOfWeek();

        $interval = new \DateInterval('P1D');
        $datePeriod = collect(new \DatePeriod($startDate, $interval, $endDate));

        $query = DB::table('bookings')
            ->join('rides', 'ride_id', 'rides.id')
            ->where('rides.company_id', $company_id);


        foreach($datePeriod as $date)
        {
            $booked[] = (clone $query)->where('travel_date', $date->format('Y-m-d'))->sum('pax');
            $aboard[] = (clone $query)->where('travel_date', $date->format('Y-m-d'))->where('aboard', 1)->sum('pax');
        }

        $date = $datePeriod->map(function($date){
            return $date->format('D, F d');
        });

        return response()->json([
            'dates' => $date,
            'booked' => $booked,
            'aboard' => $aboard,
            'week' => $selectedDate->weekOfYear,
            'year' => $selectedDate->year,
        ]);
    }

    public function todayRides()
    {

        $company_id = Auth::user()->company()->id;

        $today = Carbon::now();
        $dayName = Str::lower($today->dayName);
        $today = $today->format('Y-m-d');

        $rides = Auth::user()->company()->rides()
            ->where(function($query) use ($today){
                $query->where('ride_date', $today);
            })
            ->orWhereHas('schedule', function($query) use ($today, $dayName){
                $query->where($dayName, true)
                    ->where(function($query) use ($today){
                        $query->where('start_date', '<=' , $today);
                    })->where(function($query) use ($today){
                        $query->where('end_date', '>=', $today)
                            ->orWhereNull('end_date');
                    });
            })
            ->with('route')
            ->orderBy('departure_time')
            ->get();

        $query = DB::table('bookings')
            ->join('rides', 'ride_id', 'rides.id')
            ->where('rides.company_id', $company_id);

        $booked = (clone $query)->where('travel_date', $today)->sum('pax');
        //$booked = (clone $query)->sum('pax');
        $aboard = (clone $query)->where('travel_date', $today)->where('aboard', 1)->sum('pax');

        return response()->json([
            'rides_count' => $rides->count(),
            'rides' => $rides,
            'booked' => $booked,
            'aboard' => $aboard,
        ]);
    }

}
