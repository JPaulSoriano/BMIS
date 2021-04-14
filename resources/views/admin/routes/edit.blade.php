
@extends('layouts.admin')

@section('main-content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            <div class="card shadow">
                <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Edit</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('admin.routes.index') }}"><i class="fas fa-long-arrow-alt-left"></i></a>
                </div>
                    <form method="POST" action="{{ route('admin.routes.update', $route) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" value="{{ $route->route_name }}" placeholder="Route Name" name="route_name">
                        </div>
                        <div class="form-row">

                            <div class="form-group col-md">
                                <input type="number" placeholder="Total Time" class="form-control" id="total" disabled>
                            </div>
                            <label for="total" class="col-md-auto col-form-label">in min</label>
                        </div>
                    </div>

                    <div class="card rounded-0 bg-primary d-sm-flex align-items-center justify-content-between">
                        <h6 class="mx-0 my-3 font-weight-bold text-white">Via</h6>
                    </div>
                    <div class="card-body">
                        @foreach ($route->terminals as $item)
                            <div class="form-inline mb-3" id="terminal">
                                <select class="form-control col-md-6 mr-3" name="routes[]">
                                        <option selected disabled>Terminals</option>
                                    @foreach ($terminals as $terminal)
                                        <option value="{{ $terminal->id }}" @if($terminal->id == $item->id) selected @endif>{{ $terminal->terminal_name }}</option>
                                    @endforeach
                                </select>
                                @if($loop->index != 0)
                                    <input type="number" class="form-control col-md-4 travel" name="travel_time[]" placeholder="Estimated travel time" value="{{ $item->pivot->minutes_from_departure }}">
                                @endif
                                <div class="col-md @if($loop->index != 0) route_buttons @endif">
                                    @if($loop->index != 0)
                                        <button type="button" class="btn btn-primary remove_terminal"><i class="fas fa-minus"></i></button>
                                        <button type="button" class="btn btn-primary add_terminal"><i class="fas fa-plus"></i></button>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        @if ($route->terminals->count() < 2)
                        <div class="form-inline mb-3" id="terminal">
                            <select class="form-control col-md-6 mr-3" name="routes[]">
                                    <option selected disabled>Terminals</option>
                                @foreach ($terminals as $terminal)
                                    <option value="{{ $terminal->id }}">{{ $terminal->terminal_name }}</option>
                                @endforeach
                            </select>

                            <input type="number" class="form-control col-md-4 travel" name="travel_time[]" placeholder="Estimated travel time" value="{{ $item->pivot->minutes_from_departure }}">

                            <div class="col-md route_buttons">

                                <button type="button" class="btn btn-primary remove_terminal"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-primary add_terminal"><i class="fas fa-plus"></i></button>

                            </div>
                        </div>
                        @endif


                        <div id="appends"></div>
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

@section('scripts')
<script>
    $(document).ready(function(){

        function getTotalTimeTravel()
        {
            var value = 0;
            $('input[name="travel_time[]"]').each(function(){
                value += +$(this).val();
            })
            $('#total').val(value);
        }

        function changeRouteButtons()
        {
            var size = $('.route_buttons').length;

            if(size > 1){
                $('.route_buttons:not(:last) .add_terminal').attr('hidden', true);
                $('.route_buttons:first .remove_terminal').attr('hidden', false);
                $('.route_buttons:last .add_terminal').attr('hidden', false);
            }else{
                $('.route_buttons:first .add_terminal').attr('hidden', false);
                $('.route_buttons:first .remove_terminal').attr('hidden', true);
            }
        }

        function checkRouteSelect()
            {
                var allSelected = $('select[name="routes[]"]').map(function(){
                    return $(this).val();
                });

                $('select[name="routes[]"]').each(function(){

                    $(this).children('option').each(function(){


                        if(jQuery.inArray($(this).val(), allSelected) !== -1){
                            $(this).attr('hidden', true);
                        }else{
                            $(this).attr('hidden', false);
                        }
                    });
                });

            }

        getTotalTimeTravel();
        changeRouteButtons();
        checkRouteSelect();

        $(document).on('change', 'select[name="routes[]"]', function(event){
            event.preventDefault();
            checkRouteSelect();
        });

        $(document).on('click', '.add_terminal', function(event){
            event.preventDefault();

            var form = '<div class="form-inline mb-3" id="terminal">\
                            <select class="form-control col-md-6 mr-3" name="routes[]">\
                                    <option selected disabled>Terminals</option>\
                                @foreach ($terminals as $terminal)\
                                    <option value="{{ $terminal->id }}">{{ $terminal->terminal_name }}</option>\
                                @endforeach\
                            </select>\
                            <input type="number" class="form-control col-md-4 travel" name="travel_time[]" placeholder="Estimated travel time">\
                            <div class="col-md route_buttons">\
                                <button type="button" class="btn btn-primary remove_terminal"><i class="fas fa-minus"></i></button>\
                                <button type="button" class="btn btn-primary add_terminal"><i class="fas fa-plus"></i></button>\
                            </div>\
                        </div>';
            $('#appends').append(form);
            changeRouteButtons();
            checkRouteSelect();
        });

        $(document).on('click', '.remove_terminal', function(event){
            event.preventDefault();

            if($('.route_buttons').length > 1){
                $(this).closest('div.form-inline').remove();
            }

            getTotalTimeTravel();
            checkRouteSelect();
            changeRouteButtons();
        });

        $(document).keyup('.travel', function(e){
            getTotalTimeTravel();

        });
    });
</script>
@endsection
