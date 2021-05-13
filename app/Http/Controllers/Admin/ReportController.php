<?php

namespace App\Http\Controllers\Admin;

use App\Arrival;
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
        $terminals = Auth::user()->company()->terminals()->get();

        $departures = Departure::query();

        $arrivals = Arrival::query();

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
                ->whereBetween('time', $arrDate);

            $arrivals->join('terminals', 'terminal_id', 'terminals.id')
                ->where('terminals.company_id', Auth::user()->company()->id)
                ->whereBetween('time', $arrDate)
                ->where('terminal_id', request('terminal'));

            $departures =  $departures->get();
            $arrivals = $arrivals->get();
        }

        return view('admin.reports.depart_arrive', compact('departures', 'arrivals', 'terminals'));
    }
}
