<?php

namespace App\Http\Controllers\superAdmin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

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
        $users = User::role('passenger')->get();

        return view('superadmin.passengers.index', compact('users'));
    }

}
