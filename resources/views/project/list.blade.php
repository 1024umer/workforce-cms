@extends('layout.main')
@section('content')
<div class="main-screen">
  @include('project.widgets.head')
  <section class="top-list">
    <div class="">
      <div class="list-header">
        <table class="table ">
          <thead>
            <tr>
              <th width="25%" scope="col">Task name</th>
              <th width="15%" scope="col">Assignee</th>
              <th width="15%" scope="col">Due Date</th>
              <th width="15%" scope="col">Priority</th>
              <th width="30%" scope="col">Percentage</th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="accordion" id="task-list">
        @foreach($project->grids as $gridk=>$grid)
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              @include('project.widgets.cardhandlers', [
                'grid' => $grid,
                'loopLast' => $loop->last,
                'loopFirst' => $loop->first,
                'project' => $project
              ])
              <button class="accordion-button {{$gridk==0?'':'collapsed'}}" type="button" data-bs-toggle="collapse" data-bs-target="#task-list-{{$grid->id}}" aria-expanded="true" aria-controls="task-list-{{$grid->id}}">
                {{$grid->grid_name}} <span class="total-count">{{$grid->tasks()->count()}}</span>
                  
              </button>

            </h2>
            <div id="task-list-{{$grid->id}}" class="accordion-collapse collapse {{$gridk==0?'show':''}}" aria-labelledby="headingOne" data-bs-parent="#task-list">
              <div class="accordion-body">
                <table class="table table-striped table-bordered">
                  <tbody>
                    @foreach($grid->tasks as $task)
                      <tr onclick="openTaskModal({{$task->id}}, {{$task->project_id}})">
                        <td width="25%" scope="col"><span class="task-main"><i class="fas fa-circle-check"></i> {{$task->title}} </span></td>
                        <td width="15%" scope="col"><span class="asignee"><img class="" src="{{$task->assigned->image_url}}" alt=""> {{$task->assigned->name}}</span></td>
                        <td width="15%" scope="col"><span class="date-eff">{{$task->due_date}}</span></td>
                        <td width="15%" scope="col">
                          @include('project.widgets.priority', [
                            'task' => $task
                          ])
                        </td>
                        <td width="30%" scope="col">
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
                <a href="javascript:void(0);" onclick="openTaskModalProject({{$grid->project_id}}, {{$grid->id}})" class="btn"><i class="fas fa-plus-circle" aria-hidden="true"></i> Create a Task</a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="project-sec">
        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createCardModal" class="addnew"><i class="fas fa-plus-circle" aria-hidden="true"></i> Add Card</a>
      </div>
    </section>
</div>
@include('project.widgets.createCard')
@include('project.widgets.createTask')
@include('project.widgets.changeProjectTitle', [
    'project_id' => $project->id,
    'title' => $project->title
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