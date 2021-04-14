@extends('layouts.admin')

@section('main-content')
<div class="container">
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

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif

    <div class="row">

        <div class="col-lg-4 order-lg-2">

            <div class="card shadow mb-4">
                <div class="card-header bg-primary">
                    <h6 class="m-0 font-weight-bold text-white">Profile</h6>
                </div>
                <div class="card-profile-image mt-4">
                    <figure class="rounded-circle avatar avatar font-weight-bold" style="font-size: 60px; height: 180px; width: 180px;" data-initial="{{ Auth::user()->name[0] }}"></figure>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <h5 class="font-weight-bold">{{  Auth::user()->fullName }}</h5>
                                <p>{{ Auth::user()->getRoleNames()->first() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-8 order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-header bg-primary">
                    <h6 class="m-0 font-weight-bold text-white">Information</h6>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('profile.update') }}" autocomplete="off">
                        @csrf
                        @method('put')

                        <div class="pl-lg-4">


                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="name">User Name<span class="small text-danger">*</span></label>
                                        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Name" value="{{ old('name', Auth::user()->name) }}">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">Email address<span class="small text-danger">*</span></label>
                                        <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="example@example.com" value="{{ old('email', Auth::user()->email) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="current_password">Current password</label>
                                        <input type="password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" placeholder="Current password">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="new_password">New password</label>
                                        <input type="password" id="new_password" class="form-control" name="new_password" placeholder="New password">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="confirm_password">Confirm password</label>
                                        <input type="password" id="confirm_password" class="form-control" name="password_confirmation" placeholder="Confirm password">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-right">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i></button>
                                </div>
                            </div>
                        </div>

                </div>

            </div>

        </div>

    </div>
    <div class="row">

        <div class="col-lg-12">

            <div class="card shadow mb-4">

                <div class="card-header bg-primary">
                    <h6 class="m-0 font-weight-bold text-white">Profile</h6>
                </div>

                <div class="card-body">

                        <div class="pl-lg-4">


                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="company_name">Company Name<span class="small text-danger">*</span></label>
                                        <input type="text" id="name" class="form-control" name="company_name" placeholder="" value="{{ Auth::user()->companyProfile->company_name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="company_address">Company Address<span class="small text-danger">*</span></label>
                                        <input type="text" id="name" class="form-control" name="company_address" placeholder="" value="{{ Auth::user()->companyProfile->company_address }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="company_contact">Company Contact<span class="small text-danger">*</span></label>
                                        <input type="text" id="name" class="form-control" name="company_contact" placeholder="" value="{{ Auth::user()->companyProfile->company_contact }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">

                                    <div class="form-group">
                                        <label class="form-control-label" for="company_mission">Company Mission<span class="small text-danger">*</span></label>
                                        <textarea class="form-control" name="company_mission" id="company_mission" rows="3">{{ Auth::user()->companyProfile->company_mission }}</textarea>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">

                                    <div class="form-group">
                                        <label class="form-control-label" for="company_profile">Company Profile<span class="small text-danger">*</span></label>
                                        <textarea class="form-control" name="company_profile" id="company_profile" rows="3">{{ Auth::user()->companyProfile->company_profile }}</textarea>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection
