@extends('layouts.app')

@section('meta_title', \App\Helpers\Cms::setting('restaurants_meta_title', 'Restaurants in Annapurna Region, Nepal'))
@section('meta_description', \App\Helpers\Cms::setting('restaurants_meta_description', 'Discover the best restaurants in Pokhara and the Annapurna region. Find top-rated dining experiences with complete guides.'))

@section('content')

    {{-- Header Banner --}}
    <div class="banner-header section-padding back-position-center valign bg-img bg-fixed"
         data-overlay-dark="5"
         data-background="{{ \App\Helpers\Cms::imageUrl(\App\Helpers\Cms::setting('restaurants_banner_image', ''), asset('annapurna/img/destination/food-annapurna-region.jpg')) }}">
        <div class="container">
            <div class="row">
                <div class="col-md-9 text-left caption mt-90">
                    <h5>{{ \App\Helpers\Cms::setting('restaurants_banner_subtitle', 'Dining in Pokhara & Annapurna Region') }}</h5>
                    <h1>{{ \App\Helpers\Cms::setting('restaurants_banner_title', 'Best Restaurants in Pokhara, Nepal') }}</h1>
                </div>
            </div>
        </div>
    </div>

    {{-- Sponsored Packages --}}
    @if(!empty($sponsoredPackages) && $sponsoredPackages->isNotEmpty())
    <section class="tours1 section-padding" style="background: #fffbf2; padding-bottom: 20px;">
        <div class="container">
            <div class="row justify-content-center mb-20">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>Featured Deals</span></div>
                    <div class="section-title">Sponsored <span>Dining Packages</span></div>
                </div>
            </div>
            <div class="row">
                @foreach($sponsoredPackages as $package)
                <div class="col-md-3 col-sm-6 mb-30">
                    <div class="item" style="border: 2px solid #c8a96e; border-radius: 4px;">
                        <a href="{{ route('packages.show', $package->slug) }}">
                            <div class="position-re o-hidden">
                                @if(!empty($package->photos))
                                    <img src="{{ asset('storage/' . $package->photos[0]) }}" alt="{{ $package->name }}">
                                @elseif($package->business->cover_photo)
                                    <img src="{{ \App\Helpers\Cms::imageUrl($package->business->cover_photo) }}" alt="{{ $package->name }}">
                                @else
                                    <img src="{{ asset('annapurna/img/destination/food-annapurna-region.jpg') }}" alt="{{ $package->name }}">
                                @endif
                            </div>
                        </a>
                        <span class="category" style="background: #c8a96e;"><span>Sponsored</span></span>
                        <div class="con">
                            <h5><a href="{{ route('packages.show', $package->slug) }}">{{ $package->name }}</a></h5>
                            <div class="line"></div>
                            <div class="row facilities">
                                <div class="col col-md-12"><ul>
                                    <li><i class="ti-time"></i> {{ $package->duration }}</li>
                                    <li><i class="ti-money"></i> Rs. {{ number_format($package->price) }}</li>
                                </ul></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Restaurant Listings --}}
    <section class="tours1 section-padding">
        <div class="container">

            @forelse($businesses as $business)
            <div class="row mb-30">

                {{-- Image left --}}
                <div class="col-md-4">
                    <div class="item">
                        <div class="position-re o-hidden">
                            @if(!empty($business->gallery) && count((array)$business->gallery))
                                <img src="{{ \App\Helpers\Cms::imageUrl((array)$business->gallery[0]) }}" alt="{{ $business->name }}">
                            @elseif($business->cover_photo)
                                <img src="{{ \App\Helpers\Cms::imageUrl($business->cover_photo) }}" alt="{{ $business->name }}">
                            @else
                                <img src="{{ asset('annapurna/img/destination/food-annapurna-region.jpg') }}" alt="{{ $business->name }}">
                            @endif
                        </div>
                        <span class="category"><a href="{{ route('restaurants.show', $business->slug) }}">{{ $business->subtitle ?: 'Restaurant' }}</a></span>
                    </div>
                </div>

                {{-- Text right --}}
                <div class="col-md-7">
                    <div class="country country1">

                        @if($business->subtitle)
                        <div class="section-subtitle">{{ $business->subtitle }}</div>
                        @endif

                        <div class="section-title2" style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                            <a href="{{ route('restaurants.show', $business->slug) }}">{{ $business->name }}</a>
                            @if($business->is_verified)
                            <span title="Verified Business" style="display:inline-flex;align-items:center;background:#198754;color:#fff;font-size:10px;font-weight:600;padding:1px 7px;border-radius:20px;">&#10003; Verified</span>
                            @endif
                        </div>

                        @if($business->short_description)
                        <p>{{ $business->short_description }}</p>
                        @endif

                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <ul>
                                    @if($business->phone)
                                    <li><i class="flaticon-phone-call"></i> <strong>Phone:</strong> {{ $business->phone }}</li>
                                    @endif
                                    @if($business->whatsapp)
                                    <li><i class="flaticon-phone-call"></i> <strong>WhatsApp:</strong>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $business->whatsapp) }}" target="_blank" rel="noopener noreferrer">{{ $business->whatsapp }}</a>
                                    </li>
                                    @endif
                                    @if($business->website)
                                    <li><i class="flaticon-message"></i> <strong>Website:</strong>
                                        <a href="{{ $business->website }}" target="_blank" rel="noopener noreferrer">{{ preg_replace('/^https?:\/\//', '', rtrim($business->website, '/')) }}</a>
                                    </li>
                                    @endif
                                    @if($business->email)
                                    <li><i class="flaticon-message"></i> <strong>Email:</strong>
                                        <a href="mailto:{{ $business->email }}">{{ $business->email }}</a>
                                    </li>
                                    @endif
                                    @if($business->opening_hours)
                                    <li><i class="ti-time"></i> <strong>Hours:</strong> {{ $business->opening_hours }}</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul>
                                    @if($business->average_rating)
                                    <li><i class="flaticon-star"></i> <strong>Rating:</strong> &#11088; {{ number_format($business->average_rating, 1) }} / 5</li>
                                    @endif
                                    @if($business->address)
                                    <li><i class="flaticon-placeholder"></i> <strong>Map:</strong>
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($business->name . ' ' . $business->address) }}" target="_blank" rel="noopener noreferrer">View on Google Maps</a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            @empty
            <div class="row">
                <div class="col-md-12 text-center" style="padding: 60px 0;">
                    <i class="ti-cup" style="font-size:48px;color:#ccc;display:block;margin-bottom:16px;"></i>
                    <h5 style="color:#aaa;">No restaurants listed yet. Check back soon!</h5>
                </div>
            </div>
            @endforelse

            {{-- Pagination --}}
            @if(method_exists($businesses, 'links') && $businesses->hasPages())
            <div class="row">
                <div class="col-md-12 text-center">
                    {{ $businesses->links('vendor.pagination.annapurna') }}
                </div>
            </div>
            @endif

        </div>
    </section>

@endsection
