@extends('layouts.app')

@section('meta_title', 'Tour & Travel Packages — Annapurna Region')
@section('meta_description', 'Browse curated tour and travel packages from hotels, travel agencies and guides in the Annapurna region.')

@section('content')

    {{-- Header Banner --}}
    <div class="banner-header section-padding valign bg-img bg-fixed"
         data-overlay-dark="5"
         data-background="{{ asset('annapurna/img/slider/pokhara-valley-tour.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-9 text-left caption mt-90">
                    <h6><a href="{{ route('home') }}">Home</a> / Packages</h6>
                    <h1>Tour &amp; Travel Packages</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Packages</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Sponsored / Featured --}}
    @if($sponsored->isNotEmpty())
    <section class="section-padding" style="background: #fffbf2; border-bottom: 1px solid #f0e8d0;">
        <div class="container">
            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>Featured</span></div>
                    <div class="section-title">Sponsored <span>Packages</span></div>
                </div>
            </div>
            <div class="row">
                @foreach($sponsored as $pkg)
                <div class="col-md-4 col-sm-6 mb-30">
                    @include('packages.partials.card', ['package' => $pkg, 'featured' => true])
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- All Packages --}}
    <section class="tours1 section-padding">
        <div class="container">

            {{-- Filters --}}
            <form method="GET" action="{{ route('packages.index') }}" class="mb-40">
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-10">
                        <select name="type" class="form-control" onchange="this.form.submit()" style="height: 42px; border-radius: 4px; border: 1px solid #ddd; padding: 0 12px; font-size: 14px;">
                            <option value="">All Types</option>
                            <option value="travel_agency" {{ request('type') === 'travel_agency' ? 'selected' : '' }}>Travel Agency</option>
                            <option value="hotel" {{ request('type') === 'hotel' ? 'selected' : '' }}>Hotel</option>
                            <option value="guide" {{ request('type') === 'guide' ? 'selected' : '' }}>Guide</option>
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-6 mb-10">
                        <input type="number" name="min_price" value="{{ request('min_price') }}"
                               placeholder="Min Price (Rs.)" class="form-control"
                               style="height: 42px; border-radius: 4px; border: 1px solid #ddd; padding: 0 12px; font-size: 14px;">
                    </div>
                    <div class="col-md-2 col-sm-6 mb-10">
                        <input type="number" name="max_price" value="{{ request('max_price') }}"
                               placeholder="Max Price (Rs.)" class="form-control"
                               style="height: 42px; border-radius: 4px; border: 1px solid #ddd; padding: 0 12px; font-size: 14px;">
                    </div>
                    <div class="col-md-2 col-sm-6 mb-10">
                        <input type="number" name="duration" value="{{ request('duration') }}"
                               placeholder="Max Days" class="form-control"
                               style="height: 42px; border-radius: 4px; border: 1px solid #ddd; padding: 0 12px; font-size: 14px;">
                    </div>
                    <div class="col-md-2 col-sm-6 mb-10">
                        <button type="submit" class="btn btn-primary" style="height: 42px; width: 100%;">Filter</button>
                    </div>
                    @if(request()->hasAny(['type','min_price','max_price','duration']))
                    <div class="col-md-1 col-sm-6 mb-10">
                        <a href="{{ route('packages.index') }}" class="btn btn-secondary" style="height: 42px; display: flex; align-items: center;">Clear</a>
                    </div>
                    @endif
                </div>
            </form>

            @if($packages->isEmpty())
                <div class="text-center" style="padding: 60px 0;">
                    <i class="ti-package" style="font-size: 48px; color: #ccc;"></i>
                    <p style="color: #888; margin-top: 16px; font-size: 16px;">No packages found matching your criteria.</p>
                    <a href="{{ route('packages.index') }}" class="butn-dark mt-20 d-inline-block"><span>View All Packages</span></a>
                </div>
            @else
                <div class="row">
                    @foreach($packages as $package)
                    <div class="col-md-4 col-sm-6 mb-30">
                        @include('packages.partials.card', ['package' => $package, 'featured' => false])
                    </div>
                    @endforeach
                </div>

                <div class="row mt-30">
                    <div class="col-md-12">
                        {{ $packages->links() }}
                    </div>
                </div>
            @endif

        </div>
    </section>

@endsection
