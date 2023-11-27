<div class="d-flex align-items-center">
    <div class="flex-shrink-0">
        <img src="{{$user->image_url}}" alt="{{$user->name}}" class="img-avatar" />
    </div>
    <div class="flex-grow-1 ms-3">
        <div>
            <span class="name">
                <a target="_blank" href="{{route('mytasks.list')}}">{{$user->name}}</a>
            </span>
            You have
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Today
                    <span class="badge bg-success">{{$today}}</span> 
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Overdue
                    <span class="badge bg-warning">{{$overdue}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Stopped
                    <span class="badge bg-danger">{{$stopped}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Upcomming
                    <span class="badge bg-info">{{$upComming}}</span>
                </li>
            </ul>
        </div>
        <span class="date">{{date('l, F d, Y \a\t h:i a')}}</span>
    </div>
</div>