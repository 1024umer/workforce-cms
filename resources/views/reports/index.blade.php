@extends('layout.main')
@section('content')
<div class="main-screen">
    <section class="nav-disk mb-2">
        <ul>
            <li><a href="{{route('reports')}}">Today</a></li>
            <li><a href="{{route('reports',['type'=>'week'])}}">Current Week</a></li>
            <li><a href="{{route('reports',['type'=>'month'])}}">Current Month</a></li>
        </ul>
    </section>
    <section class="reports">
        <div class="row">
            @foreach($workforceTimers as $workforceTimerK=>$workforceTimer)
                <div class="col-md-12 reports-list mb-5">
                    <h2>{{$workforceTimer[0]->name}}</h2>
                    <canvas id="acquisitions{{$workforceTimerK}}"></canvas>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
@push('css')
<style>
.reports {
    background: #fff;
    padding: 40px;
    border-radius: 20px;
}
.reports .reports-list{
    /* max-height: 250px; */
}
</style>
@endpush
@push('js')
<script  src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1/dist/chart.umd.min.js" ></script>
<script>
$(document).ready(function(){
    const labels = [];
    @foreach($taskTypes as $taskTypek=>$taskType)
        labels.push('{{$taskType}}')
    @endforeach
    @foreach($workforceTimers as $workforceTimerK=>$workforceTimer)
        var dataList = [];
        @foreach($taskTypes as $taskTypek=>$taskType)
            @php
            $dataCheck = $workforceTimer->where('project_grid_id', $taskTypek)->first()
            @endphp
            @if($dataCheck)
            dataList.push({{$dataCheck->hours_spend}})
            @else
            dataList.push(0)
            @endif
        @endforeach
        const data{{$workforceTimerK}} = {
            labels: labels,
            datasets: [
                {
                    label: 'Hours Worked',
                    data: dataList, //Utils.numbers({count: 6, min: -100, max: 100}),
                    // borderColor: Utils.CHART_COLORS.red,
                    // backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
                    pointStyle: 'circle',
                    pointRadius: 10,
                    pointHoverRadius: 15
                }
            ]
        };
        new Chart(document.getElementById('acquisitions{{$workforceTimerK}}'), {
            type: 'line',
            data: data{{$workforceTimerK}},
            options: {
                responsive: true,
                // plugins: {
                //     title: {
                //         display: true,
                //         text: (ctx) => 'Point Style: ' + ctx.chart.data.datasets[0].pointStyle,
                //     }
                // }
            }
        });
    @endforeach
})
</script>
@endpush
@push('css')
<style>
</style>
@endpush