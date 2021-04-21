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
                    <h6 class="m-0 font-weight-bold text-white">Passenger Bookings</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('bookings.book.create') }}"><i class="fas fa-plus"></i></a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Ride</th>
                                    <th>Passenger</th>
                                    <th>Pax</th>
                                    <th>Travel Date</th>
                                    <th>Start Location</th>
                                    <th>End Location</th>
                                    <th>Updated at</th>
                                    <th>State</th>
                                    <th style="width: 130px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="{{ route('admin.rides.show', $booking->ride) }}">{{ $booking->ride->route->route_name }}</a></td>
                                        <td>{{ $booking->passenger->name }}</td>
                                        <td>{{ $booking->pax }}</td>
                                        <td>{{ $booking->travel_date }}</td>
                                        <td>{{ $booking->startTerminal->terminal_name }}</td>
                                        <td>{{ $booking->endTerminal->terminal_name }}</td>
                                        <td>{{ $booking->updated_at->format('F d, Y h:i:s a') }}</td>
                                        <td>
                                            {{ $booking->status }}
                                            @if($booking->isRejected())
                                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#reasonModal" data-reason="{{ $booking->reason }}"><i class="fa fa-external-link-alt"></i></button>
                                            @endif
                                        </td>
                                        <td class="d-flex justify-content-around">
                                            <a class="btn btn-sm btn-info" href="{{ route('bookings.book.confirm', $booking) }}"><i class="fa fa-check"></i></a>
                                            @if(!$booking->isRejected())
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#rejectModal" data-id="{{ $booking->id }}" data-passenger="{{ $booking->passenger->name }}"><i class="fa fa-times"></i></button>
                                            @endif
                                        </td>
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

@include('bookings._modals.reject')
@include('bookings._modals.reason')
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('#rejectModal').on('show.bs.modal', function(event){

            var button = $(event.relatedTarget);
            var passenger_name = button.data('passenger');
            var id = button.data('id');
            var action = "{{ url('/booking/reject') }}/" + id;

            var modal = $(this);
            modal.find('#passenger_name').val(passenger_name);
            modal.find('form').attr('action', action);
        });

        $('#reasonModal').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);

            $(this).find('#reason_desc').text(button.data("reason"));
        });
    });
</script>
@endsection
