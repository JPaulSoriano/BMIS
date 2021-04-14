@extends('layouts.admin')

@section('main-content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Details</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('admin.terminals.index') }}"><i class="fas fa-long-arrow-alt-left"></i></a>
                </div>
                    <form method="POST" action="{{route('admin.terminals.store')}}">
                    @csrf
                    <div class="card-body text-center">
                        <div class="row my-5">
                            <div class="col-sm-6">
                               <p>NAME: {{ $terminal->terminal_name }}</p>
                            </div>
                            <div class="col-sm-6">
                                <p>ADDRESS: {{ $terminal->terminal_address }}</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

