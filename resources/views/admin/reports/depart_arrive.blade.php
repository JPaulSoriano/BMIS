@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header bg-primary">
                    <h6 class="m-0 font-weight-bold text-white">Reports</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.report.depart.arrive') }}" method="get" id="form">
                        <div class="d-flex">
                            <select name="terminal" class="form-control col-sm-2 mr-2">
                                <option selected hidden disabled>Select Terminal</option>
                                @foreach ($terminals as $terminal)
                                    <option value="{{ $terminal->id }}" @if(request('terminal') == $terminal->id) selected @endif>{{ $terminal->terminal_name }}</option>
                                @endforeach
                            </select>
                            <input type="date" name="date" id="" class="form-control col-sm-2 mr-2" value={{ request('date') ?? null }}>
                            <input type="submit" value="Search" class="btn btn-primary">
                        </div>
                    </form>
                    <h3 class="text-center">{{ Auth::user()->company()->company_name }}</h3>
                    <h3 class="text-center">DAILY RECORDS OF BUS DISPATCHES AND ARRIVAL</h3>
                    <div class="row mt-3">
                        <div class="col">
                            <table id="example" class="table text-center">
                                <thead>
                                    <tr>
                                        <th colspan=7>DEPARTURE</th>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">BUS NO.</th>
                                        <th class="align-middle">TIME</th>
                                        <th class="align-middle">ROUTE</th>
                                        <th class="align-middle">DRIVER</th>
                                        <th class="align-middle">CONDUCTOR</th>
                                        <th class="align-middle">O.R. No.</th>
                                        <th class="align-middle">NO OF PASS</th>
                                    </tr>
                                </thead>
                                <tbody class="small">
                                    @forelse ($departures as $departure)
                                        <tr>
                                            <td>{{ $departure->employeeRide->ride->bus->bus_no }}</td>
                                            <td>{{ $departure->time->format('h:i A')  }}</td>
                                            <td>{{ $departure->employeeRide->ride->route->route_name }}</td>
                                            <td>{{ $departure->employeeRide->driver->employeeProfile->full_name }}</td>
                                            <td>{{ $departure->employeeRide->conductor->employeeProfile->full_name }}</td>
                                            <td>{{ $departure->or_no }}</td>
                                            <td>{{ $departure->totalPassenger() }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan=7>No records</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="col">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th colspan=7>ARRIVAL</th>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">BUS NO.</th>
                                        <th class="align-middle">TIME</th>
                                        <th class="align-middle">ROUTE</th>
                                        <th class="align-middle">DRIVER</th>
                                        <th class="align-middle">CONDUCTOR</th>
                                        <th class="align-middle">O.R. No.</th>
                                        <th class="align-middle">NO OF PASS</th>
                                    </tr>
                                </thead>
                                <tbody class="small">
                                    @forelse ($arrivals as $arrival)
                                        <tr>
                                            <td>{{ $arrival->employeeRide->ride->bus->bus_no }}</td>
                                            <td>{{ $arrival->time->format('h:i A') }}</td>
                                            <td>{{ $arrival->employeeRide->ride->route->route_name }}</td>
                                            <td>{{ $arrival->employeeRide->driver->employeeProfile->full_name }}</td>
                                            <td>{{ $arrival->employeeRide->conductor->employeeProfile->full_name }}</td>
                                            <td>{{ $arrival->or_no }}</td>
                                            <td>{{ $arrival->totalPassenger() }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan=7>No records</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection
