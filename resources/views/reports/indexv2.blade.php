@extends('layout.main')
@section('content')
<div class="main-screen">
    <section class="nav-disk mb-2">
        <ul>
            <li><a href="{{route('reports')}}">Today</a></li>
            <li><a href="{{route('reports',['type'=>'week'])}}">Current Week</a></li>
            <li><a href="{{route('reports',['type'=>'month'])}}">Current Month</a></li>
            <li>
                <form method="GET">
                    <input type="date" name="from" value="{{isset($_GET['from'])?$_GET['from']:''}}" />
                    <input type="date" name="to" value="{{isset($_GET['to'])?$_GET['to']:''}}" />
                    <input type="hidden" name="type" value="custom" />
                    <input type="submit" value="Search" />
                </form>
            </li>
        </ul>
    </section>
    <section class="reports">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>User</th>
                        @foreach($grids as $grid)
                        <th>{{$grid->grid_name}}</th>
                        @endforeach
                        <th>Total Hours</th>
                        <th>Today</th>
                        <th>Overdue</th>
                        <th>Upcomming</th>
                        <th>Completed</th>
                        <th>Stopped</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="{{$user->user_type==2?'table-info':''}}">
                        <td>{{$user->name}}</td>
                        @php
                        $total = 0;
                        @endphp
                        @foreach($grids as $grid)
                            @if(isset($workforceTimers[$user->id]))
                                @if($workforceTimers[$user->id]->where('project_grid_id', $grid->id)->count()>0)
                                    <td>{{$workforceTimers[$user->id]->where('project_grid_id', $grid->id)->first()->hours_spend}}</td>
                                    @php
                                        $total += floatval($workforceTimers[$user->id]->where('project_grid_id', $grid->id)->first()->hours_spend);
                                    @endphp
                                @else
                                <td>0</td>
                                @endif
                            @else
                                <td>0</td>
                            @endif
                        @endforeach
                        <td>{{$total}}</td>
                        <td>
                        <div class="progress">
                            @php
                            $completedToday = $user->completedToday;
                            $totalToday = ($user->today+$completedToday);
                            $percentCompleted = 0;
                            if($completedToday>0){
                                $percentCompleted = ($completedToday/$totalToday)*100;
                            }
                            $tasksLeft = ($totalToday - $completedToday);
                            $percentLeft = (100-$percentCompleted);
                            @endphp
                            <div onclick="gotoTaskList('completedToday',this)" data-href="{{route('user.tasks', $user)}}" class="progress-bar bg-success cursor-pointer" data-toggle="tooltip" data-placement="top" title="{{$completedToday}} Tasks Completed" role="progressbar" style="width: {{$percentCompleted}}%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                            <div onclick="gotoTaskList('today',this)" data-href="{{route('user.tasks', $user)}}" class="progress-bar bg-danger cursor-pointer" role="progressbar" data-toggle="tooltip" data-placement="top" title="{{$tasksLeft}} Tasks Left" role="progressbar" style="width: {{$percentLeft}}%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        </td>
                        <td class="cursor-pointer" onclick="gotoTaskList('overdue',this)" data-href="{{route('user.tasks', $user)}}">{{$user->overdue}}</td>
                        <td class="cursor-pointer" onclick="gotoTaskList('upcomming',this)" data-href="{{route('user.tasks', $user)}}">{{$user->upComming}}</td>
                        <td class="cursor-pointer" onclick="gotoTaskList('completed',this)" data-href="{{route('user.tasks', $user)}}">{{$user->completed}}</td>
                        <td class="cursor-pointer" onclick="gotoTaskList('stopped',this)" data-href="{{route('user.tasks', $user)}}">{{$user->stopped}}</td>
                        <td>
                            <a class="badge bg-info text-body" target="_blank" href="{{route('user.tasks',$user)}}">User Tasks</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
<script>
$(document).ready(function(){        
    $('[data-toggle="tooltip"]').tooltip()
})
function gotoTaskList(type, obj){
    if(type=='completedToday'){
        type = 'completed&start_date={{date('Y-m-d')}}&end_date={{date('Y-m-d')}}'
    }
    let link = $(obj).data('href')+'?type='+type;
    window.open(link, '_blank').focus();
}
</script>
@endpush
@push('css')
<style>
</style>
@endpush