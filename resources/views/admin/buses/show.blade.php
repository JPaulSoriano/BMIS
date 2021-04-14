@extends('layouts.admin')

@section('main-content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Details</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('admin.buses.index') }}"><i class="fas fa-long-arrow-alt-left"></i></a>
                </div>
                    <div class="card-body text-center">
                        <div class="row my-5">
                            <div class="col-sm-3">
                               <p>NO:{{ $bus->bus_no }}</p>
                            </div>
                            <div class="col-sm-3">
                                <p>PLATE:{{ $bus->bus_plate }}</p>
                            </div>
                            <div class="col-sm-3">
                                <p>CLASS:{{ $bus->bus_class }}</p>
                            </div>
                            <div class="col-sm-3">
                                <p>SEAT:{{ $bus->bus_seat }}</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

