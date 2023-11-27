<div class="d-flex align-items-center">
    <div class="flex-shrink-0">
        <img src="{{$taskComment->user->image_url}}" alt="{{$taskComment->user->name}}" class="img-avatar">
    </div>
    <div class="flex-grow-1 ms-3">
        <p><span class="name"><a target="_blank" href="{{route('user', $taskComment->user)}}">{{$taskComment->user->name}}</a></span> {{$text}} </p>
        <span class="date">{{$taskComment->created_at_formatted}}</span>
    </div>
</div>