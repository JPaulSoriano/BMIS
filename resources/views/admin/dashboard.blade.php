@extends('layouts.admin')

@section('main-content')


<div class="container">

    <h1>Dashboard</h1>
    <div style="position: relative; height:50vh; width:60vw">
        <canvas id="chart"></canvas>
    </div>
</div>

@endsection

@section('scripts')
<script>

    var ctx = document.getElementById('chart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',

        // The data for our dataset
        data: {
            labels: ['monday'],
            datasets: [{
                label: 'Number of Students',
                data: [1]
            }]
        },

    });
</script>
@endsection
