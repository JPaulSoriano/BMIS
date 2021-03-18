<?php

namespace App\Http\Controllers;

use App\Bus;
use Illuminate\Http\Request;

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
        $buses = Bus::latest()->paginate(5);
  
        return view('admin/buses.index',compact('buses'))
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
        return view('admin/buses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'bus_no' => 'required',
            'bus_plate' => 'required',
            'bus_seat' => 'required'
        ]);
  
        Bus::create($request->all());
   
        return redirect()->route('buses.index')
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
        return view('admin/buses.show',compact('bus'));
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
        return view('admin/buses.edit',compact('bus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bus $bus)
    {
        //
        $request->validate([
            'bus_no' => 'required',
            'bus_plate' => 'required',
            'bus_seat' => 'required'
        ]);
  
        $bus->update($request->all());
  
        return redirect()->route('buses.index')
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
  
        return redirect()->route('buses.index')
                        ->with('success','Bus deleted successfully');
    }
}
