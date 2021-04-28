@extends('layouts.admin')

@section('main-content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Details</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('admin.rides.index') }}"><i class="fas fa-long-arrow-alt-left"></i></a>
                </div>
                    <div class="card-body text-center">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th scope="row">Id</th>
                                <td>{{ $ride->id }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Route</th>
                                <td>
                                    <a href="{{ route('admin.routes.show', $ride->route) }}">
                                        {{ "{$ride->route->id}. {$ride->route->route_name}" }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Bus Name</th>
                                <td>{{ "{$ride->bus->name} ({$ride->bus->bus_name})" }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Bus Class</th>
                                <td>{{ "{$ride->bus->name} ({$ride->bus->busClass->name})" }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Bus Seats</th>
                                <td>{{ "{$ride->bus->name} ({$ride->bus->bus_seat} seats)" }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Departure time</th>
                                <td>{{ $ride->departure_time_formatted }}</td>
                            </tr>
                            {{-- <tr>
                                <th scope="row">Arrival time</th>
                                <td>{{ $ride->getArrivalTimeToLocation() }}</td>
                            </tr> --}}
                            <tr>
                                <th scope="row">Ride type</th>
                                <td>{{ $ride->ride_date ? 'Single' : 'Cyclic' }}</td>
                            </tr>
                            {{-- <tr>
                                <th scope="row">Active</th>
                                <td>{{ $ride->isActive() ? 'Yes' : 'No' }}</td>
                            </tr> --}}
                            @if($ride->ride_date)
                                <tr>
                                    <th scope="row">Ride date</th>
                                    <td>{{ $ride->ride_date->format('d.m.Y') }}</td>
                                </tr>
                            @else
                                <tr class="bg-light text-center text-uppercase">
                                    <th scope="row" colspan="2">Ride schedule</th>
                                </tr>
                                <tr>
                                    <th scope="row">Start date</th>
                                    <td>{{ $ride->schedule->start_date->format('d.m.Y') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">End date</th>
                                    <td>
                                        {{ $ride->schedule->end_date
                                            ? $ride->schedule->end_date->format('d.m.Y')
                                            : 'Endless'
                                        }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Running days</th>
                                    <td>
                                        <ul class="pl-3">
                                            @forelse($ride->running_days as $day)
                                                <li>{{ $day }}</li>
                                            @empty
                                                No running days
                                            @endforelse
                                        </ul>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

