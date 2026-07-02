@extends('layouts.app')

@section('meta_title', 'Attractions - Annapurna Region Nepal')
@section('meta_description', 'Discover the top attractions in the Annapurna Region. Explore Phewa Lake, Davis Falls, Barahi Temple, World Peace Stupa, and more natural and cultural wonders.')

@section('content')

    {{-- Banner Header --}}
    <div class="banner-header section-padding back-position-center valign bg-img bg-fixed"
         data-overlay-dark="5"
         data-background="{{ asset('annapurna/img/slider/pokhara-valley-tour.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-9 text-left caption mt-90">
                    <h6><a href="{{ route('home') }}">Home</a> / Attractions</h6>
                    <h1>Attractions | <span style="font-size: 30px; color:#fff">Annapurna Region, Nepal</span></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Attractions</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Attractions Section --}}
    <section class="tours1 section-padding">
        <div class="container">
            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>Places to See</span></div>
                    <div class="section-title">Explore <span>Attractions</span></div>
                </div>
            </div>

            {{-- Type Filter Tabs --}}
            <div class="row justify-content-center mb-40">
                <div class="col-md-10 text-center">
                    <ul class="nav nav-pills justify-content-center" style="gap: 8px;">
                        <li class="nav-item">
                            <a class="nav-link {{ !request('type') ? 'active' : '' }}"
                               href="{{ route('attractions.index') }}"
                               style="{{ !request('type') ? 'background-color:#6a0dad; color:#fff;' : 'border:1px solid #6a0dad; color:#6a0dad;' }}">
                                All
                            </a>
                        </li>
                        @foreach(['natural' => 'Natural', 'cultural' => 'Cultural', 'religious' => 'Religious', 'historical' => 'Historical', 'adventure' => 'Adventure'] as $value => $label)
                        <li class="nav-item">
                            <a class="nav-link {{ request('type') === $value ? 'active' : '' }}"
                               href="{{ route('attractions.index', ['type' => $value]) }}"
                               style="{{ request('type') === $value ? 'background-color:#6a0dad; color:#fff;' : 'border:1px solid #6a0dad; color:#6a0dad;' }}">
                                {{ $label }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Attraction Cards --}}
            <div class="row">
                @forelse($attractions as $attraction)
                <div class="col-md-4 col-sm-6 mb-30">
                    <div class="item">
                        <a href="{{ route('attractions.show', $attraction->slug) }}">
                            <div class="position-re o-hidden">
                                @php
                                    $photo = !empty($attraction->photos) && is_array($attraction->photos) ? $attraction->photos[0] : null;
                                @endphp
                                @if($photo)
                                    <img src="{{ \App\Helpers\Cms::imageUrl($photo) }}" alt="{{ $attraction->name }}">
                                @else
                                    <img src="{{ asset('annapurna/img/rooms/3.jpg') }}" alt="{{ $attraction->name }}">
                                @endif
                            </div>

                            @if($attraction->type)
                            <span class="category">
                                <a href="{{ route('attractions.index', ['type' => $attraction->type]) }}">
                                    {{ ucfirst($attraction->type) }}
                                </a>
                            </span>
                            @endif

                            <div class="con">
                                <h5><a href="{{ route('attractions.show', $attraction->slug) }}">{{ $attraction->name }}</a></h5>
                                @if($attraction->short_description)
                                    <p>{{ \Illuminate\Support\Str::limit($attraction->short_description, 100) }}</p>
                                @endif
                                <div class="line"></div>
                                <div class="row facilities">
                                    <div class="col col-md-12">
                                        <ul>
                                            @if($attraction->location)
                                                <li><i class="ti-location-pin"></i> {{ $attraction->location }}</li>
                                            @endif
                                            @if($attraction->best_time_to_visit)
                                                <li><i class="ti-time"></i> {{ $attraction->best_time_to_visit }}</li>
                                            @endif
                                            @if($attraction->entry_fee)
                                                <li><i class="ti-money"></i> {{ $attraction->entry_fee }}</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-md-12 text-center">
                    <p>No attractions found yet. Check back soon!</p>
                </div>
                @endforelse
            </div>

        </div>
    </section>

@endsection
