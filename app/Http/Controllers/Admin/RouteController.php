<?php

namespace App\Http\Controllers\Admin;

use App\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Route\StoreRouteRequest;
use App\Http\Requests\Route\UpdateRouteRequest;

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
        $routes = Auth::user()->routes()->latest()->paginate(10);

        return view('admin.routes.index',compact('routes'))
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
        $terminals = Auth::user()->terminals;
        return view('admin.routes.create', compact('terminals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRouteRequest $request)
    {
        //

        foreach($request->routes as $key => $route)
        {
            $routes[$route] = [
                'order' => $key,
                'minutes_from_departure' => $request->travel_time[$key - 1] ?? null,
                'distance_from_departure' => $request->distance[$key - 1] ?? null,
            ];
        }


        $route = Auth::user()->companyProfile->routes()->create($request->only(['route_name']));
        $route->terminals()->attach($routes);

        return redirect()->route('admin.routes.index')
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
        return view('admin.routes.show',compact('route'));
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
        $terminals = Auth::user()->terminals;
        return view('admin.routes.edit',compact('route', 'terminals'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRouteRequest $request, Route $route)
    {

        foreach($request->routes as $key => $r)
        {
            $routes[$r] = [
                'order' => $key,
                'minutes_from_departure' => $request->travel_time[$key - 1] ?? null,
                'distance_from_departure' => $request->distance[$key - 1]  ?? null
            ];
        }

        $route->update($request->only(['route_name']));
        $route->terminals()->detach();
        $route->terminals()->attach($routes);

        return redirect()->route('admin.routes.index')
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

        return redirect()->route('admin.routes.index')
                        ->with('success','Route deleted successfully');
    }
}
