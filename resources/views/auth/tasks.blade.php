@extends('layout.main')
@section('content')
<div class="main-screen">
    <section class="top-list">
        <div class="">
            <div class="list-header">
                <table class="table ">
                    <thead>
                        <tr>
                            <th width="25%" scope="col">Task name</th>
                            <th width="15%" scope="col">Assignee</th>
                            <th width="15%" scope="col">Due / Completed</th>
                            <th width="15%" scope="col">Priority</th>
                            <th width="10%" scope="col">Grid/Type</th>
                            <th width="20%" scope="col">Percentage</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="accordion" id="task-list">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#task-list-today" aria-expanded="true" aria-controls="task-list-today">
                            Today <img src="{{asset('images/happy-emoji.png')}}" alt="" class="icos"> <span class="total-count">{{$today->count()}}</span>
                        </button>
                    </h2>
                    <div id="task-list-today" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#task-list">
                        <div class="accordion-body pb-4">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    @foreach($today as $task)
                                    <tr onclick="openTaskModal({{$task->id}}, {{$task->project_id}})">
                                        <td width="25%" scope="col"><span class="task-main"><i class="fas fa-circle-check"></i> {{$task->title}} </span></td>
                                        <td width="15%" scope="col"><span class="asignee"><img class="" src="{{$task->assigned->image_url}}" alt=""> {{$task->assigned->name}}</span></td>
                                        <td width="15%" scope="col"><span class="date-eff">{{$task->due_date}}</span></td>
                                        <td width="15%" scope="col">
                                            @include('project.widgets.priority', [
                                            'task' => $task
                                            ])
                                        </td>
                                        <td width="10%" scope="col">
                                            {{$task->grid->grid_name}}
                                        </td>
                                        <td width="20%" scope="col">
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
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#task-list-upcomming" aria-expanded="true" aria-controls="task-list-upcomming">
                            Upcomming <img src="{{asset('images/wow-emoji.png')}}" alt="" class="icos"> <span class="total-count">{{$upComming->count()}}</span>
                        </button>
                    </h2>
                    <div id="task-list-upcomming" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#task-list">
                        <div class="accordion-body pb-4">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    @foreach($upComming as $task)
                                    <tr onclick="openTaskModal({{$task->id}}, {{$task->project_id}})">
                                        <td width="25%" scope="col"><span class="task-main"><i class="fas fa-circle-check"></i> {{$task->title}} </span></td>
                                        <td width="15%" scope="col"><span class="asignee"><img class="" src="{{$task->assigned->image_url}}" alt=""> {{$task->assigned->name}}</span></td>
                                        <td width="15%" scope="col"><span class="date-eff">{{$task->due_date}}</span></td>
                                        <td width="15%" scope="col">
                                            @include('project.widgets.priority', [
                                            'task' => $task
                                            ])
                                        </td>
                                        <td width="10%" scope="col">
                                            {{$task->grid->grid_name}}
                                        </td>
                                        <td width="20%" scope="col">
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
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#task-list-overdue" aria-expanded="true" aria-controls="task-list-overdue">
                            Overdue <img src="{{asset('images/sad-emoji.png')}}" alt="" class="icos"> <span class="total-count">{{$overdue->count()}}</span>
                        </button>
                    </h2>
                    <div id="task-list-overdue" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#task-list">
                        <div class="accordion-body pb-4">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    @foreach($overdue as $task)
                                    <tr onclick="openTaskModal({{$task->id}}, {{$task->project_id}})">
                                        <td width="25%" scope="col"><span class="task-main"><i class="fas fa-circle-check"></i> {{$task->title}} </span></td>
                                        <td width="15%" scope="col"><span class="asignee"><img class="" src="{{$task->assigned->image_url}}" alt=""> {{$task->assigned->name}}</span></td>
                                        <td width="15%" scope="col"><span class="date-eff">{{$task->due_date}}</span></td>
                                        <td width="15%" scope="col">
                                            @include('project.widgets.priority', [
                                            'task' => $task
                                            ])
                                        </td>
                                        <td width="10%" scope="col">
                                            {{$task->grid->grid_name}}
                                        </td>
                                        <td width="20%" scope="col">
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
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#task-list-completed" aria-expanded="true" aria-controls="task-list-completed">
                            Completed <img src="{{asset('images/love-emoji.png')}}" alt="" class="icos"> <span class="total-count">{{$completedToday->count()}}</span>
                        </button>
                    </h2>
                    <div id="task-list-completed" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#task-list">
                        <div class="accordion-body pb-4">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr class="mb-3">
                                        <td colspan="6">
                                            <form method="GET">
                                                <input type="hidden" name="type" value="completed" />
                                                <div class="row">
                                                    <div class="col">
                                                        <input value="{{$fromDate}}" name="start_date" type="date" class="form-control" placeholder="From" aria-label="From Date" />
                                                    </div>
                                                    <div class="col">
                                                        <input value="{{$toDate}}" name="end_date" type="date" class="form-control" placeholder="Date" aria-label="To Date" />
                                                    </div>
                                                    <div class="col">
                                                        <input type="submit" class="btn m-0 p-1" value="Submit" />
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                    @foreach($completedToday as $task)
                                    <tr onclick="openTaskModal({{$task->id}}, {{$task->project_id}})">
                                        <td width="25%" scope="col"><span class="task-main"><i class="fas fa-circle-check"></i> {{$task->title}} </span></td>
                                        <td width="15%" scope="col"><span class="asignee"><img class="" src="{{$task->assigned->image_url}}" alt=""> {{$task->assigned->name}}</span></td>
                                        <td width="15%" scope="col"><span class="date-eff">{{$task->completed_at}}</span></td>
                                        <td width="15%" scope="col">
                                            @include('project.widgets.priority', [
                                            'task' => $task
                                            ])
                                        </td>
                                        <td width="10%" scope="col">
                                            {{$task->grid->grid_name}}
                                        </td>
                                        <td width="20%" scope="col">
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
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#task-list-stopped" aria-expanded="true" aria-controls="task-list-stopped">
                            Stopped <img src="{{asset('images/stop-emoji.png')}}" alt="" class="icos"> <span class="total-count">{{$stopped->count()}}</span>
                        </button>
                    </h2>
                    <div id="task-list-stopped" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#task-list">
                        <div class="accordion-body pb-4">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    @foreach($stopped as $task)
                                    <tr onclick="openTaskModal({{$task->id}}, {{$task->project_id}})">
                                        <td width="25%" scope="col"><span class="task-main"><i class="fas fa-circle-check"></i> {{$task->title}} </span></td>
                                        <td width="15%" scope="col"><span class="asignee"><img class="" src="{{$task->assigned->image_url}}" alt=""> {{$task->assigned->name}}</span></td>
                                        <td width="15%" scope="col"><span class="date-eff">{{$task->due_date}}</span></td>
                                        <td width="15%" scope="col">
                                            @include('project.widgets.priority', [
                                            'task' => $task
                                            ])
                                        </td>
                                        <td width="10%" scope="col">
                                            {{$task->grid->grid_name}}
                                        </td>
                                        <td width="20%" scope="col">
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
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('js')
<script>
@if(isset($_GET['type']))
var type = '{{$_GET['type']}}'
if(type=='today'){
    $('[data-bs-target="#task-list-today"]').eq(0).click()
}
if(type=='upcomming'){
    $('[data-bs-target="#task-list-upcomming"]').eq(0).click()
}
if(type=='overdue'){
    $('[data-bs-target="#task-list-overdue"]').eq(0).click()
}
if(type=='completed'){
    $('[data-bs-target="#task-list-completed"]').eq(0).click()
}
if(type=='stopped'){
    $('[data-bs-target="#task-list-stopped"]').eq(0).click()
}
@endif
</script>
@endpush
@push('css')
<style>
</style>
@endpush