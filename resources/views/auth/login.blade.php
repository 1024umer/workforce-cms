@extends('layout.main')
@section('content')
<div class="loginPg">
    <!-- HEADER -->
    <div class="container-fluid">
        <div class="loginBox">
            <div class="formbox">
                <img class="img-fluid" src="{{asset('images/logo.png')}}" alt="" />
                <h3>Login</h3>
                <p>Welcome back! Enter your email and
                    password below to sign in</p>
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    @error('passowrd')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                <form action="{{route('login.check')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" id="exampleFormControlInput1" placeholder="Enter your email">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Password</label>
                        <input name="password" type="password" class="form-control" id="exampleFormControlInput1" placeholder="Enter your password">
                    </div>
                    <div class="mb-3">
                        <input type="checkbox" class="" id="inputPassword2">
                        <label for="inputPassword2">Keep me logged in</label>
                    </div>
                    <button class="btn"> login</button>
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