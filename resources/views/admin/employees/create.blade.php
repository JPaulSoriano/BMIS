@extends('layouts.admin')

@section('main-content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-12">
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>

                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Create</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('admin.employees.index') }}"><i class="fas fa-long-arrow-alt-left"></i></a>
                </div>
                <form action="{{ route('admin.employees.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Username" name="name" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Confirm password" name="password_confirmation">
                        </div>
                    </div>
                    <div class="card rounded-0 bg-primary d-sm-flex align-items-center justify-content-between">
                        <h6 class="mx-0 my-3 font-weight-bold text-white">Employee Profile</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control @error('employee_no') is-invalid @enderror" placeholder="Employee No" name="employee_no" value="{{ old('employee_no') }}">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name" name="first_name" value="{{ old('first_name') }}">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control @error('contact') is-invalid @enderror" placeholder="Contact Number" name="contact" value="{{ old('contact') }}">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control @error('address') is-invalid @enderror" placeholder="Complete Address" name="address" value="{{ old('address') }}">
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
