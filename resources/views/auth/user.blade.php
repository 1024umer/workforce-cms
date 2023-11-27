@extends('layout.main')
@section('content')
<div class="main-screen">
    <div class="edit-profile">
        <div class="row">
            <div class="col-md-4">
                <div class="person-pic">
                    <img src="{{$user->image_url}}" alt="" class="img-responsive" />
                    <h4>{{ucwords($user->name)}}</h4>
                    <span class="ocu">@if($user->user_type==0)
                        Workforce
                        @elseif($user->user_type==1)
                        Admin
                        @elseif($user->user_type==2)
                        Freelancer
                        @endif</span>
                    <a href="mailto:{{$user->email}}" class="mail">{{$user->email}}</a>
                    <a href="{{route('user.tasks',$user)}}" class="btn btn-dark d-block mt-2 rounded-pill">User Tasks</a>
                    <!-- <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-today-tab" data-bs-toggle="tab" data-bs-target="#nav-today" type="button" role="tab" aria-controls="nav-today" aria-selected="true">Today </button>
                            <button class="nav-link" id="nav-upcomming-tab" data-bs-toggle="tab" data-bs-target="#nav-upcomming" type="button" role="tab" aria-controls="nav-upcomming" aria-selected="false">Week </button>
                            <button class="nav-link" id="nav-overdue-tab" data-bs-toggle="tab" data-bs-target="#nav-overdue" type="button" role="tab" aria-controls="nav-overdue" aria-selected="false">Month </button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-today" role="tabpanel" aria-labelledby="nav-today-tab" tabindex="0">
                            <h4>Today </h4>
                            <ul class="proDesc">
                                <li><span>37</span>PROJECTS</li>
                                <li><span>51</span>TASKS</li>
                                <li><span>61</span>UPLOADS</li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="nav-upcomming" role="tabpanel" aria-labelledby="nav-upcomming-tab" tabindex="0">
                            <h4>This Week</h4>
                            <ul class="proDesc">
                                <li><span>37</span>PROJECTS</li>
                                <li><span>51</span>TASKS</li>
                                <li><span>61</span>UPLOADS</li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="nav-overdue" role="tabpanel" aria-labelledby="nav-overdue-tab" tabindex="0">
                            <h4>This Month</h4>
                            <ul class="proDesc">
                                <li><span>37</span>PROJECTS</li>
                                <li><span>51</span>TASKS</li>
                                <li><span>61</span>UPLOADS</li>
                            </ul>
                        </div>
                    </div> -->
                </div>
                @if(auth()->user()->user_type==1||auth()->user()->id==$user->id)
                    <div class="person-pic mt-2 p-2">
                        <h4 class="text-center">Workforce Report</h4>
                        <nav>
                            <div class="nav nav-tabs justify-content-center">
                                <button onclick="getReport('today')" class="nav-link" type="button">Today </button>
                                <button onclick="getReport('week')" class="nav-link" type="button">Week </button>
                                <button onclick="getReport('month')" class="nav-link" type="button">Month </button>
                            </div>
                        </nav>
                        <hr>
                        <canvas height="400px" id="acquisitions{{$user->id}}"></canvas>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <div class="person-info">
                    <h4>About Info</h4>
                    <?php print nl2br(htmlentities($user->bio, ENT_QUOTES, 'UTF-8')); ?>
                    <h4>Interest</h4>
                    <div class="intros myint">
                        <ul>
                            @if($user->favourite_color)
                            <li>
                                <strong><i class="fa-solid fa-droplet"></i> Favourite Color</strong>
                                <span>{{$user->favourite_color}}</span>
                            </li>
                            @endif
                            @if($user->favourite_movie)
                            <li>
                                <strong><i class="fa-solid fa-camera"></i> Favourite Movie</strong>
                                <span>{{$user->favourite_movie}}</span>
                            </li>
                            @endif
                            @if($user->favourite_book)
                            <li>
                                <strong><i class="fa-solid fa-book"></i> Favourite Book</strong>
                                <span>{{$user->favourite_book}}</span>
                            </li>
                            @endif
                            @if($user->favourite_animal)
                            <li>
                                <strong><i class="fa-solid fa-paw"></i> Favourite Animal</strong>
                                <span>{{$user->favourite_animal}}</span>
                            </li>
                            @endif
                            @if($user->favourite_food)
                            <li>
                                <strong><i class="fas fa-hamburger"></i> Favourite Food</strong>
                                <span>{{$user->favourite_food}}</span>
                            </li>
                            @endif
                            @if($user->hobbies)
                            <li>
                                <strong><i class="fas fa-swimming-pool"></i> Hobbies</strong>
                                @foreach(explode(',',$user->hobbies) as $hobby)
                                    <span>{{$hobby}}</span>
                                @endforeach
                            </li>
                            @endif
                            @if($user->dream_vacation)
                            <li>
                                <strong><i class="fas fa-running"></i> Dream Vacation</strong>
                                <span>{{$user->dream_vacation}}</span>
                            </li>
                            @endif
                            @if($user->pet_peeves)
                            <li>
                                <strong><i class="fas fa-dog"></i> Pet Peeves</strong>
                                @foreach(explode(',',$user->pet_peeves) as $petpeeve)
                                    <span>{{$petpeeve}}</span>
                                @endforeach
                            </li>
                            @endif
                            @if($user->biggest_fear)
                            <li>
                                <strong><i class="fas fa-heartbeat"></i> Biggest Fear</strong>
                                <span>{{$user->biggest_fear}}</span>
                            </li>
                            @endif
                            @if($user->superpowers)
                            <li>
                                <strong><i class="fas fa-mask"></i> Super Power</strong>
                                @foreach(explode(',',$user->superpowers) as $superpower)
                                    <span>{{$superpower}}</span>
                                @endforeach
                            </li>
                            @endif
                            @if($user->onewish)
                            <li>
                                <strong><i class="fas fa-hand-holding-heart"></i> One Wish</strong>
                                <span>{{$user->onewish}}</span>
                            </li>
                            @endif
                            @if($user->talent)
                            <li>
                                <strong><i class="fas fa-user-alt"></i> Talent</strong>
                                <span>{{$user->talent}}</span>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
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
function getReport(type){
    window.location.href='{{route('user',$user)}}?type='+type
}
$(document).ready(function(){
    // getReport('today');
})
</script>
@endpush
@push('css')
<style>
</style>
@endpush