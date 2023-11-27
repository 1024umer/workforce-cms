@extends('layout.main')
@section('content')
<div class="row">
    <div class="col-md-12">
        <form enctype="multipart/form-data" action="{{route('quotes.store')}}" method="POST">
            @csrf
            <div class="mb-3">
                <textarea id="post" name="post" class="form-control"></textarea>
                @error('post')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <input type="file" name="image" class="form-control" />
                @error('image')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <button class="theme-btn-base"> Post Quote</button>
        </form>
    </div>
</div>
@endsection
@push('js')
<script>
    ClassicEditor
        .create( document.querySelector( '#post' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
@endpush
@push('css')
<style>
</style>
@endpush