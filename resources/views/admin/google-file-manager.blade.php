@extends('admin.layouts.app')
@section('title')
Home
@endsection
@section('vendor-style')
@endsection
@section('page-style')
@endsection
@section('page-heading')
Home Page
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h1>File Manager</h1>
                <div class="row">
                    @foreach ($files as $file)
                        @php
                            $fileId = $file->getId();
                            $mimeType = $file->getMimeType();
                            // if(Auth::user()->role_id === 2){
                                $folderUrl = url('lectures') . "/?id={$fileId}";
                            // }
                            // if(Auth::user()->role_id === 3){
                            //     $folderUrl = url('lectures') . "?id={$fileId}";
                            // }
                            $imageUrl = "https://drive.google.com/uc?export=view&id={$fileId}";
                            $videoUrl = "https://drive.google.com/file/d/{$fileId}/preview";
                            $fileUrl = "https://drive.google.com/uc?export=download&id={$fileId}";
                        @endphp

                        <div class="col-md-2">
                                @if (strpos($mimeType, 'application/vnd.google-apps.folder') === 0)
                                <a href="{{$folderUrl}}" class="file-item-name shadow-sm d-flex flex-column align-items-center text-center">
                                    <div class="file-item-icon far fa-folder text-secondary"></div>
                                @elseif (strpos($mimeType, 'image/') === 0)
                                <a href="{{$imageUrl}}" class="file-item-name shadow-sm d-flex flex-column align-items-center text-center" target="_blank">
                                    <div class="file-item-img" style="background-image: url({{$imageUrl}});"></div>
                                @elseif (strpos($mimeType, 'video/') === 0)
                                <a href="{{$videoUrl}}" class="file-item-name shadow-sm d-flex flex-column align-items-center text-center" target="_blank">
                                    <div class="file-item-icon far fa-file-video text-secondary"></div>
                                @else
                                <a href="{{$fileUrl}}" class="file-item-name shadow-sm d-flex flex-column align-items-center text-center" target="_blank" download="download">
                                    <div class="file-item-icon far fa-file text-secondary"></div>
                                @endif
                                <span class="file-name">{{$file->getName()}}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('vendor-script')
@endsection
@section('page-script')
@endsection
<style>
    .file-name {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }
    .file-item-img{
        background-color: transparent;
        background-position: center center;
        background-size: cover;
        display: block;
        margin: 0 auto 0.75rem auto;
        width: 4rem;
        height: 4rem;
        font-size: 2.5rem;
        line-height: 4rem;
    }
    .file-item-icon{
        display: block;
        margin: 0 auto 0.75rem auto;
        width: 4rem;
        height: 4rem;
        font-size: 2.5rem;
        line-height: 4rem;
    }
</style>
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.6/css/ionicons.min.css" integrity="sha512-0/rEDduZGrqo4riUlwqyuHDQzp2D1ZCgH/gFIfjMIL5az8so6ZiXyhf1Rg8i6xsjv+z/Ubc4tt1thLigEcu6Ug==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
{{-- <div class="file-item-icon far fa-folder text-secondary">
<div class="file-item-img" style="background-image: url(https://bootdey.com/img/Content/avatar/avatar1.png);"></div>
<div class="file-item-icon far fa-file-word text-secondary">
<div class="file-item-icon far fa-file-pdf text-secondary">
<div class="file-item-icon far fa-file-audio text-secondary">
<div class="file-item-icon far fa-file-video text-secondary">
<div class="file-item-icon far fa-file-archive text-secondary">
<div class="file-item-icon far fa-file-alt text-secondary"></div>
<div class="file-item-icon fab fa-js text-secondary"></div>
<div class="file-item-icon fab fa-html5 text-secondary"></div>
<div class="file-item-icon fab fa-css3 text-secondary"></div> --}}