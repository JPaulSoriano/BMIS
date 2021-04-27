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
                    <div class="d-flex justify-content-between mb-5">
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
                            <ul class="list-unstyled">
                                <li>Booked: </li>
                                <li>Rides: </li>
                            </ul>
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
                                <li>Booked: </li>
                                <li>Rides: </li>
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
$(document).ready(function(){

    var dates, booked, aboard;
    var today = new Date();

    var url = "{{ url('/admin/graph') }}";
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
            url: url,
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
                    min: 0,
                }
            },
        }
    });


});
</script>
@endsection
