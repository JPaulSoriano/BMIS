@extends('layouts.admin')

@section('main-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
        @endif
            <div class="card shadow mb-4">
                <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Users</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('super.users.create') }}"><i class="fas fa-plus"></i></a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th style="width: 130px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->active }}</td>
                                        <td class="d-flex justify-content-around">
                                            <a class="btn btn-info btn-sm" href="{{ route('super.users.show', $user) }}"><i class="fas fa-eye"></i></a>
                                            <a class="btn btn-primary btn-sm" href="{{ route('super.users.edit', $user) }}"><i class="fas fa-edit"></i></a>
                                            @if($user->active == 1)
                                                <a class="btn btn-danger btn-sm" href="{{ route('super.users.deactivate', $user) }}"><i class="fas fa-trash-alt"></i></a>
                                            @else
                                                <a class="btn btn-success btn-sm" href="{{ route('super.users.activate', $user) }}"><i class="fas fa-undo"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
