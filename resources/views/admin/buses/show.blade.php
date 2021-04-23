@extends('layouts.admin')

@section('main-content')
<div class="container">

    <div class="row justify-content-center">
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
                        </dl>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

