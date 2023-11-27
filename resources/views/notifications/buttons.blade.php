<div class="d-flex align-items-center">
    <div class="flex-shrink-0"></div>
    <div class="flex-grow-1 ms-3">
        <span class="float-end notification-actions">
            <a href="{{route('notifications.important',$notification->id)}}" class="border border-warning pe-1 px-1 rounded text-warning"><i class="fa fa-sm {{$notification->is_important==0?'fa-star-o':'fa-star'}}" aria-hidden="true"></i></a>
            <a href="{{route('notifications.destroy',$notification->id)}}" class="border border-danger pe-1 px-1 rounded text-danger"><i class="fa fa-sm fa-trash" aria-hidden="true"></i></a>
        </span>
    </div>
</div>