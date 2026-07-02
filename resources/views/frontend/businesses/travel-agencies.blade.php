@extends('layouts.app')

@section('meta_title', \App\Helpers\Cms::setting('agencies_meta_title', 'Travel Agencies in Annapurna Region, Nepal'))
@section('meta_description', \App\Helpers\Cms::setting('agencies_meta_description', 'Find top travel agencies in the Annapurna Region of Nepal. Plan your trekking, tours, and adventure trips with trusted local agencies.'))

@section('content')

    {{-- Header Banner --}}
    <div class="banner-header section-padding back-position-center valign bg-img bg-fixed"
         data-overlay-dark="5"
         data-background="{{ asset('annapurna/img/slider/pokhara-valley-tour.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-9 text-left caption mt-90">
                    <h5>{{ \App\Helpers\Cms::setting('agencies_banner_subtitle', 'Travel Agency') }}</h5>
                    <h1>{{ \App\Helpers\Cms::setting('agencies_banner_title', 'Top Travel Agency in Nepal') }}</h1>
                </div>
            </div>
        </div>
    </div>

    @if(!empty($sponsoredPackages) && $sponsoredPackages->isNotEmpty())
    <section class="tours1 section-padding" style="background: #fffbf2; padding-bottom: 20px;">
        <div class="container">
            <div class="row justify-content-center mb-20">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>Featured Deals</span></div>
                    <div class="section-title">Sponsored <span>Packages</span></div>
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
                                    <img src="{{ asset('annapurna/img/tours/annapurna-circuit.jpg') }}" alt="{{ $package->name }}">
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

    <section class="tours1 section-padding">
        <div class="container">

            @forelse($businesses as $business)
            <div class="row mb-90">

                @if($loop->odd)
                {{-- Odd: text left, image right --}}
                <div class="col-md-7">
                    <div class="country">
                        @if($business->subtitle)<div class="section-subtitle">{{ $business->subtitle }}</div>@endif
                        <div class="section-title2" style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                            <a href="{{ route('businesses.show', $business->slug) }}">{{ $business->name }}</a>
                            @if($business->is_verified)<span title="Verified Business" style="display:inline-flex;align-items:center;background:#198754;color:#fff;font-size:10px;font-weight:600;padding:1px 7px;border-radius:20px;">✓ Verified</span>@endif
                        </div>
                        @if($business->short_description)<p>{{ $business->short_description }}</p>@endif
                        @if($business->features && count((array)$business->features))
                        <div class="row tour-list mb-20">
                            <div class="col-md-12">
                                <ul>
                                    @foreach(array_slice((array)$business->features, 0, 4) as $feature)
                                    <li><i class="ti-check"></i> {{ $feature }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        <div class="row tour-list">
                            <div class="col-md-6">
                                <ul>
                                    @if($business->phone)
                                    <li><i class="flaticon-phone-call"></i>
                                        <a href="tel:{{ $business->phone }}" class="link-btn">{{ $business->phone }}</a>
                                    </li>
                                    @endif
                                    @if($business->whatsapp)
                                    <li><i class="flaticon-phone-call"></i>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $business->whatsapp) }}" target="_blank" rel="noopener noreferrer" class="link-btn">WhatsApp: {{ $business->whatsapp }}</a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul>
                                    @if($business->website)
                                    <li><i class="flaticon-placeholder"></i>
                                        <a href="{{ $business->website }}" target="_blank" rel="noopener noreferrer" class="link-btn">{{ $business->website }}</a>
                                    </li>
                                    @endif
                                    @if($business->email)
                                    <li><i class="flaticon-message"></i>
                                        <a href="mailto:{{ $business->email }}" class="link-btn">{{ $business->email }}</a>
                                    </li>
                                    @endif
                                    @if($business->address)
                                    <li><i class="flaticon-placeholder"></i> {{ $business->address }}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="butn-dark mt-30 mb-30">
                            <a href="{{ route('businesses.show', $business->slug) }}"><span>View Details <i class="ti-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="owl-carousel owl-theme">
                        @if(!empty($business->gallery) && count((array)$business->gallery))
                            @foreach((array)$business->gallery as $img)
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="{{ \App\Helpers\Cms::imageUrl($img) }}" alt="{{ $business->name }}">
                                </div>
                                <span class="category"><a href="{{ route('businesses.show', $business->slug) }}">{{ $business->name }}</a></span>
                            </div>
                            @endforeach
                        @elseif($business->cover_photo)
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="{{ \App\Helpers\Cms::imageUrl($business->cover_photo) }}" alt="{{ $business->name }}">
                                </div>
                                <span class="category"><a href="{{ route('businesses.show', $business->slug) }}">{{ $business->name }}</a></span>
                            </div>
                        @else
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="{{ asset('annapurna/img/destination/annapurna-circuit1.jpg') }}" alt="{{ $business->name }}">
                                </div>
                                <span class="category"><a href="{{ route('businesses.show', $business->slug) }}">{{ $business->name }}</a></span>
                            </div>
                        @endif
                    </div>
                </div>

                @else
                {{-- Even: image left, text right --}}
                <div class="col-md-5">
                    <div class="owl-carousel owl-theme">
                        @if(!empty($business->gallery) && count((array)$business->gallery))
                            @foreach((array)$business->gallery as $img)
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="{{ \App\Helpers\Cms::imageUrl($img) }}" alt="{{ $business->name }}">
                                </div>
                                <span class="category"><a href="{{ route('businesses.show', $business->slug) }}">{{ $business->name }}</a></span>
                            </div>
                            @endforeach
                        @elseif($business->cover_photo)
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="{{ \App\Helpers\Cms::imageUrl($business->cover_photo) }}" alt="{{ $business->name }}">
                                </div>
                                <span class="category"><a href="{{ route('businesses.show', $business->slug) }}">{{ $business->name }}</a></span>
                            </div>
                        @else
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="{{ asset('annapurna/img/destination/annapurna-circuit1.jpg') }}" alt="{{ $business->name }}">
                                </div>
                                <span class="category"><a href="{{ route('businesses.show', $business->slug) }}">{{ $business->name }}</a></span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="country country1">
                        @if($business->subtitle)<div class="section-subtitle">{{ $business->subtitle }}</div>@endif
                        <div class="section-title2" style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                            <a href="{{ route('businesses.show', $business->slug) }}">{{ $business->name }}</a>
                            @if($business->is_verified)<span title="Verified Business" style="display:inline-flex;align-items:center;background:#198754;color:#fff;font-size:10px;font-weight:600;padding:1px 7px;border-radius:20px;">✓ Verified</span>@endif
                        </div>
                        @if($business->short_description)<p>{{ $business->short_description }}</p>@endif
                        @if($business->features && count((array)$business->features))
                        <div class="row tour-list mb-20">
                            <div class="col-md-12">
                                <ul>
                                    @foreach(array_slice((array)$business->features, 0, 4) as $feature)
                                    <li><i class="ti-check"></i> {{ $feature }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        <div class="row tour-list">
                            <div class="col-md-6">
                                <ul>
                                    @if($business->phone)
                                    <li><i class="flaticon-phone-call"></i>
                                        <a href="tel:{{ $business->phone }}" class="link-btn">{{ $business->phone }}</a>
                                    </li>
                                    @endif
                                    @if($business->whatsapp)
                                    <li><i class="flaticon-phone-call"></i>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $business->whatsapp) }}" target="_blank" rel="noopener noreferrer" class="link-btn">WhatsApp: {{ $business->whatsapp }}</a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul>
                                    @if($business->website)
                                    <li><i class="flaticon-placeholder"></i>
                                        <a href="{{ $business->website }}" target="_blank" rel="noopener noreferrer" class="link-btn">{{ $business->website }}</a>
                                    </li>
                                    @endif
                                    @if($business->email)
                                    <li><i class="flaticon-message"></i>
                                        <a href="mailto:{{ $business->email }}" class="link-btn">{{ $business->email }}</a>
                                    </li>
                                    @endif
                                    @if($business->address)
                                    <li><i class="flaticon-placeholder"></i> {{ $business->address }}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="butn-dark mt-30 mb-30">
                            <a href="{{ route('businesses.show', $business->slug) }}"><span>View Details <i class="ti-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
                @endif

            </div>
            @empty
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>No travel agencies found. Check back soon!</p>
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
