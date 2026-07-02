@extends('layouts.app')

@section('meta_title', \App\Helpers\Cms::setting('services_meta_title', 'Services - ' . \App\Helpers\Cms::siteName()))
@section('meta_description', \App\Helpers\Cms::setting('services_meta_description', ''))

@section('content')

@php
    $pageSubtitle = \App\Helpers\Cms::setting('services_page_subtitle', 'Our Services');
    $pageTitle = \App\Helpers\Cms::setting('services_page_title', 'Digital Services Built Around Growth');
    $pageDescription = \App\Helpers\Cms::setting('services_page_description', '');
    $breadcrumbImage = \App\Helpers\Cms::setting('services_breadcrumb_image');
@endphp

@include('partials.breadcrumb', [
    'title' => \App\Helpers\Cms::setting('services_breadcrumb_title', 'Services'),
    'bgImage' => $breadcrumbImage ? \App\Helpers\Cms::imageUrl($breadcrumbImage) : null,
])

<section class="service-section section-padding fix">
    <div class="container">
        <div class="section-title text-center mb-5">
            <span class="sub-title">{{ $pageSubtitle }}</span>
            <h2>{{ $pageTitle }}</h2>
            @if($pageDescription)
                <p class="mt-3">{{ $pageDescription }}</p>
            @endif
        </div>
        <div class="row">
            @foreach($services as $service)
            <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                <div class="service-box-items">
                    <div class="icon">
                        @if($service->icon)
                            <i class="{{ $service->icon }}"></i>
                        @elseif($service->image)
                            <img src="{{ \App\Helpers\Cms::imageUrl($service->image) }}" alt="{{ $service->title }}">
                        @endif
                    </div>
                    <div class="content">
                        @if($service->category)
                            <span class="category-label">{{ $service->category->name }}</span>
                        @endif
                        <h4><a href="{{ route('services.show', $service->slug) }}">{{ $service->title }}</a></h4>
                        <p>{{ $service->excerpt }}</p>
                        @if($service->features)
                            <ul class="feature-list mb-3">
                                @foreach(array_slice($service->features, 0, 3) as $feature)
                                    <li><i class="fas fa-check text-success me-2"></i>{{ $feature['text'] ?? $feature }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <a href="{{ route('services.show', $service->slug) }}" class="read-more">
                            Learn More <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@if($testimonials->count())
<section class="testimonials-section section-padding bg-light">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>What Our Clients Say</h2>
        </div>
        <div class="swiper testimonial-slider">
            <div class="swiper-wrapper">
                @foreach($testimonials as $t)
                <div class="swiper-slide">
                    <div class="testimonial-box-items">
                        <div class="rating mb-2">
                            @for($i = 0; $i < $t->rating; $i++)<i class="fas fa-star text-warning"></i>@endfor
                        </div>
                        <p>{{ $t->content }}</p>
                        <div class="d-flex align-items-center mt-3">
                            @if($t->image)
                                <img src="{{ \App\Helpers\Cms::imageUrl($t->image) }}" class="rounded-circle me-3" width="50" height="50" alt="{{ $t->name }}">
                            @endif
                            <div>
                                <strong>{{ $t->name }}</strong>
                                <small class="d-block text-muted">{{ $t->position }}@if($t->company), {{ $t->company }}@endif</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
@endif

@endsection
