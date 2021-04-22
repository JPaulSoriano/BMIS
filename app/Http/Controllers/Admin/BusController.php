<?php

namespace App\Http\Controllers\Admin;

use App\Bus;
use App\BusClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bus\StoreBusRequest;
use App\Http\Requests\Bus\UpdateBusRequest;
use Illuminate\Support\Facades\Auth;

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
        $buses = Auth::user()->buses()->latest()->paginate(5);

        return view('admin.buses.index',compact('buses'))
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
        $bus_classes = BusClass::all();
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
        Auth::user()->buses()->create($request->validated());

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

        return view('admin.buses.show',compact('bus'));
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
        $bus_classes = BusClass::all();
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
}
