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
                    <h6 class="m-0 font-weight-bold text-white">Book</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('bookings.book.create') }}"><i class="fas fa-long-arrow-alt-left"></i></a>
                </div>
                <form method="POST" action="{{ route('bookings.book.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control-plaintext" readonly value="{{ $ride->route->route_name }}">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control-plaintext" readonly value="{{ $start_terminal->terminal_name }}">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control-plaintext" readonly value="{{ $end_terminal->terminal_name }}">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Travel Date" class="form-control" name="travel_date" value="{{ $travel_date }}" readonly>
                        </div>
                        <div class="form-group">
                          <input type="number" class="form-control" name="pax" placeholder="Pax" min=0 step=1>
                        </div>
                    </div>
                    <div class="card-footer bg-primary d-flex justify-content-end">
                        <button type="submit" class="btn btn-light btn-sm"><i class="fas fa-save"></i></button>
                    </div>
                    <input type="hidden" name="ride_id" value="{{ $ride->id }}">
                    <input type="hidden" name="start_terminal_id" value="{{ $start_terminal->id }}">
                    <input type="hidden" name="end_terminal_id" value="{{ $end_terminal->id }}">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
