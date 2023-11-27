<header class="main-header">
    <div class="row align-items-center">
        <div class="col-sm-5">
            @if(isset($hiconimg))
            <h3>
            <img src="{{$hiconimg}}" class="img-avatar" />
            {{$title}} </h3>
            @else
            <h3><i class="fas {{isset($hicon)?$hicon:'fa-user-circle'}}"></i> {{$title}} </h3>
            @endif
        </div>
        <div class="col-sm-7">
            <div class="row">
                <div class="col-md-9">
                    <form id="project-search-form" method="GET" action="{{route('projects.index')}}">
                        <div class="input-group mb-2 mr-sm-2">
                            <input name="search" type="text" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Search Projects">
                            <div onclick="searchProject()" class="input-group-prepend cursor-pointer">
                                <div class="input-group-text"><i class="fas fa-search"></i></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3 d-flex">
                    <a href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#createProjectModal" class="theme-file"><i class="fas fa-plus-circle"></i></a>
                    <div class="dropdown profile-dropdown">
                        <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{auth()->user()->image_url}}" alt="profile picture" class="img-avatar">
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('profile')}}"><i class="fas fa-user-alt" aria-hidden="true"></i> Edit Profile </a></li>
                            <li><a href="{{route('logout')}}"><i class="fas fa-sign-out-alt" aria-hidden="true"></i> Logout </a></li>
                        </ul>
                    </div>
                    @if($isTimerRunning===false)
                        @if(auth()->user()->user_type!=2)
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createTaskModal" class="theme-btn position-fixed bottom-0 mb-4 task-btn">Create Task</a>
                        @endif
                    @else
                    <a onclick="openTaskModal({{$runningTimerTask->project_task_id}}, {{$runningTimerTask->project_id}})" href="javascript:void(0)" class="theme-btn position-fixed bottom-0 mb-4 task-btn timer-btn"><i style="color: white;" class="fa fa-clock"></i> <span data-timer="{{$runningTimerTask->start_time}}" data-servertime="{{now()}}" class="task-timer-running"></span></a>
                    @endif
                </div>
            </div>
        </div>
</header>