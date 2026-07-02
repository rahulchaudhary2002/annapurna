@extends('ggf.layouts.app')

@section('title', $service->title . ' | ' . \App\Helpers\Cms::setting('ggf_site_name', 'Guru Goraksanatha Foundation'))
@section('meta_description', $service->meta_description ?: $service->excerpt)

@section('header')
    <header class="header-image ken-burn-center" data-parallax="true" data-natural-height="500" data-natural-width="1920" data-bleed="0" data-image-src="{{ asset('ggf/media/hd-4.jpg') }}" data-offset="0">
        <div class="container">
            <h1>{{ $service->title }}</h1>
            <h2>Our Services</h2>
            <ol class="breadcrumb">
                <li><a href="{{ route('ggf.home') }}">Home</a></li>
                <li><a href="{{ route('ggf.services') }}">Services</a></li>
                <li>{{ $service->title }}</li>
            </ol>
        </div>
    </header>
@endsection

@section('content')
<section class="section-base section-color">
    <div class="container">
        <div class="row">
            {{-- LEFT SIDEBAR --}}
            <div class="col-lg-4">
                <div class="fixed-area" data-offset="80">
                    <div class="menu-inner menu-inner-vertical boxed-area">
                        <ul>
                            @foreach($otherServices as $s)
                                <li class="{{ $s->id === $service->id ? 'active' : '' }}">
                                    <a href="{{ route('ggf.services.show', $s->slug) }}">{{ $s->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <hr class="space-sm" />
                    <div class="boxed-area light">
                        <ul class="text-list text-list-bold">
                            <li><b>Address:</b><p>{{ \App\Helpers\Cms::setting('ggf_contact_address', 'Kathmandu, Nepal') }}</p></li>
                            <li><b>Email:</b><p>{{ \App\Helpers\Cms::setting('ggf_contact_email', 'gurugoraksanathafoundation@gmail.com') }}</p></li>
                            <li><b>Phone:</b><p>{{ \App\Helpers\Cms::setting('ggf_contact_phone', '+977-9851362653') }}</p></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- RIGHT CONTENT --}}
            <div class="col-lg-8">
                <hr class="space visible-md" />
                @if($service->featured_image)
                    <img src="{{ \App\Helpers\Cms::imageUrl($service->featured_image) }}" alt="{{ $service->title }}" style="width:100%; margin-bottom:30px;">
                @endif
                <h3>{{ $service->title }}</h3>
                @if($service->excerpt)<p><strong>{{ $service->excerpt }}</strong></p>@endif
                @if($service->content){!! $service->content !!}@endif

                @if($service->features && count($service->features))
                    <hr class="space-sm" />
                    <h4>Key Features</h4>
                    <ul class="check-list">
                        @foreach($service->features as $feature)
                            <li>{{ is_array($feature) ? $feature['text'] : $feature }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
