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
                            <select name="start" class="form-control" required>
                                <option selected disabled hidden>Start Terminal</option>
                                @foreach ($terminals as $terminal)
                                    <option value="{{ $terminal->id }}" @if(request('start') == $terminal->id) selected @endif>{{ $terminal->terminal_name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group">
                            <select name="end" class="form-control" required>
                                <option selected disabled hidden>End Terminal</option>
                                @foreach ($terminals as $terminal)
                                    <option value="{{ $terminal->id }}" @if(request('end') == $terminal->id) selected @endif>{{ $terminal->terminal_name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Travel Date" class="form-control datepicker" name="travel_date" required>
                        </div>
                    </div>
                    <div class="card-footer bg-primary d-flex justify-content-end">
                        <button type="submit" class="btn btn-light btn-sm"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>

        @if(request('start'))
            <div class="col-md-12 my-5">
                <div class="card shadow">
                    <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-white">Search Result</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Ride</th>
                                        <th>Bus</th>
                                        <th>Departure time</th>
                                        <th>Departure Date</th>
                                        <th>Start Location</th>
                                        <th>End Location</th>
                                        <th>Seats</th>
                                        <th>Updated at</th>
                                        <th>State</th>
                                        <th style="width: 130px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($rides as $ride)
                                        <tr>
                                            <td>{{ $ride->ride_id }}</td>
                                            <td>{{ $ride->route->route_name }}</td>
                                            <td>{{ $ride->bus->bus_name }}</td>
                                            <td>{{ $ride->departure_time_formatted }}</td>
                                            <td>{{ optional($ride->ride_date)->format('F d, Y') ?? '-' }}</td>
                                            <td>{{ $ride->route->getTerminalNameById(request('start')) }}</td>
                                            <td>{{ $ride->route->getTerminalNameById(request('end')) }}</td>
                                            <td>{{ $ride->bus->bus_seat - $ride->booked_seats }}</td>
                                            <td>{{ $ride->updated_at }}</td>
                                            <td>{{ $ride->isActive() ? 'Active' : 'Inactive' }}</td>
                                            <td>
                                                <a href="{{ route('bookings.book', ['ride' => $ride->ride_id,
                                                    'start' => request('start'),
                                                    'end' => request('end'),
                                                    'travelDate' => request('travel_date')]) }}"
                                                    class="btn btn-sm btn-info">Book</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan=7 class="text-center">No Record Found</td>
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
        allowInput: true,
        altInput: true,
        altFormat: "F j, Y",
        position: 'auto left',
        dateFormat: "Y-m-d",
        minDate: new Date().fp_incr(1),
        locale: {
            firstDayOfWeek: 1
        },
    });

</script>
@endsection
