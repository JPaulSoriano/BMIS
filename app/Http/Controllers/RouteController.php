<?php

namespace App\Http\Controllers;

use App\Route;
use App\Terminal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Route\StoreRoute;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $routes = Route::latest()->paginate(5);

        return view('admin/routes.index',compact('routes'))
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
        $terminals = Terminal::all();
        return view('admin/routes.create', compact('terminals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoute $request)
    {
        //
        foreach($request->routes as $key => $route)
        {
            $routes[$route] = ['order' => $key, 'minutes_from_departure' => $request->travel_time[$key]];
        }

        $route = Auth::user()->routes()->create($request->only(['route_name', 'from', 'to']));
        $route->terminals()->syncWithoutDetaching($routes);

        return redirect()->route('routes.index')
                        ->with('success','Route created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function show(Route $route)
    {
        //
        return view('admin/routes.show',compact('route'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function edit(Route $route)
    {
        //
        $terminals = Terminal::all();
        return view('admin/routes.edit',compact('route', 'terminals'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Route $route)
    {
        //
        $request->validate([
            'route_name' => 'required',

        ]);

        $route->update($request->all());

        return redirect()->route('routes.index')
                        ->with('success','Route updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function destroy(Route $route)
    {
        //
        $route->delete();

        return redirect()->route('routes.index')
                        ->with('success','Route deleted successfully');
    }
}
