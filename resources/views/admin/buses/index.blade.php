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
                    <h6 class="m-0 font-weight-bold text-white">Buses</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('buses.create') }}"><i class="fas fa-plus"></i></a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Bus No</th>
                                    <th>Bus Plate</th>
                                    <th>Bus Class</th>
                                    <th>Bus Seat</th>
                                    <th style="width: 130px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($buses as $bus)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $bus->bus_no }}</td>
                                    <td>{{ $bus->bus_plate }}</td>
                                    <td>{{ $bus->bus_class }}</td>
                                    <td>{{ $bus->bus_seat }}</td>
                                    <td class="d-flex justify-content-around">
                                        <form action="{{ route('buses.destroy',$bus->id) }}" method="POST">

                                            <a class="btn btn-info btn-sm" href="{{ route('buses.show',$bus->id) }}"><i class="fas fa-eye"></i></a>

                                            <a class="btn btn-primary btn-sm" href="{{ route('buses.edit',$bus->id) }}"><i class="fas fa-edit"></i></a>

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
                    {!! $buses->links() !!}
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
