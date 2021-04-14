<?php

namespace App\Http\Controllers\Admin;


use App\Ride;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Ride\StoreRide;
use App\Http\Requests\Ride\UpdateRide;

class RideController extends Controller
{
    private $dayNames = [
        'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $rides = Auth::user()->rides()->latest()->paginate(5);

        return view('admin.rides.index',compact('rides'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $buses = Auth::user()->buses;
        $routes = Auth::user()->routes;
        $days = $this->dayNames;
        return view('admin.rides.create', compact('buses', 'routes', 'days'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRide $request)
    {
        //

        $ride = Auth::user()->rides()->create($request->validated());

        if ($request->ride_type == 'cyclic') {
            $requestData = collect($request->validated());
            $rideScheduleData = $requestData
                ->only('start_date', 'end_date')
                ->merge($requestData->get('days'))
                ->toArray();

            $ride->schedule()->create($rideScheduleData);
        }

        return redirect()->route('admin.rides.index')->withSuccess('Ride created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ride  $ride
     * @return \Illuminate\Http\Response
     */
    public function show(Ride $ride)
    {
        //
        return view('admin.rides.show', compact('ride'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ride  $ride
     * @return \Illuminate\Http\Response
     */
    public function edit(Ride $ride)
    {
        //
        $buses = Auth::user()->buses;
        $routes = Auth::user()->routes;
        $days = $this->dayNames;
        return view('admin.rides.edit', compact('buses', 'routes', 'days', 'ride'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ride  $ride
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRide $request, Ride $ride)
    {
        //
        if ($request->ride_type == 'cyclic') {
            $rideData = array_merge($request->validated(), ['ride_date' => null]);
            $requestData = collect($request->validated());
            $days = collect($this->dayNames)
                ->mapWithKeys(fn($item) => [$item => 0])
                ->replace($requestData->get('days'));

            $rideScheduleData = $requestData
                ->only('start_date', 'end_date')
                ->merge($days)
                ->toArray();

            $ride->update($rideData);
            $ride->schedule()->updateOrCreate(['ride_id' => $ride->id], $rideScheduleData);
        } else {
            $ride->update($request->validated());
            $ride->schedule()->delete();
        }

        return redirect()->route('admin.rides.index')
            ->withSuccess('The ride has been successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ride  $ride
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ride $ride)
    {
        //
        $ride->schedule()->delete();

        $ride->delete();

        return redirect()->route('admin.rides.index')->withSuccess('Ride deleted successfully');
    }
}
