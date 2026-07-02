@extends('layouts.app')

@section('meta_title', ($activity->meta_title ?: $activity->name) . ' - Annapurna Region')
@section('meta_description', $activity->meta_description ?: \Illuminate\Support\Str::limit($activity->short_description, 160))
@section('og_title', $activity->meta_title ?: $activity->name)

@section('content')

    {{-- Banner Header --}}
    @php
        $bannerPhoto = !empty($activity->photos) && is_array($activity->photos) ? $activity->photos[0] : null;
    @endphp
    <div class="banner-header section-padding back-position-center valign bg-img bg-fixed"
         data-overlay-dark="5"
         data-background="{{ $bannerPhoto ? \App\Helpers\Cms::imageUrl($bannerPhoto) : asset('annapurna/img/slider/annapurna-range.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-9 text-left caption mt-90">
                    <h6><a href="{{ route('activities.index') }}">Activities</a> / {{ $activity->name }}</h6>
                    <h1>{{ $activity->name }} | <span style="font-size: 30px; color:#fff">Annapurna Region, Nepal</span></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('activities.index') }}">Activities</a></li>
                            <li class="breadcrumb-item active">{{ $activity->name }}</li>
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

                {{-- Left: Description, Highlights, Inclusions/Exclusions --}}
                <div class="col-md-8">
                    <h2>{{ $activity->name }}</h2>

                    @if($activity->short_description)
                        <p class="lead">{{ $activity->short_description }}</p>
                    @endif

                    @if($activity->description)
                        <div class="mt-20">
                            {!! $activity->description !!}
                        </div>
                    @endif

                    {{-- Highlights --}}
                    @if(!empty($activity->highlights) && count($activity->highlights) > 0)
                    <div class="mt-40">
                        <h4>Highlights</h4>
                        <ul class="list-unstyled mt-20">
                            @foreach($activity->highlights as $highlight)
                            <li class="mb-10">
                                <i class="ti-check" style="color:#6a0dad; margin-right:8px;"></i>
                                {{ $highlight }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- Inclusions & Exclusions --}}
                    @if((!empty($activity->inclusions) && count($activity->inclusions) > 0) || (!empty($activity->exclusions) && count($activity->exclusions) > 0))
                    <div class="row mt-40">
                        @if(!empty($activity->inclusions) && count($activity->inclusions) > 0)
                        <div class="col-md-6">
                            <h5>Inclusions</h5>
                            <ul class="list-unstyled mt-15">
                                @foreach($activity->inclusions as $item)
                                <li class="mb-8">
                                    <i class="ti-check-box" style="color:#28a745; margin-right:8px;"></i>
                                    {{ $item }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if(!empty($activity->exclusions) && count($activity->exclusions) > 0)
                        <div class="col-md-6">
                            <h5>Exclusions</h5>
                            <ul class="list-unstyled mt-15">
                                @foreach($activity->exclusions as $item)
                                <li class="mb-8">
                                    <i class="ti-close" style="color:#dc3545; margin-right:8px;"></i>
                                    {{ $item }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
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
                                @if($activity->category)
                                <tr>
                                    <th><i class="ti-tag"></i> Category</th>
                                    <td>{{ ucfirst($activity->category) }}</td>
                                </tr>
                                @endif
                                @if($activity->difficulty)
                                <tr>
                                    <th><i class="ti-flag-alt"></i> Difficulty</th>
                                    <td>{{ ucfirst($activity->difficulty) }}</td>
                                </tr>
                                @endif
                                @if($activity->duration)
                                <tr>
                                    <th><i class="ti-time"></i> Duration</th>
                                    <td>{{ $activity->duration }}</td>
                                </tr>
                                @endif
                                @if($activity->price_from)
                                <tr>
                                    <th><i class="ti-money"></i> Price From</th>
                                    <td>${{ number_format($activity->price_from, 0) }}</td>
                                </tr>
                                @endif
                                @if($activity->best_season)
                                <tr>
                                    <th><i class="ti-calendar"></i> Best Season</th>
                                    <td>{{ $activity->best_season }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- Enquiry Button --}}
                    <div class="butn-dark text-center">
                        <a href="{{ route('contact') }}"><span>Enquire Now <i class="ti-arrow-right"></i></span></a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Related Activities --}}
    @if($relatedActivities->isNotEmpty())
    <section class="tours1 section-padding bg-lightnav">
        <div class="container">
            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>Explore More</span></div>
                    <div class="section-title">Related <span>Activities</span></div>
                </div>
            </div>
            <div class="row">
                @foreach($relatedActivities as $related)
                <div class="col-md-4 col-sm-6 mb-30">
                    <div class="item">
                        <a href="{{ route('activities.show', $related->slug) }}">
                            <div class="position-re o-hidden">
                                @php
                                    $relatedPhoto = !empty($related->photos) && is_array($related->photos) ? $related->photos[0] : null;
                                @endphp
                                @if($relatedPhoto)
                                    <img src="{{ \App\Helpers\Cms::imageUrl($relatedPhoto) }}" alt="{{ $related->name }}">
                                @else
                                    <img src="{{ asset('annapurna/img/tours/annapurna-circuit.jpg') }}" alt="{{ $related->name }}">
                                @endif
                            </div>
                            @if($related->category)
                            <span class="category">
                                <a href="{{ route('activities.index', ['category' => $related->category]) }}">{{ ucfirst($related->category) }}</a>
                            </span>
                            @endif
                            <div class="con">
                                <h5><a href="{{ route('activities.show', $related->slug) }}">{{ $related->name }}</a></h5>
                                @if($related->short_description)
                                    <p>{{ \Illuminate\Support\Str::limit($related->short_description, 100) }}</p>
                                @endif
                                <div class="line"></div>
                                <div class="row facilities">
                                    <div class="col col-md-12">
                                        <ul>
                                            @if($related->difficulty)<li><i class="ti-flag-alt"></i> {{ ucfirst($related->difficulty) }}</li>@endif
                                            @if($related->duration)<li><i class="ti-time"></i> {{ $related->duration }}</li>@endif
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
