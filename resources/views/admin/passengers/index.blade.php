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
                <div class="card-header bg-primary d-sm-flex align-items-center justify-content-start">
                    <h6 class="m-0 font-weight-bold text-white">Passengers</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->passengerProfile->full_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->busPoints->count() > 0 ? $user->busPoints->find(Auth::user()->company()->id)->pivot->points : 0 }}
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

@section('scripts')
<script>
    $('table').DataTable();
</script>
@endsection
