@extends('layouts.admin')

@section('main-content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-12">
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Create</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('bookings.my.bookings') }}"><i class="fas fa-long-arrow-alt-left"></i></a>
                </div>
                    <form method="GET" action="#">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" placeholder="Start Terminal" class="form-control" name="start">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="End Terminal" class="form-control" name="end">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Travel Date" class="form-control datepicker" name="travel_date">
                        </div>
                    </div>
                    <div class="card-footer bg-primary d-flex justify-content-end">
                        <button type="submit" class="btn btn-light btn-sm"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>

        @if($rides->count() > 0)
            <div class="col-md-12 my-5">
                <div class="card shadow">
                    <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-white">Search Result</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Ride</th>
                                        <th>Travel Time</th>
                                        <th>Start Location</th>
                                        <th>End Location</th>
                                        <th>Updated at</th>
                                        <th>State</th>
                                        <th style="width: 130px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($rides as $ride)
                                        <tr>
                                            <td>{{ $ride->route->route_name }}</td>
                                            <td>{{ $ride->departure_time }}</td>
                                            <td>{{ $ride->departure_time }}</td>
                                            <td>{{ $ride->departure_time }}</td>
                                            <td>{{ $ride->updated_at }}</td>
                                            <td>{{ $ride->isActive() ? 'Active' : 'Inactive' }}</td>
                                            <td>{{ $ride->isActive() ? 'Active' : 'Inactive' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td col=7>No Record Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection


@section('scripts')

<script>
    flatpickr('.datepicker', {
        allowInput: false,
        altInput: true,
        altFormat: "F j, Y",
        minDate: 'today',
        position: 'auto left',
        dateFormat: "Y-m-d",
        locale: {
            firstDayOfWeek: 1
        },
    });

</script>
@endsection
