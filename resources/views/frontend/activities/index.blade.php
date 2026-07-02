@extends('layouts.app')

@section('meta_title', 'Activities - Annapurna Region Nepal')
@section('meta_description', 'Discover exciting activities in the Annapurna Region. From trekking and rafting to paragliding, bungee jumping, cycling, and yoga — adventure awaits.')

@section('content')

    {{-- Banner Header --}}
    <div class="banner-header section-padding back-position-center valign bg-img bg-fixed"
         data-overlay-dark="5"
         data-background="{{ asset('annapurna/img/slider/annapurna-range.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-9 text-left caption mt-90">
                    <h6><a href="{{ route('home') }}">Home</a> / Activities</h6>
                    <h1>Activities | <span style="font-size: 30px; color:#fff">Annapurna Region, Nepal</span></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Activities</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Activities Section --}}
    <section class="tours1 section-padding">
        <div class="container">
            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>Things to Do</span></div>
                    <div class="section-title">Explore <span>Activities</span></div>
                </div>
            </div>

            {{-- Category Filter Tabs --}}
            <div class="row justify-content-center mb-40">
                <div class="col-md-10 text-center">
                    <ul class="nav nav-pills justify-content-center" style="gap: 8px;">
                        <li class="nav-item">
                            <a class="nav-link {{ !request('category') ? 'active' : '' }}"
                               href="{{ route('activities.index') }}"
                               style="{{ !request('category') ? 'background-color:#6a0dad; color:#fff;' : 'border:1px solid #6a0dad; color:#6a0dad;' }}">
                                All
                            </a>
                        </li>
                        @foreach(['water' => 'Water', 'air' => 'Air', 'land' => 'Land', 'cultural' => 'Cultural'] as $value => $label)
                        <li class="nav-item">
                            <a class="nav-link {{ request('category') === $value ? 'active' : '' }}"
                               href="{{ route('activities.index', ['category' => $value]) }}"
                               style="{{ request('category') === $value ? 'background-color:#6a0dad; color:#fff;' : 'border:1px solid #6a0dad; color:#6a0dad;' }}">
                                {{ $label }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Activity Cards --}}
            <div class="row">
                @forelse($activities as $activity)
                <div class="col-md-4 col-sm-6 mb-30">
                    <div class="item">
                        <a href="{{ route('activities.show', $activity->slug) }}">
                            <div class="position-re o-hidden">
                                @php
                                    $photo = !empty($activity->photos) ? (is_array($activity->photos) ? $activity->photos[0] : null) : null;
                                @endphp
                                @if($photo)
                                    <img src="{{ \App\Helpers\Cms::imageUrl($photo) }}" alt="{{ $activity->name }}">
                                @else
                                    <img src="{{ asset('annapurna/img/tours/annapurna-circuit.jpg') }}" alt="{{ $activity->name }}">
                                @endif
                            </div>

                            @if($activity->category)
                            <span class="category">
                                <a href="{{ route('activities.index', ['category' => $activity->category]) }}">
                                    {{ ucfirst($activity->category) }}
                                </a>
                            </span>
                            @endif

                            <div class="con">
                                <h5><a href="{{ route('activities.show', $activity->slug) }}">{{ $activity->name }}</a></h5>
                                @if($activity->short_description)
                                    <p>{{ \Illuminate\Support\Str::limit($activity->short_description, 100) }}</p>
                                @endif
                                <div class="line"></div>
                                <div class="row facilities">
                                    <div class="col col-md-12">
                                        <ul>
                                            @if($activity->difficulty)
                                                <li>
                                                    <i class="ti-flag-alt"></i>
                                                    {{ ucfirst($activity->difficulty) }}
                                                </li>
                                            @endif
                                            @if($activity->duration)
                                                <li><i class="ti-time"></i> {{ $activity->duration }}</li>
                                            @endif
                                            @if($activity->price_from)
                                                <li><i class="ti-tag"></i> From ${{ number_format($activity->price_from, 0) }}</li>
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
                    <p>No activities found yet. Check back soon!</p>
                </div>
                @endforelse
            </div>

        </div>
    </section>

@endsection
