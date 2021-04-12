@extends('layouts.admin')

@section('main-content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Create</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('routes.index') }}"><i class="fas fa-long-arrow-alt-left"></i></a>
                </div>
                <form method="POST" action="{{ route('routes.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control @error('route_name') is-invalid @enderror" placeholder="Route Name" name="route_name">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <select class="form-control destination" name="from">
                                    <option selected disabled>From</option>
                                    @foreach ($terminals as $terminal)
                                        <option value="{{ $terminal->id }}">{{ $terminal->terminal_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-5">
                                <select class="form-control destination" name="to">
                                    <option selected disabled>To</option>
                                    @foreach ($terminals as $terminal)
                                        <option value="{{ $terminal->id }}">{{ $terminal->terminal_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md">
                                <input type="number" placeholder="Total Time" class="form-control" id="total" disabled>
                            </div>
                            <label for="total" class="col-md col-form-label">in min</label>
                        </div>
                    </div>
                    <div class="card rounded-0 bg-primary d-sm-flex align-items-center justify-content-between">
                        <h6 class="mx-0 my-3 font-weight-bold text-white">Via</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-inline mb-3" id="terminal">
                            <select class="form-control col-md-6 mr-3" name="routes[]">
                                    <option selected disabled>Terminals</option>
                                @foreach ($terminals as $terminal)
                                    <option value="{{ $terminal->id }}">{{ $terminal->terminal_name }}</option>
                                @endforeach
                            </select>
                            <input type="number" class="form-control col-md-5 travel" name="travel_time[]" placeholder="Estimated travel time">
                            <div class="col-md text-right">
                                <button type="button" class="btn btn-primary add_terminal"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div id="appends"></div>
                    </div>
                    <div class="card-footer bg-primary d-flex justify-content-end">
                        <button type="submit" class="btn btn-light btn"><i class="fas fa-save"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){

            $('.add_terminal').on('click', function(event){
                event.preventDefault();

                var form = '<div class="form-inline mb-3" id="terminal">\
                                <select class="form-control col-md-6 mr-3" name="routes[]">\
                                        <option selected disabled>Terminals</option>\
                                    @foreach ($terminals as $terminal)\
                                        <option value="{{ $terminal->id }}">{{ $terminal->terminal_name }}</option>\
                                    @endforeach\
                                </select>\
                                <input type="number" class="form-control col-md-5 travel" name="travel_time[]" placeholder="Estimated travel time">\
                                <div class="col-md text-right">\
                                    <button type="button" class="btn btn-primary remove_terminal"><i class="fas fa-minus"></i></button>\
                                </div>\
                            </div>';

                // var terminal = $('#terminal').clone(true);
                // terminal.find('input[name="travel_time[]"]').val('');
                // terminal.find('button').remove();
                // terminal.find('div:last').append(button);
                $('#appends').append(form);
            });

            $(document).on('click', '.remove_terminal', function(event){
                event.preventDefault();
                $(this).closest('div.form-inline').remove();
            });
        });
    </script>

    <script>
        $(document).keyup('.travel', function(e){
            var value = 0;
            $('input[name="travel_time[]"]').each(function(){
                value += +$(this).val();
            })
            $('#total').val(value);
        });
    </script>
@endsection
