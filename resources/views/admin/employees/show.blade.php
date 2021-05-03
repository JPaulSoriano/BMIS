@extends('layouts.admin')

@section('main-content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Show</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('admin.employees.index') }}"><i class="fas fa-long-arrow-alt-left"></i></a>
                </div>
                <dl class="row mt-4 mx-4">
                    <dt class="col-sm-3">User Name</dt>
                    <dd class="col-sm-9">{{ $employee->user->name }}</dd>
                    <dt class="col-sm-3">Email</dt>
                    <dd class="col-sm-9">{{ $employee->user->email }}</dd>
                    <dt class="col-sm-3">Employee No</dt>
                    <dd class="col-sm-9">{{ $employee->employee_no }}</dd>
                    <dt class="col-sm-3">Employee Name</dt>
                    <dd class="col-sm-9">{{ $employee->full_name }}</dd>
                    <dt class="col-sm-3">Address</dt>
                    <dd class="col-sm-9">{{ $employee->address }}</dd>
                    <dt class="col-sm-3">Contact</dt>
                    <dd class="col-sm-9">{{ $employee->contact }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
