@extends('layout.main')
@section('content')
<div class="main-screen">
    <section class="reports">
        <div class="row">
            <div class="project-sec">
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createCardModal" class="addnew"><i class="fas fa-plus-circle" aria-hidden="true"></i> Add Card</a>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Order</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grids as $grid)
                        <tr>
                            <td>{{$grid->grid_name}}</td>
                            <td>{{$grid->order}}</td>
                            <td>
                                @if (!$loop->last)
                                    <a href="{{route('projects.grids.order.update', [$project, $grid,'down'])}}"><i class="fa fa-arrow-down"></i></a>
                                @endif
                                @if (!$loop->first)
                                    <a href="{{route('projects.grids.order.update', [$project, $grid,'up'])}}"><i class="fa fa-arrow-up"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@include('project.widgets.createCard')
@endsection
@push('js')
<script>

</script>
@endpush
@push('css')
<style>
    .reports {
        background: #fff;
        padding: 40px;
        border-radius: 20px;
    }

    .reports .reports-list {
        /* max-height: 250px; */
    }
</style>
@endpush