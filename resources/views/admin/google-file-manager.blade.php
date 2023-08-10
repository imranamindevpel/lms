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
                <h1 class="text-center mb-4">Lectures</h1>
                <div class="row justify-content-center">
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

                        <div class="col-md-3 mb-4">
                            <a href="{{ $mimeType === 'application/vnd.google-apps.folder' ? $folderUrl : ($mimeType === 'image/' ? $imageUrl : ($mimeType === 'video/' ? $videoUrl : $fileUrl)) }}"
                               class="file-item-name shadow-sm d-flex flex-column align-items-center text-center" 
                               target="{{ $mimeType === 'image/' || $mimeType === 'video/' ? '_blank' : '' }}"
                               {{ $mimeType !== 'application/vnd.google-apps.folder' ? 'download="download"' : '' }}>
                                <div class="file-item-icon">
                                    @if ($mimeType === 'application/vnd.google-apps.folder')
                                        <i class="far fa-folder text-secondary"></i>
                                    @elseif ($mimeType === 'image/')
                                        <div class="file-item-img" style="background-image: url('{{ $imageUrl }}');"></div>
                                    @elseif ($mimeType === 'video/')
                                        <i class="far fa-file-video text-secondary"></i>
                                    @else
                                        <i class="far fa-file text-secondary"></i>
                                    @endif
                                </div>
                                <span class="file-name">{{ $file->getName() }}</span>
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
    .file-item-img {
        background-color: transparent;
        background-position: center center;
        background-size: cover;
        display: block;
        margin: 0 auto 0.75rem auto;
        width: 4rem;
        height: 4rem;
        font-size: 2.5rem;
        line-height: 4rem;
        border-radius: 50%;
    }
    .file-item-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem auto;
        width: 4rem;
        height: 4rem;
        font-size: 2.5rem;
        line-height: 4rem;
        border-radius: 50%;
        background-color: #f8f9fa;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .file-item-icon i {
        color: #6c757d;
    }
    .file-item-name {
        text-decoration: none;
        color: #212529;
        transition: transform 0.2s ease-in-out;
    }
    .file-item-name:hover {
        transform: scale(1.05);
    }
</style>
