@extends('layouts.admin')

@section('main-content')


<div class="container">
    @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif
    <div class="row justify-content-center">

        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Buses</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Bus No</th>
                                    <th>Bus Name</th>
                                    <th>Bus Plate</th>
                                    <th>Bus Class</th>
                                    <th>Bus Seat</th>

                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($buses as $bus)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $bus->bus_no }}</td>
                                    <td>{{ $bus->bus_name }}</td>
                                    <td>{{ $bus->bus_plate }}</td>
                                    <td>{{ $bus->busClass->name }}</td>
                                    <td>{{ $bus->bus_seat }}</td>

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

@section('scripts')
<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    } );
    </script>
@endsection
