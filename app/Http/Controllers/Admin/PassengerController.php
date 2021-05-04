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

        $users = User::role('passenger')
            ->with('passengerProfile')
            ->whereHas('bookings.ride', function($query){
                $query->where('rides.company_id', Auth::user()->company()->id);
            })
            ->paginate(10);


        return view('admin.passengers.index', compact('users'));

    }


}
