@extends('layout.main')
@section('content')
<div class="main-screen">

    @include('project.widgets.head')

    <div class="file-list">
<ul>
    @foreach($files as $file)
        <li><a href="{{$file->full_url}}" target="_blank"><i class="fas fa-image"></i> {{$file->original_name}}    
        <span class="date">{{$file->created_at_formatted_sec}}</span></a></li>
    @endforeach
    <!-- <li><a href="#"><i class="fas fa-file"></i> Template 2    <span class="date">Sunday, march 17, 2021 at 2:39pm</span></a></li>
    <li><a href="#"><i class="fas fa-file-pdf"></i> Template 3    <span class="date">Sunday, march 17, 2021 at 2:39pm</span></a></li>
    <li><a href="#"><i class="fas fa-file-word"></i> Template 4    <span class="date">Sunday, march 17, 2021 at 2:39pm</span></a></li> <li><a href="#"><i class="fas fa-image"></i> Template 1    <span class="date">Sunday, march 17, 2021 at 2:39pm</span></a></li>
    <li><a href="#"><i class="fas fa-file"></i> Template 2    <span class="date">Sunday, march 17, 2021 at 2:39pm</span></a></li>
    <li><a href="#"><i class="fas fa-file-pdf"></i> Template 3    <span class="date">Sunday, march 17, 2021 at 2:39pm</span></a></li>
    <li><a href="#"><i class="fas fa-file-word"></i> Template 4    <span class="date">Sunday, march 17, 2021 at 2:39pm</span></a></li> -->
</ul>

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