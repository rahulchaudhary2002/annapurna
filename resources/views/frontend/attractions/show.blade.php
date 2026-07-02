@extends('layouts.app')

@section('meta_title', ($attraction->meta_title ?: $attraction->name) . ' - Annapurna Region')
@section('meta_description', $attraction->meta_description ?: \Illuminate\Support\Str::limit($attraction->short_description, 160))
@section('og_title', $attraction->meta_title ?: $attraction->name)

@section('content')

    {{-- Banner Header --}}
    @php
        $bannerPhoto = !empty($attraction->photos) && is_array($attraction->photos) ? $attraction->photos[0] : null;
    @endphp
    <div class="banner-header section-padding back-position-center valign bg-img bg-fixed"
         data-overlay-dark="5"
         data-background="{{ $bannerPhoto ? \App\Helpers\Cms::imageUrl($bannerPhoto) : asset('annapurna/img/slider/pokhara-valley-tour.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-9 text-left caption mt-90">
                    <h6><a href="{{ route('attractions.index') }}">Attractions</a> / {{ $attraction->name }}</h6>
                    <h1>{{ $attraction->name }} | <span style="font-size: 30px; color:#fff">Annapurna Region, Nepal</span></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('attractions.index') }}">Attractions</a></li>
                            <li class="breadcrumb-item active">{{ $attraction->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <section class="section-padding">
        <div class="container">
            <div class="row">

                {{-- Left: Description, Highlights, Photos Gallery --}}
                <div class="col-md-8">
                    <h2>{{ $attraction->name }}</h2>

                    @if($attraction->short_description)
                        <p class="lead">{{ $attraction->short_description }}</p>
                    @endif

                    @if($attraction->description)
                        <div class="mt-20">
                            {!! $attraction->description !!}
                        </div>
                    @endif

                    {{-- Highlights --}}
                    @if(!empty($attraction->highlights) && count($attraction->highlights) > 0)
                    <div class="mt-40">
                        <h4>Highlights</h4>
                        <ul class="list-unstyled mt-20">
                            @foreach($attraction->highlights as $highlight)
                            <li class="mb-10">
                                <i class="ti-check" style="color:#6a0dad; margin-right:8px;"></i>
                                {{ $highlight }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- Photos Gallery --}}
                    @if(!empty($attraction->photos) && count($attraction->photos) > 1)
                    <div class="mt-40">
                        <h4>Photo Gallery</h4>
                        <div class="row mt-20">
                            @foreach($attraction->photos as $photo)
                            <div class="col-md-4 col-sm-6 mb-20">
                                <a href="{{ \App\Helpers\Cms::imageUrl($photo) }}" target="_blank">
                                    <img src="{{ \App\Helpers\Cms::imageUrl($photo) }}"
                                         alt="{{ $attraction->name }}"
                                         class="img-fluid rounded"
                                         style="width:100%; height:180px; object-fit:cover;">
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Right Sidebar --}}
                <div class="col-md-4">
                    {{-- Quick Info Card --}}
                    <div class="p-3 rounded shadow-sm mb-30" style="background-color: #d1d1ff;">
                        <h4>Quick Info</h4>
                        <table class="table table-borderless mb-0">
                            <tbody>
                                @if($attraction->type)
                                <tr>
                                    <th><i class="ti-tag"></i> Type</th>
                                    <td>{{ ucfirst($attraction->type) }}</td>
                                </tr>
                                @endif
                                @if($attraction->location)
                                <tr>
                                    <th><i class="ti-location-pin"></i> Location</th>
                                    <td>{{ $attraction->location }}</td>
                                </tr>
                                @endif
                                @if($attraction->distance_from_pokhara)
                                <tr>
                                    <th><i class="ti-map"></i> Distance</th>
                                    <td>{{ $attraction->distance_from_pokhara }}</td>
                                </tr>
                                @endif
                                @if($attraction->entry_fee)
                                <tr>
                                    <th><i class="ti-money"></i> Entry Fee</th>
                                    <td>{{ $attraction->entry_fee }}</td>
                                </tr>
                                @endif
                                @if($attraction->opening_hours)
                                <tr>
                                    <th><i class="ti-time"></i> Hours</th>
                                    <td>{{ $attraction->opening_hours }}</td>
                                </tr>
                                @endif
                                @if($attraction->best_time_to_visit)
                                <tr>
                                    <th><i class="ti-calendar"></i> Best Time</th>
                                    <td>{{ $attraction->best_time_to_visit }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- Plan Your Visit Button --}}
                    <div class="butn-dark text-center">
                        <a href="{{ route('contact') }}"><span>Plan Your Visit <i class="ti-arrow-right"></i></span></a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Related Attractions --}}
    @if($relatedAttractions->isNotEmpty())
    <section class="tours1 section-padding bg-lightnav">
        <div class="container">
            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>Explore More</span></div>
                    <div class="section-title">Related <span>Attractions</span></div>
                </div>
            </div>
            <div class="row">
                @foreach($relatedAttractions as $related)
                <div class="col-md-4 col-sm-6 mb-30">
                    <div class="item">
                        <a href="{{ route('attractions.show', $related->slug) }}">
                            <div class="position-re o-hidden">
                                @php
                                    $relatedPhoto = !empty($related->photos) && is_array($related->photos) ? $related->photos[0] : null;
                                @endphp
                                @if($relatedPhoto)
                                    <img src="{{ \App\Helpers\Cms::imageUrl($relatedPhoto) }}" alt="{{ $related->name }}">
                                @else
                                    <img src="{{ asset('annapurna/img/rooms/3.jpg') }}" alt="{{ $related->name }}">
                                @endif
                            </div>
                            @if($related->type)
                            <span class="category">
                                <a href="{{ route('attractions.index', ['type' => $related->type]) }}">{{ ucfirst($related->type) }}</a>
                            </span>
                            @endif
                            <div class="con">
                                <h5><a href="{{ route('attractions.show', $related->slug) }}">{{ $related->name }}</a></h5>
                                @if($related->short_description)
                                    <p>{{ \Illuminate\Support\Str::limit($related->short_description, 100) }}</p>
                                @endif
                                <div class="line"></div>
                                <div class="row facilities">
                                    <div class="col col-md-12">
                                        <ul>
                                            @if($related->location)<li><i class="ti-location-pin"></i> {{ $related->location }}</li>@endif
                                            @if($related->entry_fee)<li><i class="ti-money"></i> {{ $related->entry_fee }}</li>@endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

@endsection
