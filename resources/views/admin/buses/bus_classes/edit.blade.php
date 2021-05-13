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
                    <h6 class="m-0 font-weight-bold text-white">Create Class</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('admin.buses.index') }}"><i class="fas fa-long-arrow-alt-left"></i></a>
                </div>
                    <form method="POST" action="{{ route('admin.bus-classes.update', $busClass) }}">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Class Name" name="name" value="{{ $busClass->name }}">
                        </div>

                        <div class="form-group">
                            <input type="number" class="form-control @error('rate') is-invalid @enderror" placeholder="Rate" name="rate" value="{{ $busClass->rate }}" min=0 step=0.01>
                        </div>
                        @if(Auth::user()->company()->activate_point == 1)
                            <div class="form-group">
                                <input type="number" class="form-control @error('point') is-invalid @enderror" placeholder="Point" name="point" value="{{ $busClass->point }}" min=0 step=0.01>
                            </div>
                        @endif
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

