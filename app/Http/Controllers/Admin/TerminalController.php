<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Terminal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Terminal\StoreTerminalRequest;
use App\Http\Requests\Terminal\UpdateTerminalRequest;

class TerminalController extends Controller
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
        $terminals = Auth::user()->company()->terminals()->latest()->paginate(5);

        return view('admin.terminals.index',compact('terminals'))
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
        return view('admin.terminals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTerminalRequest $request)
    {
        //
        Auth::user()->company()->terminals()->create($request->validated());

        return redirect()->route('admin.terminals.index')
                        ->with('success','Terminal created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Terminal  $terminal
     * @return \Illuminate\Http\Response
     */
    public function show(Terminal $terminal)
    {
        //
        return view('admin.terminals.show',compact('terminal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Terminal  $terminal
     * @return \Illuminate\Http\Response
     */
    public function edit(Terminal $terminal)
    {
        //
        return view('admin.terminals.edit',compact('terminal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Terminal  $terminal
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTerminalRequest $request, Terminal $terminal)
    {
        //
        $terminal->update($request->validated());

        return redirect()->route('admin.terminals.index')
                        ->with('success','Terminal updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Terminal  $terminal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Terminal $terminal)
    {
        //
        $terminal->delete();

        return redirect()->route('admin.terminals.index')
                        ->with('success','Terminal deleted successfully');
    }
}
