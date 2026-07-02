@extends('layouts.app')

@section('meta_title', \App\Helpers\Cms::setting('treks_meta_title', 'Trek Routes - Annapurna Region'))
@section('meta_description', \App\Helpers\Cms::setting('treks_meta_description', 'Explore the best trekking routes in the Annapurna Region. From Annapurna Circuit to Base Camp treks, find complete guides and itineraries.'))

@section('content')

    <x-breadcrumb title="Trek Routes" subtitle="Annapurna Region" />

    <section class="tours1 section-padding">
        <div class="container">

            @forelse($trekRoutes as $trek)
            <div class="row mb-90">

                @if($loop->odd)
                {{-- Odd: text left, image right --}}
                <div class="col-md-7">
                    <div class="country">
                        <div class="section-subtitle">{{ $trek->difficulty ?? 'Moderate' }}{{ $trek->duration_days ? ' — ' . $trek->duration_days . ' Days' : '' }}</div>
                        <div class="section-title2">{{ $trek->name }}</div>
                        @if($trek->excerpt)<p>{{ $trek->excerpt }}</p>@endif
                        <div class="row tour-list">
                            <div class="col-md-6">
                                <ul>
                                    @if($trek->max_altitude)<li><i class="flaticon-placeholder"></i> Max Altitude: {{ $trek->max_altitude }}</li>@endif
                                    @if($trek->total_distance)<li><i class="flaticon-placeholder"></i> Distance: {{ $trek->total_distance }}</li>@endif
                                    @if($trek->start_point)<li><i class="flaticon-placeholder"></i> Start: {{ $trek->start_point }}</li>@endif
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul>
                                    @if($trek->best_season)<li><i class="flaticon-calendar"></i> Best Season: {{ $trek->best_season }}</li>@endif
                                    @if($trek->duration_days)<li><i class="flaticon-calendar"></i> Duration: {{ $trek->duration_days }} Days</li>@endif
                                    @if($trek->end_point)<li><i class="flaticon-placeholder"></i> End: {{ $trek->end_point }}</li>@endif
                                </ul>
                            </div>
                        </div>
                        @if($trek->highlights && count((array)$trek->highlights))
                        <div class="row tour-list mt-10">
                            <div class="col-md-12">
                                <ul>
                                    @foreach(array_slice((array)$trek->highlights, 0, 3) as $highlight)
                                    <li><i class="ti-check"></i> {{ $highlight }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        <div class="butn-dark mt-30 mb-30">
                            <a href="{{ route('trek-routes.show', $trek->slug) }}"><span>View Details <i class="ti-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="owl-carousel owl-theme">
                        @if(!empty($trek->gallery) && count((array)$trek->gallery))
                            @foreach((array)$trek->gallery as $img)
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="{{ \App\Helpers\Cms::imageUrl($img) }}" alt="{{ $trek->name }}">
                                </div>
                                <span class="category"><a href="{{ route('trek-routes.show', $trek->slug) }}">{{ $trek->name }}</a></span>
                            </div>
                            @endforeach
                        @elseif($trek->featured_image)
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="{{ \App\Helpers\Cms::imageUrl($trek->featured_image) }}" alt="{{ $trek->name }}">
                                </div>
                                <span class="category"><a href="{{ route('trek-routes.show', $trek->slug) }}">{{ $trek->name }}</a></span>
                            </div>
                        @else
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="{{ asset('annapurna/img/tours/annapurna-circuit.jpg') }}" alt="{{ $trek->name }}">
                                </div>
                                <span class="category"><a href="{{ route('trek-routes.show', $trek->slug) }}">{{ $trek->name }}</a></span>
                            </div>
                        @endif
                    </div>
                </div>

                @else
                {{-- Even: image left, text right --}}
                <div class="col-md-5">
                    <div class="owl-carousel owl-theme">
                        @if(!empty($trek->gallery) && count((array)$trek->gallery))
                            @foreach((array)$trek->gallery as $img)
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="{{ \App\Helpers\Cms::imageUrl($img) }}" alt="{{ $trek->name }}">
                                </div>
                                <span class="category"><a href="{{ route('trek-routes.show', $trek->slug) }}">{{ $trek->name }}</a></span>
                            </div>
                            @endforeach
                        @elseif($trek->featured_image)
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="{{ \App\Helpers\Cms::imageUrl($trek->featured_image) }}" alt="{{ $trek->name }}">
                                </div>
                                <span class="category"><a href="{{ route('trek-routes.show', $trek->slug) }}">{{ $trek->name }}</a></span>
                            </div>
                        @else
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="{{ asset('annapurna/img/tours/annapurna-circuit.jpg') }}" alt="{{ $trek->name }}">
                                </div>
                                <span class="category"><a href="{{ route('trek-routes.show', $trek->slug) }}">{{ $trek->name }}</a></span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="country country1">
                        <div class="section-subtitle">{{ $trek->difficulty ?? 'Moderate' }}{{ $trek->duration_days ? ' — ' . $trek->duration_days . ' Days' : '' }}</div>
                        <div class="section-title2">{{ $trek->name }}</div>
                        @if($trek->excerpt)<p>{{ $trek->excerpt }}</p>@endif
                        <div class="row tour-list">
                            <div class="col-md-6">
                                <ul>
                                    @if($trek->max_altitude)<li><i class="flaticon-placeholder"></i> Max Altitude: {{ $trek->max_altitude }}</li>@endif
                                    @if($trek->total_distance)<li><i class="flaticon-placeholder"></i> Distance: {{ $trek->total_distance }}</li>@endif
                                    @if($trek->start_point)<li><i class="flaticon-placeholder"></i> Start: {{ $trek->start_point }}</li>@endif
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul>
                                    @if($trek->best_season)<li><i class="flaticon-calendar"></i> Best Season: {{ $trek->best_season }}</li>@endif
                                    @if($trek->duration_days)<li><i class="flaticon-calendar"></i> Duration: {{ $trek->duration_days }} Days</li>@endif
                                    @if($trek->end_point)<li><i class="flaticon-placeholder"></i> End: {{ $trek->end_point }}</li>@endif
                                </ul>
                            </div>
                        </div>
                        @if($trek->highlights && count((array)$trek->highlights))
                        <div class="row tour-list mt-10">
                            <div class="col-md-12">
                                <ul>
                                    @foreach(array_slice((array)$trek->highlights, 0, 3) as $highlight)
                                    <li><i class="ti-check"></i> {{ $highlight }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        <div class="butn-dark mt-30 mb-30">
                            <a href="{{ route('trek-routes.show', $trek->slug) }}"><span>View Details <i class="ti-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
                @endif

            </div>
            @empty
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>No trek routes found. Check back soon!</p>
                    <div class="butn-dark mt-30"><a href="{{ route('home') }}"><span>Back to Home <i class="ti-arrow-right"></i></span></a></div>
                </div>
            </div>
            @endforelse

            {{-- Pagination --}}
            @if(method_exists($trekRoutes, 'links') && $trekRoutes->hasPages())
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="blog-pagination-wrap mt-30 mb-30">
                        {{ $trekRoutes->links() }}
                    </div>
                </div>
            </div>
            @endif

        </div>
    </section>

@endsection
