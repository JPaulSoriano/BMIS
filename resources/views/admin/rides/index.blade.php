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
                <h6 class="m-0 font-weight-bold text-white">Schedules</h6>
                <a class="btn btn-light btn-sm" href="{{ route('rides.create') }}"><i class="fas fa-plus"></i></a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Route</th>
                                <th>Bus</th>
                                <th>Departure Time</th>
                                <th>Ride date</th>
                                <th>Ride type</th>
                                <th>Updated at</th>
                                <th>State</th>
                                <th style="width: 130px">Action</th>
                            </tr>
                        </thead>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

</div>

@endsection
