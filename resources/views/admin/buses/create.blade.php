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
                    <a class="btn btn-light btn-sm" href="{{ route('admin.buses.index') }}"><i class="fas fa-long-arrow-alt-left"></i></a>
                </div>
                    <form method="POST" action="{{ route('admin.buses.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <input type="number" class="form-control @error('bus_no') is-invalid @enderror" placeholder="Bus No" name="bus_no">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control @error('bus_plate') is-invalid @enderror" placeholder="Bus Plate" name="bus_plate">
                        </div>
                        <div class="form-group">
                            <select class="form-control @error('bus_class') is-invalid @enderror" name="bus_class">
                            <option disabled selected>Select Class</option>
                            <option value="ordinary">Ordinary Bus</option>
                            <option value="aircon">Regular Airconditioned</option>
                            <option value="deluxe">Deluxe</option>
                            <option value="super">Super Deluxe</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control @error('bus_seat') is-invalid @enderror" placeholder="Bus Seat" name="bus_seat">
                        </div>
                    </div>
                    <div class="card-footer bg-primary d-flex justify-content-end">
                        <button type="submit" class="btn btn-light btn-sm"><i class="fas fa-save"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

