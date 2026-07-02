@extends('layouts.app')

@section('meta_title', ($service->meta_title ?: $service->title) . ' - ' . \App\Helpers\Cms::siteName())
@section('meta_description', $service->meta_description ?: $service->excerpt)

@section('content')

@include('partials.breadcrumb', [
    'title' => $service->title,
    'bgImage' => $service->featured_image ? \App\Helpers\Cms::imageUrl($service->featured_image) : null,
    'parent' => ['title' => 'Services', 'url' => route('services.index')]
])

<section class="service-details-section section-padding fix">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="service-details-content">
                    @if($service->featured_image)
                        <img src="{{ \App\Helpers\Cms::imageUrl($service->featured_image) }}" alt="{{ $service->title }}" class="img-fluid rounded mb-4">
                    @endif

                    <h2>{{ $service->title }}</h2>

                    @if($service->excerpt)
                        <p class="lead">{{ $service->excerpt }}</p>
                    @endif

                    <div class="service-content">
                        {!! $service->content !!}
                    </div>

                    @if($service->features && count($service->features))
                        <div class="service-features mt-4">
                            <h4>Key Features</h4>
                            <div class="row">
                                @foreach($service->features as $feature)
                                    <div class="col-md-6 mb-2">
                                        <div class="feature-item d-flex align-items-start">
                                            <i class="{{ $feature['icon'] ?? 'fas fa-check-circle' }} text-primary me-2 mt-1"></i>
                                            <span>{{ $feature['text'] ?? $feature }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($service->gallery && count($service->gallery))
                        <div class="service-gallery mt-5">
                            <h4>Gallery</h4>
                            <div class="row g-3">
                                @foreach($service->gallery as $img)
                                <div class="col-md-4">
                                    <a href="{{ \App\Helpers\Cms::imageUrl($img['image'] ?? $img) }}" class="magnific-image">
                                        <img src="{{ \App\Helpers\Cms::imageUrl($img['image'] ?? $img) }}" alt="{{ $img['caption'] ?? $service->title }}" class="img-fluid rounded">
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="service-sidebar">
                    {{-- Other Services --}}
                    @if($otherServices->count())
                    <div class="widget mb-4">
                        <h4 class="widget-title">All Services</h4>
                        <ul class="service-list list-unstyled">
                            @foreach($otherServices as $s)
                                <li class="{{ $s->id === $service->id ? 'active' : '' }}">
                                    <a href="{{ route('services.show', $s->slug) }}">
                                        @if($s->icon)<i class="{{ $s->icon }} me-2"></i>@endif
                                        {{ $s->title }}
                                        <i class="fas fa-chevron-right ms-auto"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- CTA --}}
                    <div class="widget cta-widget p-4 rounded" style="background: var(--theme-color)">
                        <h4 class="text-white">Need This Service?</h4>
                        <p class="text-white-50">Get in touch with us today and let's discuss your project.</p>
                        <a href="{{ route('contact') }}" class="btn btn-light w-100">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
