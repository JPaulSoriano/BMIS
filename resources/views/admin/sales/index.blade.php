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
                <h6 class="m-0 font-weight-bold text-white">Sales</h6>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.sales.index') }}" method="get">
                    <div class="row ml-auto">
                        <input type="date" class="form-control col-sm-2" name="date">
                        <input type="submit" value="Search" class="btn btn-primary col-sm-auto ml-3">

                    </div>
                </form>
                <div class="table-responsive mt-3">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Passenger Name</th>
                                <th>Payment</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sale->booking->passenger->passengerProfile->full_name }}</td>
                                    <td>{{ "₱ ". number_format($sale->payment, 2, '.', ',') }}</td>
                                    <td>{{ $sale->created_at }}</td>
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

@endsection
