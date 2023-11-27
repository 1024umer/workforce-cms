@extends('layout.main')
@section('content')
<div class="tophead">
    <span class="date">
        <i class="fa-regular fa-calendar"></i> {{date('l, F d')}} &nbsp;&nbsp;
        <i class="fa-regular fa-clock"></i> {{date('h:i a')}} 
    </span>
    <span class="updater">Good morning, <span class="name">{{auth()->user()->name}}</span><i class="fas fa-sun"></i></span>
    <ul>
        <li>
            <a href="javascript:void(0)" type="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                @php
                    $type = 'today';
                    $typeText = 'My Day';
                    if(isset($_GET['type'])){
                        $type = $_GET['type'];
                    }
                    switch ($type) {
                        case "today":
                            $typeText = 'My Day';
                            break;
                        case "week":
                            $typeText = 'My Week';
                            break;
                        case "month":
                            $typeText = 'My Month';
                            break;
                        default:
                            $typeText = 'My Day';
                    }
                @endphp
                {{$typeText}}
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{route('dashboard',['type'=>'day'])}}">My Day</a></li>
                <li><a class="dropdown-item" href="{{route('dashboard',['type'=>'week'])}}">My Week</a></li>
                <li><a class="dropdown-item" href="{{route('dashboard',['type'=>'month'])}}">My Month</a></li>
            </ul>
        </li>
        <li><a href="#"><span class="num rounded-circle">0</span> Tasks Completed</a></li>
        <li><a href="#"><span class="num rounded-circle">{{$hoursWorked}}</span> Hours Worked</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="mypBox">
            <div class="mypBox-header">
                <h3> <img src="{{auth()->user()->image_url}}" class="img-avatar" alt="profile"> My Priorities</h3>
            </div>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-today-tab" data-bs-toggle="tab" data-bs-target="#nav-today" type="button" role="tab" aria-controls="nav-today" aria-selected="true">Today <img src="{{asset('images/happy-emoji.png')}}" alt="" class="icos"></button>
                    <button class="nav-link" id="nav-upcomming-tab" data-bs-toggle="tab" data-bs-target="#nav-upcomming" type="button" role="tab" aria-controls="nav-upcomming" aria-selected="false">Upcoming <img src="{{asset('images/wow-emoji.png')}}" alt="" class="icos"></button>
                    <button class="nav-link" id="nav-overdue-tab" data-bs-toggle="tab" data-bs-target="#nav-overdue" type="button" role="tab" aria-controls="nav-overdue" aria-selected="false">Overdue <img src="{{asset('images/sad-emoji.png')}}" alt="" class="icos"></button>
                    <button class="nav-link" id="nav-completedtoday-tab" data-bs-toggle="tab" data-bs-target="#nav-completedtoday" type="button" role="tab" aria-controls="nav-completedtoday" aria-selected="false">Completed <img src="{{asset('images/love-emoji.png')}}" alt="" class="icos"></button>
                    <button class="nav-link" id="nav-completedstop-tab" data-bs-toggle="tab" data-bs-target="#nav-completedstop" type="button" role="tab" aria-controls="nav-completedstop" aria-selected="false">Stopped <img src="{{asset('images/stop-emoji.png')}}" alt="" class="icos"></button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-today" role="tabpanel" aria-labelledby="nav-today-tab" tabindex="0">
                    <h4>Today Tasks</h4>
                    <ul class="taskList" id="dashboard-today-tasks">
                    </ul>
                </div>
                <div class="tab-pane fade" id="nav-upcomming" role="tabpanel" aria-labelledby="nav-upcomming-tab" tabindex="0">
                    <h4>Upcomming Tasks</h4>
                    <ul class="taskList" id="dashboard-upcomming-tasks">
                    </ul>
                </div>
                <div class="tab-pane fade" id="nav-overdue" role="tabpanel" aria-labelledby="nav-overdue-tab" tabindex="0">
                    <h4>Overdue Tasks</h4>
                    <ul class="taskList" id="dashboard-overdue-tasks">
                    </ul>
                </div> 
                <div class="tab-pane fade" id="nav-completedtoday" role="tabpanel" aria-labelledby="nav-completedtoday-tab" tabindex="0">
                    <h4>Completed Tasks</h4>
                    <ul class="taskList" id="dashboard-completedtoday-tasks">
                    </ul>
                </div> 
                 <div class="tab-pane fade" id="nav-completedstop" role="tabpanel" aria-labelledby="nav-completedstop-tab" tabindex="0">
                    <h4>Stopped Tasks</h4>
                    <ul class="taskList" id="dashboard-completedstop-tasks">
                    </ul>
                </div>                
            </div>
                 
        </div>
        <div class="myProject">
            <h3>My Projects</h3>
            <div class="project-list">
                <div class="row" id="dashboard-myprojects">
                    
                </div>
            </div>
        </div>
        <div class="calender-sec">
        </div>
    </div>
    @include('dashboard.widgets.quotes')
   
    <div class="modal fade" id="birthdayUsersModal" tabindex="-1" aria-labelledby="birthdayUsersModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Birthdays</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="birthdays-ul" id="birthdays-ul">

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
function showBirthday(obj){
    $('#birthdayUsersModal').modal('toggle')
    $('#birthdays-ul').html($(obj).eq(0).children('ul').eq(0).html())
}
</script>
@endpush
@push('css')
<style>
</style>
@endpush