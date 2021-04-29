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
                            <label for="route">Route:</label>
                            <input type="text" class="form-control-plaintext" readonly id="route" value="{{ $ride->route->route_name }}">
                        </div>
                        <div class="form-group">
                            <label for="start">Start Terminal:</label>
                            <input type="text" class="form-control-plaintext" readonly id="start" value="{{ $start_terminal->terminal_name }}">
                        </div>
                        <div class="form-group">
                            <label for="end">End Terminal:</label>
                            <input type="text" class="form-control-plaintext" readonly id="end" value="{{ $end_terminal->terminal_name }}">
                        </div>
                        <div class="form-group">
                            <label for="class">Bus Class:</label>
                            <input type="text" class="form-control-plaintext" readonly id="class" value="{{ $ride->bus->busClass->name }}" >
                        </div>
                        <div class="form-group">
                            <label for="payment">Payment:</label>
                            <input type="text" class="form-control-plaintext" readonly id="payment" value="{{ "₱ ".number_format($ride->getTotalPayment($start_terminal->id, $end_terminal->id), 2, '.', ',') }}" >
                        </div>
                        <div class="form-group">
                            <label for="travel_date">Date:</label>
                            <input type="text" class="form-control-plaintext" readonly id="travel_date" value="{{ $travel_date }}" >
                        </div>
                        <div class="form-group">
                            <label for="seats">Available Seats:</label>
                          <input type="text" class="form-control-plaintext" readonly id="seats" value="{{ $available_seats }}">
                        </div>
                        <div class="form-group">
                            <label for="total">Total Payment:</label>
                          <input type="text" class="form-control-plaintext" readonly id="total" value="0">
                        </div>
                        <div class="form-group">
                            <label for="pax">Reserve pax:</label>
                          <input type="number" class="form-control" id="pax" name="pax" placeholder="Pax" min=1 step=1 placeholder=0>
                        </div>
                    </div>
                    <div class="card-footer bg-primary d-flex justify-content-end">
                        <button type="submit" class="btn btn-light btn-sm"><i class="fas fa-save"></i></button>
                    </div>
                    <input type="hidden" name="ride_id" value="{{ $ride->id }}">
                    <input type="hidden" name="start_terminal_id" value="{{ $start_terminal->id }}">
                    <input type="hidden" name="end_terminal_id" value="{{ $end_terminal->id }}">
                    <input type="hidden" name="travel_date" value="{{ $travel_date }}">
                    <input type="hidden" id="pay" value="{{ $ride->getTotalPayment($start_terminal->id, $end_terminal->id) }}">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $(document).on( 'keyup ready', '#pax' ,function(event){
            var pax = $(this).val();
            var pay = $('#pay').val();
            var total = pax * pay;
            $('#total').val("₱ " +total.toFixed(2));
        });
    });
</script>
@endsection
