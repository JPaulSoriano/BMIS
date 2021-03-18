@extends('layouts.admin')

@section('main-content')
<div class="container">
    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Create</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('buses.index') }}"><i class="fas fa-long-arrow-alt-left"></i></a>
                </div>
                    <form method="POST" action="{{route('buses.store')}}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <input type="number" class="form-control" placeholder="Bus" name="bus_id">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Route" name="route_id">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Departure Time" name="">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Departure Date" name="">
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

