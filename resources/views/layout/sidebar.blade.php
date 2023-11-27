<div class="widget">
    <div class="logo-side">
        <a data-bs-toggle="modal" data-bs-target="#wfmManagementModal" href="javascript:void(0)">
            <img src="{{asset('images/logo.png')}}" class="img-fluid" alt="" />
        </a>
    </div>
    <div class="link">
        <ul>
            <li class="{{isset($dashboardMenu)?'active':''}}"><a href="{{route('dashboard')}}"><i class="fas fa-home-lg"></i> Home</a></li>
            <li class="{{isset($myTaskMenu)?'active':''}}"><a href="{{route('mytasks')}}"><i class="fas fa-list-check"></i> My Tasks Board</a></li>
            <li class="{{isset($myTaskListMenu)?'active':''}}"><a href="{{route('mytasks.list')}}"><i class="fas fa-tasks-alt"></i> My Tasks List</a></li>
            <li class="{{isset($notificationMenu)?'active':''}}"><a href="{{route('notifications')}}"><i class="fas fa-bell"></i> Notifications <span class="float-end badge bg-primary">{{$notificationCount}}</span></a></li>
            <!-- <li class="{{isset($inboxMenu)?'active':''}}"><a href="{{route('inbox')}}"><i class="fas fa-comments"></i> Inbox <span class="status"></span></a></li> -->
            <li class="{{isset($quoteMenu)?'active':''}}"><a href="{{route('quotes.create')}}"><i class="fas fa-quote-right"></i> Post Quotes</a></li>
            <li class="{{isset($reportMenu)?'active':''}}"><a href="{{route('reports')}}"><i class="fas fa-chart-line"></i> Reports</a></li>
            <li class="{{isset($aProjectMenu)?'active':''}}"><a href="{{route('projects.index')}}"><i class="fas fa-project-diagram"></i> Projects</a></li>
            @if(auth()->user()->user_type==1)
                <li class="{{isset($gridMenu)?'active':''}}"><a href="{{route('projects.grids.index',[1])}}"><i class="fa fa-link"></i> Task Types</a></li>
                <li class="{{isset($aUserMenu)?'active':''}}"><a href="{{route('admin.users.index')}}"><i class="fas fa-user-circle"></i> Users</a></li>
                <li class="{{isset($WFMTasksMenu)?'active':''}}"><a href="{{route('workforce.tasks.assign',1)}}"><i class="fas fa-manat-sign"></i> Assign WF Tasks</a></li>
            @endif
        </ul>
    </div>
    <div class="projectBar">
    </div>
    <div class="project-sec">
        <h3>Projects</h3>

        <div class="accordion recent-projects-dashboard" id="accordionExample">
            
        </div>
        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createProjectModal" class="addnew"><i class="fas fa-plus-circle"></i> Add New Projects</a>
    </div>
    <div class="profile-sec">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#profileOne" aria-expanded="true" aria-controls="profileOne">

                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img src="{{auth()->user()->image_url}}" alt="profile picture" class="img-avatar">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4>{{ucwords(auth()->user()->name)}}</h4>
                                <span class="ocu">
                                    @if(auth()->user()->user_type==0)
                                    Workforce
                                    @elseif(auth()->user()->user_type==1)
                                    Admin
                                    @elseif(auth()->user()->user_type==2)
                                    Freelancer
                                    @endif
                                </span>
                            </div>
                        </div>
                    </button>
                </h2>
                <div id="profileOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <ul>
                            <li class="{{isset($profileMenu)?'active':''}}"><a href="{{route('profile')}}"><i class="fas fa-user-alt" aria-hidden="true"></i> Edit Profile </a></li>
                            <li><a href="{{route('logout')}}"><i class="fas fa-sign-out-alt" aria-hidden="true"></i> Logout </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>