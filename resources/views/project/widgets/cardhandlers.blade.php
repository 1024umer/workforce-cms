<div class="toogle">
    <a href="javascript:void(0);" type="button" class="dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-vertical"></i>
        <ul class="dropdown-menu">
            @if (!$loopLast)
                <li>
                    <a class="dropdown-item" href="{{route('projects.grids.order.update', [$project, $grid,'down'])}}">Move Card Next</a>
                </li>
            @endif
            @if (!$loopFirst)
                <li>
                    <a class="dropdown-item" href="{{route('projects.grids.order.update', [$project, $grid,'up'])}}">Move Card Previous</a>
                </li>
            @endif
            <!-- <li>
                <a class="dropdown-item" href="#">Add Card Next</a>
            </li>
            <li>
                <a class="dropdown-item" href="#">Add Card Previous</a>
            </li>
            <li>
                <a class="dropdown-item" href="#">Move Card To</a>
            </li>
            <li>
                <a class="dropdown-item" href="#">Delete Card</a>
            </li> -->
            <li>
                <a class="dropdown-item" href="javascript:void(0)" onclick="openUpdateCardModal({{$grid->id}}, {{$project->id}})">Update Card Name</a>
            </li>
        </ul>
    </a>
</div>