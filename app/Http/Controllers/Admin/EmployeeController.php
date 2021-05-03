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
        $employees = Auth::user()->companyProfile->employees;
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
        return view('admin.employees.create');
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

        $user = User::create($requestedData->only('name', 'email', 'password')->toArray());
        $user->assignRole('conductor');

        $employeeProfile = $requestedData->except('name', 'email', 'password')->merge(['company_id' => Auth::user()->companyProfile->id])->toArray();

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
        return view('admin.employees.edit', compact('employee'));
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

        $employeeProfile = $requestedData->except('name', 'email', 'password')->merge(['company_id' => Auth::user()->companyProfile->id])->toArray();

        $employee->update($employeeProfile);

        return redirect()->route('admin.employees.index')->withSuccess('Employee created successfully');
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
    }

    public function createTokenForUser(Employee $employee)
    {
        $name = Str::slug($employee->full_name, '-');

        $employee->user->createToken($name);

        return redirect()->route('admin.employees.show', compact('employee'));
    }
}
