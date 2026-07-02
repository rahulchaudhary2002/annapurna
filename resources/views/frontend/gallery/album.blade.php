@extends('layouts.app')

@section('meta_title', ($album->meta_title ?: $album->name) . ' - Gallery - ' . \App\Helpers\Cms::siteName())
@section('meta_description', $album->meta_description ?: $album->description)

@section('content')

@include('partials.breadcrumb', [
    'title' => $album->name,
    'parent' => ['title' => 'Gallery', 'url' => route('gallery.index')]
])

<section class="gallery-section section-padding fix">
    <div class="container">
        @if($album->description)
            <p class="lead text-center mb-5">{{ $album->description }}</p>
        @endif

        <div class="row g-3">
            @foreach($album->activeImages as $img)
            <div class="col-xl-3 col-lg-3 col-md-4 col-6 wow fadeInUp">
                <div class="gallery-item">
                    @if($img->type === 'video' && $img->video_url)
                        <a href="{{ $img->video_url }}" class="magnific-video">
                            <img src="{{ \App\Helpers\Cms::imageUrl($img->image) }}" alt="{{ $img->title }}" class="img-fluid rounded">
                            <div class="video-play-btn"><i class="fas fa-play"></i></div>
                        </a>
                    @else
                        <a href="{{ \App\Helpers\Cms::imageUrl($img->image) }}" class="magnific-image">
                            <img src="{{ \App\Helpers\Cms::imageUrl($img->image) }}" alt="{{ $img->alt_text ?: $img->title }}" class="img-fluid rounded">
                        </a>
                    @endif
                    @if($img->caption)
                        <p class="mt-1 small text-muted">{{ $img->caption }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        {{-- Other Albums --}}
        @if($otherAlbums->count())
        <div class="mt-5 pt-5 border-top">
            <h3 class="mb-4">More Albums</h3>
            <div class="row">
                @foreach($otherAlbums as $other)
                <div class="col-md-3 mb-4">
                    <a href="{{ route('gallery.album', $other->slug) }}" class="d-block">
                        @if($other->cover_image)
                            <img src="{{ \App\Helpers\Cms::imageUrl($other->cover_image) }}" alt="{{ $other->name }}" class="img-fluid rounded mb-2">
                        @endif
                        <h6 class="mb-0">{{ $other->name }}</h6>
                        <small class="text-muted">{{ $other->active_images_count }} images</small>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

@endsection
