<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    //
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $employees = User::role(['conductor', 'operation', 'driver'])->with('roles')
            ->whereHas('companyProfile', function($query){
                $query->where('bus_company_profiles.id', Auth::user()->company()->id);
            })
            ->has('employeeProfile')
            ->get();
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::whereNotIn('name', ['superadmin', 'admin', 'passenger'])->get();
        return view('admin.employees.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        //
        $requestedData = collect($request->validated());

        $user = User::create($requestedData->only('name', 'email', 'password')->merge(['email_verified_at', now()])->toArray());
        $user->assignRole($request->role);
        $user->companyProfile()->attach(Auth::user()->company());

        $employeeProfile = $requestedData->except('name', 'email', 'password')->toArray();

        $user->employeeProfile()->create($employeeProfile);


        return redirect()->route('admin.employees.index')->withSuccess('Employee created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //

        $roles = Role::whereNotIn('name', ['superadmin', 'admin', 'passenger'])->get();
        return view('admin.employees.edit', compact('employee', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        //
        $requestedData = collect($request->validated());

        $employee->user->update($requestedData->only('name', 'email', 'password')->toArray());
        $employee->user->assignRole($request->role);
        $employeeProfile = $requestedData->except('name', 'email', 'password')->toArray();

        $employee->update($employeeProfile);

        return redirect()->route('admin.employees.index')->withSuccess('Employee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
        $employee->user->removeRole($employee->user->roles->first());
        $employee->user->companyProfile()->detach($employee->user->company());
        $employee->user->delete();
        $employee->delete();

        return redirect()->route('admin.employees.index')->withSuccess('Employee deleted successfully');

    }

    public function createTokenForUser(Employee $employee)
    {
        $name = Str::slug($employee->full_name, '-');

        $employee->user->createToken($name);

        return redirect()->route('admin.employees.show', compact('employee'));
    }
}
