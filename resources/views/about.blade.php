@extends('layouts.admin')

@section('main-content')
<div class="container">

    <div class="row justify-content-center">

        <div class="col-lg-6">

            <div class="card shadow mb-4">

                <div class="card-profile-image mt-4">
                    <img src="{{ asset('img/favicon.png') }}" class="rounded-circle" alt="user-image">
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12 mb-1">
                            <div class="text-center">
                                <h5 class="font-weight-bold">Bus Management Information System</h5>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>

    </div>
</div>
@endsection
