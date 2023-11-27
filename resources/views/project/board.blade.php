@extends('layout.main')
@section('content')
<div class="main-screen">
    @include('project.widgets.head')
    <section class="board-list">
        <div class="project-sec">
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createCardModal" class="addnew"><i class="fas fa-plus-circle" aria-hidden="true"></i> Add Card</a>
                    </div>
        <div class="row">
            @foreach($project->grids as $grid)
                <div class="col-md-3">
                    <div class="boxes">
                        <h3>{{$grid->grid_name}}</h3>
                        @include('project.widgets.cardhandlers', [
                            'grid' => $grid,
                            'loopLast' => $loop->last,
                            'loopFirst' => $loop->first,
                            'project' => $project
                        ])
                        <ul>
                            @foreach($grid->tasks as $task)
                                <li>
                                    <a href="javascript:void(0);" onclick="openTaskModal({{$task->id}}, {{$task->project_id}})">
                                        <p>{{$task->title}}</p>
                                        @include('project.widgets.priority', [
                                            'task' => $task
                                        ])
                                        <div class="progress">
                                            @php
                                                $totalSubTasks = $task->subtasks()->count();
                                            @endphp
                                            @if($totalSubTasks==0)
                                                @if($task->is_completed==1)
                                                    <div class="progress-bar bg-primary" role="progressbar" aria-label="Example with label" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                                @else
                                                    <div class="progress-bar bg-primary" role="progressbar" aria-label="Example with label" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                                @endif
                                            @else
                                            @php
                                                $notCompleted = $task->subtasks()->where('is_completed', 0)->count();
                                                $isCompleted = $task->subtasks()->where('is_completed', 1)->count();
                                                $percentageCompleted = (($isCompleted/$totalSubTasks)*100);
                                            @endphp
                                                <div class="progress-bar bg-primary" role="progressbar" aria-label="Example with label" style="width: {{$percentageCompleted}}%;" aria-valuenow="{{$percentageCompleted}}" aria-valuemin="0" aria-valuemax="100">{{number_format($percentageCompleted,2)}}%</div>
                                            @endif
                                        </div>
                                        <ul>
                                            @foreach($task->collaborators as $collaborator)
                                                <li><img src="{{$collaborator->user->image_url}}" alt="{{$collaborator->user->name}}" class="img-avatar"></li>
                                            @endforeach
                                        </ul>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="project-sec">
                            <a href="javascript:void(0)" onclick="openTaskModalProject({{$grid->project_id}}, {{$grid->id}})" class="addnew"><i class="fas fa-plus-circle" aria-hidden="true"></i> Create New Task</a>
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- <div class="col-md-3">
                <div class="boxes">
                    <h3>Doing</h3>
                    <div class="toogle">

                        <a href="javascript:void(0);" class="link"><i class="fas fa-plus-circle"></i></a>

                        <a href="javascript:void(0);" type="button" class="dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-vertical"></i>

                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </a>
                    </div>
                    <ul>
                        <li><a href="javascript:void(0);">
                                <p>Contact client for outlin...</p>
                                <ul>
                                    <li><img src="https://randomuser.me/api/portraits/men/85.jpg" alt="profile picture" class="img-avatar"></li>
                                    <li><img src="https://randomuser.me/api/portraits/men/84.jpg" alt="profile picture" class="img-avatar"></li>
                                </ul>
                            </a>
                        </li>
                        <li><a href="javascript:void(0);">
                                <p>Contact client for outlin...</p>
                                <ul>
                                    <li><img src="https://randomuser.me/api/portraits/men/85.jpg" alt="profile picture" class="img-avatar"></li>
                                    <li><img src="https://randomuser.me/api/portraits/men/84.jpg" alt="profile picture" class="img-avatar"></li>
                                </ul>
                            </a>
                        </li>
                        <li><a href="javascript:void(0);">
                                <p>Contact client for outlin...</p>
                                <span class="btn med">Medium</span>
                                <span class="btn risk">At Risk</span>
                                <ul>
                                    <li><img src="https://randomuser.me/api/portraits/men/85.jpg" alt="profile picture" class="img-avatar"></li>
                                    <li><img src="https://randomuser.me/api/portraits/men/84.jpg" alt="profile picture" class="img-avatar"></li>
                                </ul>
                            </a>
                        </li>


                    </ul>
                    <div class="project-sec">


                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createProjectModal" class="addnew"><i class="fas fa-plus-circle" aria-hidden="true"></i> Create New Task</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="boxes">
                    <h3>Done</h3>
                    <div class="toogle">

                        <a href="javascript:void(0);" class="link"><i class="fas fa-plus-circle"></i></a>

                        <a href="javascript:void(0);" type="button" class="dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-vertical"></i>

                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </a>
                    </div>
                    <ul>
                        <li><a href="javascript:void(0);">
                                <p>Contact client for outlin...</p>
                                <span class="btn high">Medium</span>
                                <span class="btn off">At Risk</span>
                                <ul>
                                    <li><img src="https://randomuser.me/api/portraits/men/85.jpg" alt="profile picture" class="img-avatar"></li>
                                    <li><img src="https://randomuser.me/api/portraits/men/84.jpg" alt="profile picture" class="img-avatar"></li>
                                </ul>
                            </a>
                        </li>
                        <li><a href="javascript:void(0);">
                                <p>Contact client for outlin...</p>
                                <ul>
                                    <li><img src="https://randomuser.me/api/portraits/men/85.jpg" alt="profile picture" class="img-avatar"></li>
                                    <li><img src="https://randomuser.me/api/portraits/men/84.jpg" alt="profile picture" class="img-avatar"></li>
                                </ul>
                            </a>
                        </li>


                    </ul>
                    <div class="project-sec">


                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createProjectModal" class="addnew"><i class="fas fa-plus-circle" aria-hidden="true"></i> Create New Task</a>
                    </div>
                </div>
            </div> -->
           
        </div>
    </section>
</div>
@include('project.widgets.createCard')
@include('project.widgets.createTask')
@include('project.widgets.changeProjectTitle', [
    'project_id' => $project->id,
    'project_title' => $project->title
])
@endsection
@push('js')
<script>

</script>
@endpush
@push('css')
<style>
</style>
@endpush