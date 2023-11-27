@extends('layout.main')
@section('content')
<div class="main-screen">

    <section class="notifi">
        <h3>
            Users Listing
            <a href="{{route('admin.users.create')}}" class="btn btn-outline-info btn-sm float-end">Create New</a>
        </h3>
        <div class="container-fluid">
            <nav class="navbar bg-body-tertiary">
                <form method="GET" class="d-flex" role="search">
                    <input value="{{isset($_GET['search'])?$_GET['search']:''}}" class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
                    <select name="user_type" class="form-control me-2">
                        <option value="">User Type</option>
                        <option value="0">Workforce</option>
                        <option value="1">Admin</option>
                        <option value="2">Freelancer</option>
                    </select>
                    <button class="btn btn-outline-success" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </nav>
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($query as $user)
                            <tr>
                                <td>
                                    <a href="{{route('user',$user)}}" target="_blank">
                                        <img class="img-avatar" src="{{$user->image_url}}" />
                                        {{$user->name}}
                                    </a>
                                </td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @if($user->user_type==0)
                                        Workforce
                                    @elseif($user->user_type==1)
                                        Admin
                                    @elseif($user->user_type==2)
                                        Freelancer
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('admin.users.edit', $user)}}" class="btn btn-outline-info btn-sm">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <form class="d-inline-block" method="POST" action="{{route('admin.users.destroy', $user)}}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">
                                    No Users Found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{$query->links()}}
                </div>
            </div>
        </div>
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