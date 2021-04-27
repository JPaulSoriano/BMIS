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
        $auth_id = Auth::id();

        $selectedDate = Carbon::parse(request('date'));

        $startDate = $selectedDate->copy()->startOfWeek();
        $endDate = $selectedDate->copy()->endOfWeek();

        $interval = new \DateInterval('P1D');
        $datePeriod = new \DatePeriod($startDate, $interval, $endDate);

        $dateRange = collect($datePeriod)->map(function($date){
            return $date->format('Y-m-d');
        });

        $query = DB::table('bookings')
            ->join('rides', 'ride_id', 'rides.id')
            ->where('rides.user_id', $auth_id);


        foreach($dateRange as $date)
        {
            $booked[] = (clone $query)->where('travel_date', $date)->sum('pax');
            $aboard[] = (clone $query)->where('travel_date', $date)->where('aboard', 1)->sum('pax');
        }

        $date = collect($datePeriod)->map(function($date){
            return $date->format('D');
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

        $today = Carbon::now();
        $dayName = Str::lower($today->dayName);
        $today->format('Y-m-d');

        $rides = Auth::user()->rides()
            ->where(function($query) use ($today){
                $query->where('ride_date', $today);
        })->orWhereHas('schedule', function($query) use ($today, $dayName){
            $query->where($dayName, true)
                ->where(function($query) use ($today, $dayName){
                    $query->where('start_date', '<=' , $today);
                })->where(function($query) use ($today){
                    $query->where('end_date', '>=', $today)
                        ->orWhereNull('end_date');
                });
        });

        return $rides->get();
    }
}
