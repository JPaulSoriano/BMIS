<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PassengerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $users = User::role('passenger')->with('passengerProfile')
        //     ->join('bookings', 'bookings.passenger_id', 'users.id')
        //     ->join('rides', 'rides.id', 'bookings.ride_id')
        //     ->where('rides.company_id', Auth::user()->company()->id)
        //     ->get();
        if (Auth::user()->companyProfile->count() == 0)
            return redirect()->route('admin.profile')->withErrors(['error' => 'Provide company profile first']);

        $users = User::role('passenger')
            ->with('passengerProfile')
            ->whereHas('bookings.ride', function ($query) {
                $query->where('rides.company_id', Auth::user()->company()->id);
            })
            ->get();


        return view('admin.passengers.index', compact('users'));
    }
}
