<?php

namespace App\Http\Controllers\Admin;

use App\BusClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bus\BusClassRequest;
use Auth;

class BusClassController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.buses.bus_classes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BusClassRequest $request)
    {
        //
        Auth::user()->busClasses()->create($request->validated());

        return redirect()->route('admin.buses.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BusClass  $busClass
     * @return \Illuminate\Http\Response
     */
    public function edit(BusClass $busClass)
    {
        //
        return view('admin.buses.bus_classes.edit', compact('busClass'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BusClass  $busClass
     * @return \Illuminate\Http\Response
     */
    public function update(BusClassRequest $request, BusClass $busClass)
    {
        //
        $busClass->update($request->validated());

        return redirect()->route('admin.buses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BusClass  $busClass
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusClass $busClass)
    {
        //
    }
}
