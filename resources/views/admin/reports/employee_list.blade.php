@extends('layouts.admin')

@section('main-content')


<div class="container">

<div class="row justify-content-center">
    <div class="col-lg-12">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        {{ $message }}
    </div>
    @endif
        <div class="card shadow mb-4">
            <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-white">Employees</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" lass="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Employee No</th>
                                <th>Full Name</th>
                                <th>Role</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $employee->employeeProfile->employee_no }}</td>
                                    <td>{{ $employee->employeeProfile->full_name }}</td>
                                    <td>{{ $employee->roles->first()->name }}</td>
                
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

@endsection
