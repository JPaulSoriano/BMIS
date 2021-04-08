@extends('layouts.admin')

@section('main-content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">User Details</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('users.index') }}"><i class="fas fa-long-arrow-alt-left"></i></a>
                </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-3">User</dt>
                            <dd class="col-sm-9">{{ $user->name }}</dd>
                            <dt class="col-sm-3">Email</dt>
                            <dd class="col-sm-9">{{ $user->email }}</dd>
                            <dt class="col-sm-3">Email Verified</dt>
                            <dd class="col-sm-9">{{ $user->email_verified_at }}</dd>
                            <dt class="col-sm-3">Active</dt>
                            <dd class="col-sm-9">{{ $user->active }}</dd>
                        </dl>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

