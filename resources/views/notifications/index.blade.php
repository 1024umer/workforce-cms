@extends('layout.main')
@section('content')
<div class="main-screen">

    <section class="notifi">
        <div class="d-flex">
            <h3>
                Notifications
            </h3>
            <a href="javascript:void(0)" type="button" class="dropdown-toggle align-self-center" data-bs-toggle="dropdown">
                Show {{isset($_GET['is_important'])?'Important':'All'}}
            </a>
            <ul class="dropdown-menu p-0">
                <li class="p-0"><a class="dropdown-item" href="{{route('notifications')}}?is_important=1">Important</a></li>
                <li class="p-0"><a class="dropdown-item" href="{{route('notifications')}}">All</a></li>
            </ul>
            
        </div>
        <ul>
            @foreach($notifications as $notification)
                @if(isset($notification->data['text']))
                <li class="{{in_array($notification->id, $notificationsRead)?'unread-cls':''}}{{$notification->is_important==1?' important-cls':''}}">
                    @include('notifications.buttons',[
                        'notification' => $notification
                    ])
                    <?php print(htmlspecialchars_decode($notification->data['text'])); ?>
                </li>
                @endif
            @endforeach
        </ul>
        {{$notifications->links()}}
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