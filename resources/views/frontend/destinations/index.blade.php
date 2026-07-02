@extends('layouts.app')

@section('meta_title', \App\Helpers\Cms::setting('destinations_meta_title', 'Destinations - Annapurna Region Nepal'))
@section('meta_description', \App\Helpers\Cms::setting('destinations_meta_description', 'Explore the best destinations in the Annapurna Region. Discover trekking routes, cultural heritage, and natural wonders of Nepal.'))

@section('content')

    <x-breadcrumb title="Destinations" subtitle="Annapurna Region, Nepal" />

    <section class="tours1 section-padding">
        <div class="container">
            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>{{ \App\Helpers\Cms::setting('destinations_subtitle', 'Choose your place') }}</span></div>
                    <div class="section-title">Explore <span>Destinations</span></div>
                </div>
            </div>

            <div class="row">
                @forelse($destinations as $destination)
                <div class="col-md-4 col-sm-6 mb-30">
                    <div class="item">
                        <a href="{{ route('destinations.show', $destination->slug) }}">
                            <div class="position-re o-hidden">
                                @if($destination->featured_image)
                                    <img src="{{ \App\Helpers\Cms::imageUrl($destination->featured_image) }}" alt="{{ $destination->name }}">
                                @else
                                    <img src="{{ asset('annapurna/img/tours/annapurna-circuit.jpg') }}" alt="{{ $destination->name }}">
                                @endif
                            </div>
                            @if($destination->altitude)
                            <span class="category">
                                <a href="{{ route('destinations.show', $destination->slug) }}"><i class="ti-location-pin"></i> {{ $destination->altitude }}</a>
                            </span>
                            @endif
                            <div class="con">
                                <h5><a href="{{ route('destinations.show', $destination->slug) }}">{{ $destination->name }}</a></h5>
                                @if($destination->excerpt)<p>{{ Str::limit($destination->excerpt, 100) }}</p>@endif
                                <div class="line"></div>
                                <div class="row facilities">
                                    <div class="col col-md-12">
                                        <ul>
                                            @if($destination->region)<li><i class="ti-location-pin"></i> {{ $destination->region }}</li>@endif
                                            <li><i class="ti-calendar"></i> Best: {{ $destination->best_season ?? 'Year-round' }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-md-12 text-center">
                    <p>No destinations found yet. Check back soon!</p>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if(method_exists($destinations, 'links') && $destinations->hasPages())
            <div class="row">
                <div class="col-md-12 text-center mt-30">
                    {{ $destinations->links() }}
                </div>
            </div>
            @endif

        </div>
    </section>

@endsection
