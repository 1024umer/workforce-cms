<section class="nav-disk mb-4">
    <ul>
        <li class="{{isset($projectListMenu)?'active':''}}"><a href="{{route('projects.list',$project)}}">List</a></li>
        <li class="{{isset($projectBoardMenu)?'active':''}}"><a href="{{route('projects.board',$project)}}">Board</a></li>
        <li class="{{isset($projectFilesMenu)?'active':''}}"><a href="{{route('projects.files',$project)}}">Files</a></li>
    </ul>
    <a href="javascript:void(0);" onclick="inviteToProject({{$project->id}})" class="btn"><i class="fas fa-share-alt"></i> Share</a>
    <a href="javascript:void(0);" onclick="UpdateTitleProject()" class="btn mr-2"><i class="fas fa-pen"></i> Change Name</a>
</section>
<!-- <section class="lastupd">
    <p>Last Task Completed on Sep 18</p>
</section> -->