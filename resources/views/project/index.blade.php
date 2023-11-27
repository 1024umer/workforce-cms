@extends('layout.main')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="myProject mb-2">
            <form method="GET">
                <div class="row">
                    <div class="col">
                        <div class="input-group">
                            <div class="input-group-text bg-transparent">
                                <i class="fa fa-search"></i>
                            </div>
                            <input type="text" value="{{isset($_GET['search'])?$_GET['search']:''}}" class="form-control border-start-0" name="search" placeholder="Search By Title/Description">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-12">
        <div class="myProject">
            <div class="project-list">
                <div class="row">
                    @foreach($query as $project)
                    <div class="col-md-4">
                        <a href="{{route('projects.board', $project)}}">
                            <div class="pjt-box">
                                <div class="pjt-box-header project-color-{{$project->id}}">
                                    <h4>{{$project->title}}</h4>
                                </div>
                                <div class="added-pep">
                                    <ul>
                                        @foreach($project->collaborators as $collborator)
                                            <li><a href="{{route('user', $collborator->user->id)}}"><img class="" src="{{$collborator->user->image_url}}" alt="" /></a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        {{$query->links()}}
    </div>
</div>
@endsection
@push('js')
<script>

</script>
@endpush
@push('css')
<style>
@foreach($query as $project)
.project-list .pjt-box-header.project-color-{{$project->id}}:before {
    background: {{$project->color_code}};
}
@endforeach
</style>
@endpush