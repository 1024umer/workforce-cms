@extends('layout.main')
@section('content')
<div class="main-screen">
    <section class="notifi">
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-md-12">
                    <form enctype="multipart/form-data" method="POST" action="{{route('admin.users.store')}}">
                        @csrf
                        <div class="form-floating mb-3 mt-3">
                            <input value="{{old('name')}}" required type="text" class="form-control" id="floatingName" placeholder="Name" name="name">
                            <label for="floatingName">Name</label>
                        </div>
                        @include('layout.widgets.error', ['type' => 'name'])
                        <div class="form-floating mb-3">
                            <input value="{{old('email')}}" required type="email" class="form-control" id="floatingEmail" placeholder="Email" name="email">
                            <label for="floatingEmail">Email</label>
                        </div>
                        @include('layout.widgets.error', ['type' => 'email'])
                        <div class="form-floating mb-3">
                            <select required class="form-select" id="floatingSelect" aria-label="User Type" name="user_type">
                                <option value="">User Type</option>
                                <option value="0">Workforce</option>
                                <option value="1">Admin</option>
                                <option value="2">Freelancer</option>
                            </select>
                            <label for="floatingSelect">User Type</label>
                        </div>
                        @include('layout.widgets.error', ['type' => 'user_type'])
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupFile01">Profile Picture</label>
                            <input type="file" class="form-control" id="inputGroupFile01" name="image">
                        </div>
                        @include('layout.widgets.error', ['type' => 'image'])
                        <div class="form-floating mb-3">
                            <input required type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        @include('layout.widgets.error', ['type' => 'password'])
                        <input type="submit" value="Create" class="btn btn-outline-success mb-3" />
                    </form>
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