@extends('layouts.app')

@section('meta_title', \App\Helpers\Cms::setting('gallery_meta_title', 'Gallery - ' . \App\Helpers\Cms::siteName()))
@section('meta_description', \App\Helpers\Cms::setting('gallery_meta_description', ''))

@section('content')

@include('partials.breadcrumb', ['title' => 'Gallery'])

<section class="gallery-section section-padding fix">
    <div class="container">

        {{-- Albums Grid --}}
        @if($albums->count())
        <div class="section-title text-center mb-5">
            <h2>Browse by Album</h2>
        </div>
        <div class="row mb-5">
            @foreach($albums as $album)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4 wow fadeInUp">
                <div class="gallery-album-card">
                    <a href="{{ route('gallery.album', $album->slug) }}">
                        @if($album->cover)
                            <img src="{{ \App\Helpers\Cms::imageUrl($album->cover) }}" alt="{{ $album->name }}" class="img-fluid rounded">
                        @else
                            <div class="album-placeholder rounded d-flex align-items-center justify-content-center bg-light" style="height:200px">
                                <i class="fas fa-images fa-3x text-muted"></i>
                            </div>
                        @endif
                        <div class="album-info mt-2">
                            <h5 class="mb-0">{{ $album->name }}</h5>
                            <small class="text-muted">{{ $album->active_images_count }} images</small>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- All Images --}}
        <div class="section-title text-center mb-5">
            <h2>All Images</h2>
        </div>
        <div class="row g-3">
            @foreach($allImages as $img)
            <div class="col-xl-3 col-lg-3 col-md-4 col-6 wow fadeInUp">
                <div class="gallery-item">
                    @if($img->type === 'video' && $img->video_url)
                        <a href="{{ $img->video_url }}" class="magnific-video">
                            <img src="{{ \App\Helpers\Cms::imageUrl($img->image) }}" alt="{{ $img->title }}" class="img-fluid rounded">
                            <div class="video-play-btn">
                                <i class="fas fa-play"></i>
                            </div>
                        </a>
                    @else
                        <a href="{{ \App\Helpers\Cms::imageUrl($img->image) }}" class="magnific-image">
                            <img src="{{ \App\Helpers\Cms::imageUrl($img->image) }}" alt="{{ $img->alt_text ?: $img->title }}" class="img-fluid rounded">
                            @if($img->title || $img->caption)
                                <div class="gallery-overlay">
                                    @if($img->title)<span>{{ $img->title }}</span>@endif
                                </div>
                            @endif
                        </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-5">
            {{ $allImages->links() }}
        </div>
    </div>
</section>

@endsection
