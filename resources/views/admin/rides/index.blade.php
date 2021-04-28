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
                <h6 class="m-0 font-weight-bold text-white">Ride Schedules</h6>
                <a class="btn btn-light btn-sm" href="{{ route('admin.rides.create') }}"><i class="fas fa-plus"></i></a>
            </div>
            <div class="card-body">
                <form action="#" method="get">
                    <div class="row ml-auto">
                        <input type="date" class="form-control col-sm-2" name="ride_date">
                        <input type="submit" value="Search" class="btn btn-primary col-sm-auto ml-3">

                    </div>
                </form>

                <div class="table-responsive mt-3">
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
                        <tbody>
                            @foreach ($rides as $ride)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ride->route->route_name }}</td>
                                    <td>{{ $ride->bus->bus_name }}</td>
                                    <td>{{ $ride->departure_time_formatted }}</td>
                                    <td>{{ optional($ride->ride_date)->format('F d, Y') ?? '-' }}</td>
                                    <td>{{ $ride->ride_type }}</td>
                                    <td>{{ $ride->updated_at }}</td>
                                    <td>{{ $ride->isActive() ? 'Active' : 'Inactive' }}</td>
                                    <td class="d-flex justify-content-around">
                                        <a class="btn btn-info btn-sm" href="{{ route('admin.rides.show', $ride) }}"><i class="fas fa-eye"></i></a>
                                        <a class="btn btn-primary btn-sm" href="{{ route('admin.rides.edit', $ride) }}"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.rides.destroy', $ride) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $rides->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

</div>

@endsection
