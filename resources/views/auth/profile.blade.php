@extends('layout.main')
@section('content')
<div class="main-screen">
    <div class="edit-profile">
        <div class="row">
            <div class="col-md-4">
                <div class="person-pic">
                    <img src="{{auth()->user()->image_url}}" alt="" class="img-responsive" />
                    <h4>{{ucwords(auth()->user()->name)}}</h4>
                    <span class="ocu">@if(auth()->user()->user_type==0)
                                    Workforce
                                    @elseif(auth()->user()->user_type==1)
                                    Admin
                                    @elseif(auth()->user()->user_type==2)
                                    Freelancer
                                    @endif</span>
                </div>
            </div>
            <div class="col-md-8">
                <div class="person-info">
                    <h3>Personal Information</h3>
                    <p>Update your personal information from here</p>
                    <form method="POST" action="{{route('profile.update')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input name="name" value="{{auth()->user()->name}}" type="text" class="form-control" id="inputEmail4" placeholder="Full Name">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input name="email" value="{{auth()->user()->email}}" type="email" class="form-control" id="inputAddress" placeholder="Email">
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <textarea placeholder="Bio" name="bio" class="form-control">{{auth()->user()->bio}}</textarea>
                            @error('bio')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <input type="text" value="{{auth()->user()->favourite_color}}" name="favourite_color" class="form-control" placeholder="Favourite Color" aria-label="Favourite Color" />
                                    @error('favourite_color')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <input type="text" value="{{auth()->user()->favourite_movie}}" name="favourite_movie" class="form-control" placeholder="Favourite Movie" aria-label="Favourite Movie" />
                                    @error('favourite_movie')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <input type="text" value="{{auth()->user()->favourite_book}}" name="favourite_book" class="form-control" placeholder="Favourite Book" aria-label="Favourite Book" />
                                    @error('favourite_book')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <input type="text" value="{{auth()->user()->favourite_animal}}" name="favourite_animal" class="form-control" placeholder="Favourite Animal" aria-label="Favourite Animal" />
                                    @error('favourite_animal')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <input type="text" value="{{auth()->user()->favourite_food}}" name="favourite_food" class="form-control" placeholder="Favourite Food" aria-label="Favourite Food" />
                                    @error('favourite_food')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <input type="text" value="{{auth()->user()->hobbies}}" name="hobbies" class="form-control" placeholder="Hobbies" aria-label="Hobbies" />
                                    @error('hobbies')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <input type="text" value="{{auth()->user()->dream_vacation}}" name="dream_vacation" class="form-control" placeholder="Dream Vacation" aria-label="Dream Vacation" />
                                    @error('dream_vacation')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <input type="text" value="{{auth()->user()->pet_peeves}}" name="pet_peeves" class="form-control" placeholder="Pet Peeves" aria-label="Pet Peeves" />
                                    @error('pet_peeves')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <input type="text" value="{{auth()->user()->biggest_fear}}" name="biggest_fear" class="form-control" placeholder="Biggest Fear" aria-label="Biggest Fear" />
                                    @error('biggest_fear')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <input type="text" value="{{auth()->user()->superpowers}}" name="superpowers" class="form-control" placeholder="Super Powers" aria-label="Super Powers" />
                                    @error('superpowers')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <input type="text" value="{{auth()->user()->onewish}}" name="onewish" class="form-control" placeholder="One Wish" aria-label="One Wish" />
                                    @error('onewish')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <input type="text" value="{{auth()->user()->talent}}" name="talent" class="form-control" placeholder="Talent" aria-label="Talent" />
                                    @error('talent')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <input type="date" value="{{auth()->user()->date_of_birth}}" name="date_of_birth" class="form-control" placeholder="Date of Birth" aria-label="Date of Birth" />
                                    @error('date_of_birth')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputImage">Image</label>
                            <input name="image" type="file" class="form-control" id="inputImage" />
                        </div>
                        <button type="submit" class="btn save">Update Profile</button>
                    </form>
                    <form method="POST" action="{{route('profile.changepassword')}}">
                        @csrf
                        <div class="form-group">
                            <label for="inputAddress1">Password</label>
                            <input name="password" type="password" class="form-control" id="inputAddress1" placeholder="Password">
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputAddress2">Confirm Password</label>
                            <input name="password_confirmation" type="password" class="form-control" id="inputAddress2" placeholder="Confirm Password">
                            @error('password_confirmation')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn save">Update Password</button>
                    </form>
                </div>
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