@extends('layouts.admin')

@section('main-content')
<div class="container">
    @if (Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
    <div class="row justify-content-center">
        <div class="col-lg-12">
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems.<br><br>
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Details</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('admin.buses.index') }}"><i class="fas fa-long-arrow-alt-left"></i></a>
                </div>
                <div class="card-body text-center">
                    <dl class="row">
                        <dt class="col-sm-3">Bus Class:</dt>
                        <dd class="col-sm-9">{{ $busClass->name }}</dd>
                        <dt class="col-sm-3">Rate per 5km:</dt>
                        <dd class="col-sm-9">{{ $busClass->rate }}</dd>
                        <dt class="col-sm-3">Flat Rate:</dt>
                        <dd class="col-sm-9">{{ $busClass->flat_rate }}</dd>
                        @if ($busClass->company->activate_point == 1)
                            <dt class="col-sm-3">Bus Point per 10km:</dt>
                            <dd class="col-sm-9">{{ $busClass->point }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
