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
                            Booked:
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
                                Booked:
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

    var ctx = document.getElementById('chart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'],
            datasets: [
                {
                    label: 'Booked',
                    backgroundColor: ['#f21d13'],
                    borderColor: ['#f21d13'],
                    data: [1, 3, 4, 2, 5, 1, 7]
                },{
                    label: 'Aboard',
                    backgroundColor: ['#123'],
                    borderColor: ['#123'],
                    data: [2, 5, 7, 1, 6, 2, 4]
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Week 5'
                },
            },
        }

    });
</script>
@endsection
