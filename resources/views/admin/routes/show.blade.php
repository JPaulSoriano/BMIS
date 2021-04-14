@extends('layouts.admin')

@section('main-content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Details</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('routes.index') }}"><i class="fas fa-long-arrow-alt-left"></i></a>
                </div>
                    <form method="POST" action="{{route('routes.store')}}">
                    @csrf
                    <div class="card-body">
                        <div class="row my-5">
                            <div class="col-sm-12">
                               <p>VIA: {{ $route->route_name }}</p>
                            </div>
                        </div>

                        <dl class="row">
                            @foreach ($route->terminals as $terminal)
                                <dt class="col-sm-3">{{ $terminal->terminal_name }}</dt>
                                <dd class="col-sm-9">{{ $terminal->pivot->minutes_from_departure ?? 'Start' }}</dd>
                            @endforeach
                            <dt class="col-sm-3">Total Time Travel</dt>
                            <dd class="col-sm-9">{{ $route->terminals->map->pivot->sum('minutes_from_departure') }}</dd>
                        </dl>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

