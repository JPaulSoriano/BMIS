@extends('layouts.admin')

@section('main-content')


<div class="container">

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header bg-primary">
                    <h6 class="m-0 font-weight-bold text-white">Dashboard</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <button class="btn btn-info btn-sm select-date" data-target="sub"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
                        <span id="week_no">Week #, Year 2021</span>
                        <button class="btn btn-info btn-sm select-date" data-target="add"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                    </div>
                    <div style="position: relative; height:500px;">
                        <canvas id="chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="row mb-5">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header bg-primary">
                            <h6 class="m-0 font-weight-bold text-white">Today</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <ul class="list-unstyled" id="today">
                                        <li>Rides: <span id="rides_today"></span></li>
                                        <li>Booked: <span id="booked_today"></span></li>
                                        <li>Aboarded: <span id="aboard_today"></span></li>
                                    </ul>
                                </div>
                                <div class="col">
                                    <b>Rides Today</b>
                                    <ul class="list-unstyled" id="rides">
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header bg-primary">
                            <h6 class="m-0 font-weight-bold text-white">Tomorrow</h6>
                        </div>
                        <div class="card-body">
                            <div class="row m-1">

                                <input type="date" class="form-control col">
                                <input type="submit" value="Search" class="btn btn-primary col ml-4">
                            </div>
                            <ul class="list-unstyled">
                                <li>Rides: </li>
                                <li>Booked: </li>
                                <li>Aboarded: </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
$(document).ready(function()
{
    //Charts
    var dates, booked, aboard;
    var today = new Date();

    var url_graph = "{{ url('/admin/graph') }}";
    getData(today);

    $(document).on('click', 'button', function(event){
        var action = $(this).data('target');
        if(action === 'sub'){
            today.setDate(today.getDate() - 7);
        }else if(action === 'add'){
            today.setDate(today.getDate() + 7);
        }
        getData(today);
    });

    function formatDate(date)
    {
        var dd = date.getDate();
        var mm = date.getMonth()+1;
        var yyyy = date.getFullYear();

        if(dd<10)
        {
            dd='0'+dd;
        }
        if(mm<10)
        {
            mm='0'+mm;
        }
        return yyyy+'-'+mm+'-'+dd;
    }

    function getData(d)
    {
        var date = formatDate(d);
        $.ajax({
            url: url_graph,
            data: {date: date},
            beforeSend: function()
            {
                $('.select-date').attr('disabled', true);
            },
            success: function(response)
            {
                var dates = response.dates;
                var booked = response.booked;
                var aboard = response.aboard;
                var week = response.week;
                var year = response.year;

                chart.data.labels = dates;
                chart.data.datasets[0].data = booked;
                chart.data.datasets[1].data = aboard;
                chart.update();
                var text = "Week No. " + week + ", Year " + year;
                $('#week_no').text(text);

                $('.select-date').attr('disabled', false);
            }
        });
    }

    var ctx = document.getElementById('chart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [
                {
                    label: 'Booked',
                    backgroundColor: ['#f21d13'],
                    borderColor: ['#f21d13'],
                },{
                    label: 'Aboard',
                    backgroundColor: ['#123'],
                    borderColor: ['#123'],
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 50,
                    ticks: {
                        callback: function(val, index) {
                            // Hide the label of every 2nd dataset
                            return index % 2 === 0 ? this.getLabelForValue(val) : '';
                        },
                    }
                }
            },
        }
    });

    //Today
    var url_today = "{{ url('admin/todayRides') }}";
    $.ajax({
        url: url_today,
        success: function(response){
            $('#rides_today').text(response.rides_count);
            $('#booked_today').text(response.booked);
            $('#aboard_today').text(response.aboard);

            var output = "";

            if(response.rides.length === 0)
                output = "No rides today";

            jQuery.each(response.rides, function(key,value){
                //console.log(value.route.route_name + " " + value.departure_time);
                output += "<li>" + value.departure_time + " (" + value.route.route_name + ")</li>";
            });
            $('#rides').children().remove();
            $('#rides').append(output);
        }
    })

});
</script>
@endsection
