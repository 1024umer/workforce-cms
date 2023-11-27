@extends('layout.main')
@section('content')
<div class="loginPg">
    <!-- HEADER -->
    <div class="container-fluid">
        <div class="loginBox">
            <div class="formbox">
                <img class="img-fluid" src="{{asset('images/logo.png')}}" alt="" />
                <h3>Invitation</h3>
                <p>You have been invited to collaborate on <b>{{$projectInvite->project->title}}</b></p>
                <form action="{{route('project.invite.accept', $projectInvite)}}" method="POST">
                    @csrf
                    @if($userCheckCount===0)
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="Enter your Name">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Create Password</label>
                            <input name="password" type="password" class="form-control" id="exampleFormControlInput1" placeholder="Enter your password">
                        </div>
                    @endif
                    <button class="btn"> Accept Invite</button>
                </form>
            </div>
        </div>
    </div>
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