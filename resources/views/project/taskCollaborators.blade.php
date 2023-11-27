@extends('layout.main')
@section('content')
<div class="main-screen">
    <a href="{{route('dashboard', ['opentaskmodal'=>true, 'project_id'=>$projectTask->project_id, 'task_id'=>$projectTask->id])}}">Go to Task</a>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $key => $user)
                <tr>
                    <td>
                        <form method="POST" action="{{route('project.task.collaborators.store', [$project, $projectTask])}}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$user->id}}" />
                        @php
                        $collaboratorCheck = $collaborators->where('user_id', $user->id)->count();
                        if($collaboratorCheck==0){
                            print '<input type="hidden" name="is_added" value="0" />';
                            print '<button type="submit" class="btn btn-success">Add</button>';
                        }else{
                            print '<input type="hidden" name="is_added" value="1" />';
                            print '<button type="submit" class="btn btn-danger">Remove</button>';
                        }
                        @endphp
                        </form>
                    </td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
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