
@extends('layouts.admin')

@section('main-content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                </div>
            @endif
            <div class="card shadow">
                <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Edit</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('admin.buses.index') }}"><i class="fas fa-long-arrow-alt-left"></i></a>
                </div>
                <form method="POST" action="{{ route('admin.buses.update', $bus) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <input type="number" class="form-control @error('bus_no') is-invalid @enderror" value="{{ $bus->bus_no }}" placeholder="Bus No" name="bus_no">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control @error('bus_name') is-invalid @enderror" value="{{ $bus->bus_name }}" placeholder="Bus Name" name="bus_name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control @error('bus_plate') is-invalid @enderror" value="{{ $bus->bus_plate }}" placeholder="Bus Plate" name="bus_plate">
                        </div>
                        <div class="form-group">
                            <select class="form-control @error('bus_class') is-invalid @enderror" name="bus_class_id">
                                <option selected disabled hidden>Select Class</option>
                                @foreach ($bus_classes as $class)
                                    <option value="{{ $class->id }}" {{ $bus->bus_class_id == $class->id ? 'selected' : '' }}>{{ $class->name }} Bus</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control @error('bus_seat') is-invalid @enderror" value="{{ $bus->bus_seat }}" placeholder="Bus Seat" name="bus_seat">
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
