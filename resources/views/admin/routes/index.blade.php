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
                <h6 class="m-0 font-weight-bold text-white">Routes</h6>
                <a class="btn btn-light btn-sm" href="{{ route('admin.routes.create') }}"><i class="fas fa-plus"></i></a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Via</th>
                                <th>Total Time Travel</th>
                                <th style="width: 130px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($routes as $route)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $route->route_name }}</td>
                                <td>{{ $route->total_time }}</td>
                                <td class="d-flex justify-content-around">

                                    <a class="btn btn-info btn-sm" href="{{ route('admin.routes.show',$route->id) }}"><i class="fas fa-eye"></i></a>

                                    <a class="btn btn-primary btn-sm" href="{{ route('admin.routes.edit',$route->id) }}"><i class="fas fa-edit"></i></a>

                                    <form action="{{ route('admin.routes.destroy',$route->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $routes->links() !!}
            </div>
        </div>
    </div>
</div>

</div>

@endsection
