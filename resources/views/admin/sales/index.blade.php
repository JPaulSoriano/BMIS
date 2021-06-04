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
                    <h6 class="m-0 font-weight-bold text-white">Sales Report</h6>

                </div>
                <div class="card-body">
                    {{-- <form action="{{ route('admin.sales.index') }}" method="get"> --}}
                    <div class="row ml-auto">
                        <input type="date" class="form-control col-sm-2" name="first_date" id="first_date">
                        <input type="date" class="form-control col-sm-2 ml-3" name="last_date" id="last_date">
                        <button type="button" class="btn btn-primary col-sm-auto ml-3" id="search">Search</button>
                        <button type="button" class="btn btn-danger col-sm-auto ml-3" id="clear">Clear</button>
                    </div>
                    {{-- </form> --}}
                    <div class="table-responsive mt-3">
                        <table id="example" class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Passenger Name</th>
                                    <th>Payment</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sale->booking->passenger->passengerProfile->full_name }}</td>
                                    <td>{{ "₱ ". number_format($sale->payment, 2, '.', ',') }}</td>
                                    <td>{{ $sale->created_at->format('F d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" style="text-align:right">Total:</th>
                                    <th></th>
                                </tr>
                            </tfoot>
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
    $.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        // var min = parseInt( $('#first_date').val(), 10 );
        // var max = parseInt( $('#last_date').val(), 10 );
        // var age = parseFloat( data[3] ) || 0; // use data for the age column
        var first_date = Date.parse( $('#first_date').val() );
        var last_date = Date.parse( $('#last_date').val() );
        var date = Date.parse( data[3] );

        if ( ( isNaN( first_date ) && isNaN( last_date ) ) ||
             ( isNaN( first_date ) && date <= last_date ) ||
             ( first_date <= date && isNaN( last_date ) ) ||
             ( first_date <= date && date <= last_date ) )
        {
            return true;
        }
        return false;
    }
);

    $(document).ready(function() {
        var table = $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\₱ ,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total = api
                    .column( 2 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Total over this page
                pageTotal = api
                    .column( 2, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Update footer
                $( api.column( 3 ).footer() ).html(
                    '₱ '+pageTotal +' ( ₱ '+ total +' total)'
                );
            }
        } );

        $('#search').click(function(event){
            event.preventDefault();
            table.draw();
        });

        $('#clear').click(function(event){
            event.preventDefault();
            $('#first_date').val('');
            $('#last_date').val('')
        });
    } );
</script>
@endsection
