@extends('layout.main')
@section('content')
<div class="main-screen">
    <section class="board-list">
        <div class="row">
            <div class="col-md-3">
                <div class="boxes">
                    <h3>Today <img src="{{asset('images/happy-emoji.png')}}" alt="" class="icos"></h3>
                    <ul>
                        @foreach($today as $todayTask)
                            <li>
                                <a href="javascript:void(0);"  onclick="openTaskModal({{$todayTask->id}}, {{$todayTask->project_id}})">
                                    <p>{{$todayTask->title}}</p>
                                    @include('project.widgets.priority', [
                                        'task' => $todayTask
                                    ])
                                    <div class="progress">
                                        @php
                                            $totalSubTasks = $todayTask->subtasks()->count();
                                        @endphp
                                        @if($totalSubTasks==0)
                                            @if($todayTask->is_completed==1)
                                                <div class="progress-bar bg-primary" role="progressbar" aria-label="Example with label" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                            @else
                                                <div class="progress-bar bg-primary" role="progressbar" aria-label="Example with label" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                            @endif
                                        @else
                                            @php
                                                $notCompleted = $todayTask->subtasks()->where('is_completed', 0)->count();
                                                $isCompleted = $todayTask->subtasks()->where('is_completed', 1)->count();
                                                $percentageCompleted = (($isCompleted/$totalSubTasks)*100);
                                            @endphp
                                            <div class="progress-bar bg-primary" role="progressbar" aria-label="Example with label" style="width: {{$percentageCompleted}}%;" aria-valuenow="{{$percentageCompleted}}" aria-valuemin="0" aria-valuemax="100">{{number_format($percentageCompleted,2)}}%</div>
                                        @endif
                                    </div>
                                    <ul>
                                        @foreach($todayTask->collaborators as $collaborator)
                                            <li><img src="{{$collaborator->user->image_url}}" alt="{{$collaborator->user->name}}" class="img-avatar"></li>
                                        @endforeach
                                    </ul>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="boxes">
                    <h3>Upcoming  <img src="{{asset('images/wow-emoji.png')}}" alt="" class="icos"></h3>
                    <ul>
                        @foreach($upComming as $todayTask)
                            <li>
                                <a href="javascript:void(0);"  onclick="openTaskModal({{$todayTask->id}}, {{$todayTask->project_id}})">
                                    <p>{{$todayTask->title}}</p>
                                    @include('project.widgets.priority', [
                                        'task' => $todayTask
                                    ])
                                    <div class="progress">
                                        @php
                                            $totalSubTasks = $todayTask->subtasks()->count();
                                        @endphp
                                        @if($totalSubTasks==0)
                                            @if($todayTask->is_completed==1)
                                                <div class="progress-bar bg-primary" role="progressbar" aria-label="Example with label" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                            @else
                                                <div class="progress-bar bg-primary" role="progressbar" aria-label="Example with label" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                            @endif
                                        @else
                                            @php
                                                $notCompleted = $todayTask->subtasks()->where('is_completed', 0)->count();
                                                $isCompleted = $todayTask->subtasks()->where('is_completed', 1)->count();
                                                $percentageCompleted = (($isCompleted/$totalSubTasks)*100);
                                            @endphp
                                            <div class="progress-bar bg-primary" role="progressbar" aria-label="Example with label" style="width: {{$percentageCompleted}}%;" aria-valuenow="{{$percentageCompleted}}" aria-valuemin="0" aria-valuemax="100">{{number_format($percentageCompleted,2)}}%</div>
                                        @endif
                                    </div>
                                    <ul>
                                        @foreach($todayTask->collaborators as $collaborator)
                                            <li><img src="{{$collaborator->user->image_url}}" alt="{{$collaborator->user->name}}" class="img-avatar"></li>
                                        @endforeach
                                    </ul>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="boxes">
                    <h3>Overdue <img src="{{asset('images/sad-emoji.png')}}" alt="" class="icos"></h3>
                    <ul>
                        @foreach($overdue as $todayTask)
                            <li>
                                <a href="javascript:void(0);"  onclick="openTaskModal({{$todayTask->id}}, {{$todayTask->project_id}})">
                                    <p>{{$todayTask->title}}</p>
                                    @include('project.widgets.priority', [
                                        'task' => $todayTask
                                    ])
                                    <div class="progress">
                                        @php
                                            $totalSubTasks = $todayTask->subtasks()->count();
                                        @endphp
                                        @if($totalSubTasks==0)
                                            @if($todayTask->is_completed==1)
                                                <div class="progress-bar bg-primary" role="progressbar" aria-label="Example with label" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                            @else
                                                <div class="progress-bar bg-primary" role="progressbar" aria-label="Example with label" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                            @endif
                                        @else
                                            @php
                                                $notCompleted = $todayTask->subtasks()->where('is_completed', 0)->count();
                                                $isCompleted = $todayTask->subtasks()->where('is_completed', 1)->count();
                                                $percentageCompleted = (($isCompleted/$totalSubTasks)*100);
                                            @endphp
                                            <div class="progress-bar bg-primary" role="progressbar" aria-label="Example with label" style="width: {{$percentageCompleted}}%;" aria-valuenow="{{$percentageCompleted}}" aria-valuemin="0" aria-valuemax="100">{{number_format($percentageCompleted,2)}}%</div>
                                        @endif
                                    </div>
                                    <ul>
                                        @foreach($todayTask->collaborators as $collaborator)
                                            <li><img src="{{$collaborator->user->image_url}}" alt="{{$collaborator->user->name}}" class="img-avatar"></li>
                                        @endforeach
                                    </ul>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="boxes">
                    <h3>Completed <img src="{{asset('images/love-emoji.png')}}" alt="" class="icos"></h3>
                    <ul>
                        @foreach($completedToday as $todayTask)
                            <li>
                                <a href="javascript:void(0);"  onclick="openTaskModal({{$todayTask->id}}, {{$todayTask->project_id}})">
                                    <p>{{$todayTask->title}}</p>
                                    @include('project.widgets.priority', [
                                        'task' => $todayTask
                                    ])
                                    <div class="progress">
                                        @php
                                            $totalSubTasks = $todayTask->subtasks()->count();
                                        @endphp
                                        @if($totalSubTasks==0)
                                            @if($todayTask->is_completed==1)
                                                <div class="progress-bar bg-primary" role="progressbar" aria-label="Example with label" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                            @else
                                                <div class="progress-bar bg-primary" role="progressbar" aria-label="Example with label" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                            @endif
                                        @else
                                            @php
                                                $notCompleted = $todayTask->subtasks()->where('is_completed', 0)->count();
                                                $isCompleted = $todayTask->subtasks()->where('is_completed', 1)->count();
                                                $percentageCompleted = (($isCompleted/$totalSubTasks)*100);
                                            @endphp
                                            <div class="progress-bar bg-primary" role="progressbar" aria-label="Example with label" style="width: {{$percentageCompleted}}%;" aria-valuenow="{{$percentageCompleted}}" aria-valuemin="0" aria-valuemax="100">{{number_format($percentageCompleted,2)}}%</div>
                                        @endif
                                    </div>
                                    <ul>
                                        @foreach($todayTask->collaborators as $collaborator)
                                            <li><img src="{{$collaborator->user->image_url}}" alt="{{$collaborator->user->name}}" class="img-avatar"></li>
                                        @endforeach
                                    </ul>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="boxes">
                    <h3>Stopped <img src="{{asset('images/stop-emoji.png')}}" alt="" class="icos"></h3>
                    <ul>
                        @foreach($stopped as $todayTask)
                            <li>
                                <a href="javascript:void(0);"  onclick="openTaskModal({{$todayTask->id}}, {{$todayTask->project_id}})">
                                    <p>{{$todayTask->title}}</p>
                                    @include('project.widgets.priority', [
                                        'task' => $todayTask
                                    ])
                                    <div class="progress">
                                        @php
                                            $totalSubTasks = $todayTask->subtasks()->count();
                                        @endphp
                                        @if($totalSubTasks==0)
                                            @if($todayTask->is_completed==1)
                                                <div class="progress-bar bg-primary" role="progressbar" aria-label="Example with label" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                            @else
                                                <div class="progress-bar bg-primary" role="progressbar" aria-label="Example with label" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                            @endif
                                        @else
                                            @php
                                                $notCompleted = $todayTask->subtasks()->where('is_completed', 0)->count();
                                                $isCompleted = $todayTask->subtasks()->where('is_completed', 1)->count();
                                                $percentageCompleted = (($isCompleted/$totalSubTasks)*100);
                                            @endphp
                                            <div class="progress-bar bg-primary" role="progressbar" aria-label="Example with label" style="width: {{$percentageCompleted}}%;" aria-valuenow="{{$percentageCompleted}}" aria-valuemin="0" aria-valuemax="100">{{number_format($percentageCompleted,2)}}%</div>
                                        @endif
                                    </div>
                                    <ul>
                                        @foreach($todayTask->collaborators as $collaborator)
                                            <li><img src="{{$collaborator->user->image_url}}" alt="{{$collaborator->user->name}}" class="img-avatar"></li>
                                        @endforeach
                                    </ul>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('js')
<script>

</script>
@endpush
@push('css')
<style>
</style>
@endpush