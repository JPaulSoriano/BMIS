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
        $users = User::role('passenger')
            ->join('bookings', 'bookings.passenger_id', 'users.id')
            ->join('rides', function($join){
                $join->on('rides.id', 'bookings.ride_id');
            })
            ->where('rides.user_id', Auth::user()->id)
            ->select('name', 'email', 'passenger_id')
            ->groupBy('passenger_id', 'name', 'email')
            ->get();

        return view('admin.passengers.index', compact('users'));

    }


}
