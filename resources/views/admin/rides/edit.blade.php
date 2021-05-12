@extends('layouts.admin')

@section('main-content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Create</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('admin.rides.index') }}"><i class="fas fa-long-arrow-alt-left"></i></a>
                </div>
                    <form method="POST" action="{{route('admin.rides.update', $ride)}}">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="form-group">
                            <select name="bus_id" class="form-control @error('bus_id') is-invalid @enderror">
                                <option selected hidden>Bus</option>
                                @foreach ($buses as $bus)
                                    <option value="{{ $bus->id }}" @if($bus->id == $ride->bus->id) selected @endif>{{ $bus->bus_no }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="route_id" class="form-control @error('route_id') is-invalid @enderror">
                                <option selected hidden>Route</option>
                                @foreach ($routes as $route)
                                    <option value="{{ $route->id }}" @if($route->id == $ride->route->id) selected @endif>{{ $route->route_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group row">
                            <input type="text" class="form-control col-md mx-3 @error('departure_time') is-invalid @enderror" placeholder="Departure Time" id="departure_time" name="departure_time" value="{{ $ride->departure_time_formatted }}">
                        </div>

                        <div class="form-group text-center mt-4">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio" name="ride_type"
                                       id="ride-type-single"
                                       value="single" {{ (! $ride->isCyclic() && ! old('ride_type'))
                                                            || old('ride_type') == 'single' ? "checked" : "" }}>
                                <label class="custom-control-label" for="ride-type-single">
                                    Single ride
                                </label>
                            </div>

                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio" name="ride_type"
                                       id="ride-type-cyclic"
                                       value="cyclic" {{ ($ride->isCyclic() && ! old('ride_type'))
                                                            || old('ride_type') == 'cyclic' ? "checked" : "" }}>
                                <label class="custom-control-label" for="ride-type-cyclic">
                                    Cyclic ride
                                </label>
                            </div>

                            @error('ride_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div id="singleRideInputsWrapper"
                             style="display: {{ ($ride->isCyclic() && ! old('ride_type'))
                                                || old('ride_type') == 'cyclic' ? "none" : "block" }}">
                            <div class="form-group">
                                <label for="ride-date">Ride date</label>
                                <input type="date" name="ride_date" id="ride-date" required
                                       class="form-control @error('ride_date') is-invalid @enderror datepicker"
                                       value="{{ old('ride_date', $ride->ride_date ? $ride->ride_date_formatted->format('Y-m-d') : '') }}"
                                    {{ ($ride->isCyclic() && ! old('ride_type'))
                                        || old('ride_type') == 'cyclic' ? "disabled" : "" }}>

                                @error('ride_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div id="cyclicRideInputsWrapper"
                             style="display: {{ (! $ride->isCyclic() && ! old('ride_type'))
                                                || old('ride_type') == 'single' ? "none" : "block" }}">
                            <div class="form-group">
                                @foreach($days as $day)
                                    <div class="custom-control custom-switch">
                                        <input class="custom-control-input day-checkbox" type="checkbox"
                                               name="days[{{ $day }}]" value="1" id="{{ $day }}"
                                            {{ (! $ride->isCyclic() && ! old('ride_type'))
                                                || old('ride_type') == 'single' ? "disabled" : "" }}
                                            {{  ($ride->schedule && $ride->schedule->$day && ! old('ride_type'))
                                                || isset(old('days')[$day]) ? "checked" : "" }}>

                                        <label class="custom-control-label" for="{{ $day }}">
                                            {{ ucfirst($day) }}
                                        </label>
                                    </div>
                                @endforeach

                                @error('days')
                                    <span class="invalid-feedback" style="display: block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="start-date">Start date</label>
                                <input type="date" name="start_date" id="start-date" required
                                       class="form-control @error('start_date') is-invalid @enderror datepicker"
                                       value="{{ old('start_date',
                                                    isset($ride->schedule->start_date) ? $ride->schedule->start_date->format('Y-m-d') : '') }}"
                                    {{ (! $ride->isCyclic() && ! old('ride_type'))
                                        || old('ride_type') == 'single' ? "disabled" : "" }}>

                                @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="end-date">End date</label>
                                <input type="date" name="end_date" id="end-date"
                                       class="form-control @error('end_date') is-invalid @enderror datepicker"
                                       value="{{ old('end_date', isset($ride->schedule->end_date) ? $ride->schedule->end_date->format('Y-m-d') : '') }}"
                                    {{ (! $ride->isCyclic() && ! old('ride_type'))
                                        || old('ride_type') == 'single' ? "disabled" : "" }}>
                                <small class="form-text text-muted">
                                    Leave blank to make the ride cycle endless
                                </small>

                                @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
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
    flatpickr('.datepicker', {
        allowInput: false,
        altInput: true,
        altFormat: "F j, Y",
        minDate: 'today',
        position: 'auto left',
        dateFormat: "Y-m-d",
        locale: {
            firstDayOfWeek: 1
        },
    });

    flatpickr('#departure_time', {
        altInput: true,
        altFormat: "h:i K",
        allowInput: false,
        noCalendar: true,
        enableTime: true,
        dateFormat: "H:i",
        position: 'auto left',
    });

    $(document).on('click', 'input[name="ride_type"]', function(){

        var single = $('#singleRideInputsWrapper');
        var cyclic = $('#cyclicRideInputsWrapper');

        if($(this).val() == "single"){
            single.css('display', 'block');
            single.find('input').attr('disabled', false);

            cyclic.css('display', 'none');
            cyclic.find('input').attr('disabled', true);
        }

        if($(this).val() == "cyclic"){
            single.css('display', 'none');
            single.find('input').attr('disabled', true);

            cyclic.css('display', 'block');
            cyclic.find('input').attr('disabled', false);
        }
    });
</script>
@endsection
