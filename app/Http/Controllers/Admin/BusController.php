<?php

namespace App\Http\Controllers\Admin;

use App\Bus;
use App\User;
use App\BusClass;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Bus\StoreBusRequest;
use App\Http\Requests\Bus\UpdateBusRequest;

class BusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(Auth::user()->companyProfile->count() == 0)
            return redirect()->route('admin.profile')->withErrors(['error' => 'Provide company profile first']);

        $buses = Auth::user()->company()->buses()->latest()->paginate(5);
        $busClasses = Auth::user()->company()->busClasses()->get();

        return view('admin.buses.index',compact('buses', 'busClasses'))
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
        $bus_classes = Auth::user()->company()->busClasses;

        return view('admin.buses.create', compact('bus_classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBusRequest $request)
    {
        //
        Auth::user()->company()->buses()->create($request->validated());

        return redirect()->route('admin.buses.index')
                        ->with('success','Bus created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function show(Bus $bus)
    {
        //
        $conductors = User::role('conductor')
            ->whereHas('companyProfile', function($query){
                $query->where('bus_company_profiles.id', Auth::user()->company()->id);
            })
            ->get();
        $drivers = User::role('driver')
            ->whereHas('companyProfile', function($query){
                $query->where('bus_company_profiles.id', Auth::user()->company()->id);
            })
            ->get();

        return view('admin.buses.show',compact('bus', 'conductors', 'drivers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function edit(Bus $bus)
    {
        //
        $bus_classes = Auth::user()->company()->busClasses;
        return view('admin.buses.edit',compact('bus', 'bus_classes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBusRequest $request, Bus $bus)
    {

        $bus->update($request->validated());

        return redirect()->route('admin.buses.index')
                        ->with('success','Bus updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bus $bus)
    {
        //
        $bus->delete();

        return redirect()->route('admin.buses.index')
                        ->with('success','Bus deleted successfully');
    }

    public function assignDriver(Request $request, Bus $bus)
    {

        $validator = Validator::make($request->all(), [
            'driver_id' => [
                    'required',
                ],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.buses.show', $bus)
                ->withErrors($validator);
        }

        $bus->driver_id = $request->driver_id;
        $bus->save();

        return redirect()->route('admin.buses.show', $bus)->withSuccess('Assigned driver successfully');
    }

    public function assignConductor(Request $request, Bus $bus)
    {
        $validator = Validator::make($request->all(), [
            'conductor_id' => 'required',
            ]);

        if ($validator->fails()) {
            return redirect()->route('admin.buses.show', $bus)
                ->withErrors($validator);
        }

        $bus->conductor_id = $request->conductor_id;
        $bus->save();

        return redirect()->route('admin.buses.show', $bus)->withSuccess('Assigned conductor successfully');
    }
}
