@extends('layouts.admin')

@section('main-content')
<div class="container">
    @if (Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
    <div class="row justify-content-center">
        <div class="col-lg-12">
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems.<br><br>
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Details</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('admin.buses.index') }}"><i class="fas fa-long-arrow-alt-left"></i></a>
                </div>
                    <div class="card-body text-center">
                        <dl class="row">
                            <dt class="col-sm-3">Bus No:</dt>
                            <dd class="col-sm-9">{{ $bus->bus_no }}</dd>
                            <dt class="col-sm-3">Bus Plate:</dt>
                            <dd class="col-sm-9">{{ $bus->bus_plate }}</dd>
                            <dt class="col-sm-3">Bus Name:</dt>
                            <dd class="col-sm-9">{{ $bus->bus_name }}</dd>
                            <dt class="col-sm-3">Bus Class:</dt>
                            <dd class="col-sm-9">{{ $bus->busClass->name }}</dd>
                            <dt class="col-sm-3">Bus Seat:</dt>
                            <dd class="col-sm-9">{{ $bus->bus_seat }}</dd>
                            <dt class="col-sm-3">Conductor:</dt>
                            <dd class="col-sm-9">
                                @if ($bus->conductor_id)
                                    {{ $bus->conductor->employeeProfile->full_name }}
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#conductorModal">Re Assign</button>
                                @else
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#conductorModal">Assign</button>
                                @endif
                            </dd>
                            <dt class="col-sm-3">Driver:</dt>
                            <dd class="col-sm-9">
                                @if ($bus->driver_id)
                                    {{ $bus->driver->employeeProfile->full_name }}
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#driverModal">Re Assign</button>
                                @else
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#driverModal">Assign</button>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    @include('admin.buses._modals.conductors', [$conductors, $bus])
    @include('admin.buses._modals.drivers', [$drivers, $bus])
@endsection

