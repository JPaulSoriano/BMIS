<?php

namespace App\Http\Controllers\SuperAdmin;

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

    public function deactivate(User $passenger)
    {
        $passenger->active = 0;
        $passenger->save();

        return redirect()->route('super.passengers');
    }

    public function activate(User $passenger)
    {
        $passenger->active = 1;
        $passenger->save();

        return redirect()->route('super.passengers');
    }
}
