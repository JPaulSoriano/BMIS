<?php

namespace App\Http\Controllers\Admin;

use App\Arrival;
use App\User;
use App\Terminal;
use App\Departure;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    //
    public function departureArrival()
    {
        if(Auth::user()->companyProfile->count() == 0)
            return redirect()->route('admin.profile')->withErrors(['error' => 'Provide company profile first']);
            
        $terminals = Auth::user()->company()->terminals()->get();

        $departures = Departure::join('employee_ride', 'employee_ride.id', 'departures.employee_ride_id');

        $arrivals = Arrival::join('employee_ride', 'employee_ride.id', 'arrivals.employee_ride_id');

        if(request('terminal') && request('date'))
        {
            $date = Carbon::createFromFormat( 'Y-m-d',request('date'), 'UTC');
            $arrDate = [
                $date->copy()->startOfDay(),
                $date->copy()->endOfDay(),
            ];

            $departures->join('terminals', 'terminal_id', 'terminals.id')
                ->where('terminals.company_id', Auth::user()->company()->id)
                ->where('terminal_id', request('terminal'))
                ->whereBetween('travel_date', $arrDate);

            $arrivals->join('terminals', 'terminal_id', 'terminals.id')
                ->where('terminals.company_id', Auth::user()->company()->id)
                ->whereBetween('travel_date', $arrDate)
                ->where('terminal_id', request('terminal'));

            $departures =  $departures->get();
            $arrivals = $arrivals->get();
        }

        return view('admin.reports.depart_arrive', compact('departures', 'arrivals', 'terminals'));
    }

    public function employeeList(){


        if(Auth::user()->companyProfile->count() == 0)
            return redirect()->route('admin.profile')->withErrors(['error' => 'Provide company profile first']);

        $employees = User::role(['conductor', 'operation', 'driver'])->with('roles')
            ->whereHas('companyProfile', function($query){
                $query->where('bus_company_profiles.id', Auth::user()->company()->id);
            })
            ->has('employeeProfile')
            ->get();

        return view('admin.reports.employee_list', compact('employees'));
        

    }
    public function busList(){
        if(Auth::user()->companyProfile->count() == 0)
            return redirect()->route('admin.profile')->withErrors(['error' => 'Provide company profile first']);

        $buses = Auth::user()->company()->buses()->latest()->paginate(5);
        $busClasses = Auth::user()->company()->busClasses()->get();

        return view('admin.reports.bus_list',compact('buses', 'busClasses'))
            ->with('i', (request()->input('page', 1) - 1) * 5);

       
    }

}
