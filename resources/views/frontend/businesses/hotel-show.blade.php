@extends('layouts.app')

@section('meta_title', ($business->meta_title ?: $business->name) . ' - Hotels in Annapurna Region')
@section('meta_description', $business->meta_description ?: Str::limit($business->short_description ?? $business->name, 160))
@section('og_title', $business->meta_title ?: $business->name)

@section('content')

    {{-- ===== Banner Header ===== --}}
    <div class="banner-header section-padding back-position-center valign bg-img bg-fixed"
         data-overlay-dark="5"
         data-background="{{ $business->cover_photo ? \App\Helpers\Cms::imageUrl($business->cover_photo) : asset('annapurna/img/slider/pokhara-valley-tour.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-9 text-left caption mt-90">
                    <h5><a href="{{ route('hotels.index') }}">Hotels in Pokhara</a> / {{ $business->name }}</h5>
                    <h1>{{ $business->name }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('hotels.index') }}">Hotels</a></li>
                            <li class="breadcrumb-item active">{{ $business->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Overview: Info + Gallery ===== --}}
    <section class="tours1 section-padding">
        <div class="container">
            <div class="row mb-60">

                {{-- Left: Hotel Info --}}
                <div class="col-md-7">
                    <div class="country">

                        @if($business->subtitle)
                        <div class="section-subtitle">{{ $business->subtitle }}</div>
                        @endif

                        <div class="section-title2" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                            {{ $business->name }}
                            @if($business->is_verified)
                            <span title="Verified Business" style="display:inline-flex;align-items:center;background:#198754;color:#fff;font-size:11px;font-weight:600;padding:2px 10px;border-radius:20px;letter-spacing:.5px;">&#10003; Verified</span>
                            @endif
                        </div>

                        {{-- Star Rating --}}
                        @php $avgRating = $business->average_rating; $reviewCount = $business->review_count; @endphp
                        @if($reviewCount > 0)
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;">
                            <span style="color:#f4b942;font-size:20px;letter-spacing:2px;">
                                @for($i=1;$i<=5;$i++)
                                    {!! $i <= round($avgRating) ? '★' : '☆' !!}
                                @endfor
                            </span>
                            <span style="font-weight:700;color:#333;font-size:16px;">{{ number_format($avgRating,1) }}</span>
                            <span style="color:#888;font-size:13px;">({{ $reviewCount }} {{ Str::plural('review', $reviewCount) }})</span>
                        </div>
                        @endif

                        @if($business->short_description)
                        <p>{{ $business->short_description }}</p>
                        @endif

                        {{-- Contact Details --}}
                        <div class="row tour-list mt-20">
                            <div class="col-md-6">
                                <ul>
                                    @if($business->phone)
                                    <li><i class="flaticon-phone-call"></i>
                                        <a href="tel:{{ $business->phone }}" class="link-btn">Contact: {{ $business->phone }}</a>
                                    </li>
                                    @endif
                                    @if($business->whatsapp)
                                    <li><i class="flaticon-phone-call"></i>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $business->whatsapp) }}" target="_blank" rel="noopener noreferrer" class="link-btn">WhatsApp: {{ $business->whatsapp }}</a>
                                    </li>
                                    @endif
                                    @if($business->address)
                                    <li><i class="flaticon-placeholder"></i> {{ $business->address }}</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul>
                                    @if($business->website)
                                    <li><i class="ti-world"></i>
                                        <a href="{{ $business->website }}" target="_blank" rel="noopener noreferrer" class="link-btn">{{ preg_replace('/^https?:\/\//', '', rtrim($business->website, '/')) }}</a>
                                    </li>
                                    @endif
                                    @if($business->email)
                                    <li><i class="flaticon-message"></i>
                                        <a href="mailto:{{ $business->email }}" class="link-btn">{{ $business->email }}</a>
                                    </li>
                                    @endif
                                    @if($business->opening_hours)
                                    <li><i class="ti-time"></i> {{ $business->opening_hours }}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        {{-- Top Features (first 6) --}}
                        @if(!empty($business->features) && count((array)$business->features) > 0)
                        <div class="row tour-list mt-20">
                            <div class="col-md-12">
                                <ul>
                                    @foreach(array_slice((array)$business->features, 0, 6) as $feature)
                                    <li><i class="ti-check" style="color:#c8a96e;"></i>
                                        {{ is_array($feature) ? ($feature['text'] ?? $feature['name'] ?? '') : $feature }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        <div class="butn-dark mt-30 mb-30">
                            <a href="#enquiry"><span>Enquire Now <i class="ti-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>

                {{-- Right: Gallery Carousel --}}
                <div class="col-md-5">
                    <div class="owl-carousel owl-theme">
                        @if(!empty($business->gallery) && count((array)$business->gallery) > 0)
                            @foreach((array)$business->gallery as $img)
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="{{ \App\Helpers\Cms::imageUrl($img) }}" alt="{{ $business->name }}">
                                </div>
                                <span class="category"><a href="#">{{ $business->name }}</a></span>
                            </div>
                            @endforeach
                        @elseif($business->cover_photo)
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="{{ \App\Helpers\Cms::imageUrl($business->cover_photo) }}" alt="{{ $business->name }}">
                                </div>
                                <span class="category"><a href="#">{{ $business->name }}</a></span>
                            </div>
                        @else
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <img src="{{ asset('annapurna/img/hotels/hotel-kantipur-annapurna-region.jpg') }}" alt="{{ $business->name }}">
                                </div>
                                <span class="category"><a href="#">Hotel Photo</a></span>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== About / Full Description ===== --}}
    @if($business->description)
    <section class="section-padding bg-lightnav">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="section-subtitle"><span>About the Hotel</span></div>
                    <div class="section-title2">About <span>{{ Str::before($business->name, ' ') }}</span></div>

                    <div id="shortText">
                        {!! Str::words(strip_tags($business->description), 120, '...') !!}
                    </div>
                    @if(str_word_count(strip_tags($business->description)) > 120)
                    <div id="moreText" style="display:none;">
                        {!! $business->description !!}
                    </div>
                    <button class="btn btn-primary mt-10 mb-20" id="readMoreBtn" style="background:#c8a96e;border:none;padding:8px 20px;border-radius:4px;color:#fff;cursor:pointer;">Read More</button>
                    @endif
                </div>

                {{-- Contact Card Sidebar --}}
                <div class="col-md-4">
                    <div class="widget clearfix" style="background:#f9f7f2;border:1px solid #e8e2d4;padding:28px;border-radius:8px;margin-top:10px;">
                        <h4 style="margin-bottom:18px;color:#0f2454;">Contact {{ $business->name }}</h4>
                        @if($business->phone)
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                            <i class="flaticon-phone-call" style="color:#c8a96e;font-size:18px;"></i>
                            <a href="tel:{{ $business->phone }}" style="color:#333;font-size:14px;">{{ $business->phone }}</a>
                        </div>
                        @endif
                        @if($business->whatsapp)
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                            <i class="flaticon-phone-call" style="color:#25D366;font-size:18px;"></i>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $business->whatsapp) }}" target="_blank" rel="noopener noreferrer" style="color:#333;font-size:14px;">{{ $business->whatsapp }}</a>
                        </div>
                        @endif
                        @if($business->email)
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                            <i class="flaticon-message" style="color:#c8a96e;font-size:18px;"></i>
                            <a href="mailto:{{ $business->email }}" style="color:#333;font-size:14px;">{{ $business->email }}</a>
                        </div>
                        @endif
                        @if($business->address)
                        <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:16px;">
                            <i class="flaticon-placeholder" style="color:#c8a96e;font-size:18px;margin-top:2px;"></i>
                            <span style="color:#555;font-size:14px;">{{ $business->address }}</span>
                        </div>
                        @endif
                        @if($business->address)
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($business->name . ' ' . $business->address) }}" target="_blank" rel="noopener noreferrer" style="display:block;text-align:center;background:#0f2454;color:#fff;padding:10px;border-radius:4px;font-size:13px;font-weight:600;margin-bottom:10px;text-decoration:none;">
                            <i class="flaticon-placeholder"></i> View on Google Maps
                        </a>
                        @endif
                        <div class="butn-dark" style="margin-top:10px;">
                            <a href="#enquiry"><span>Send Enquiry <i class="ti-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ===== Amenities & Features ===== --}}
    @if(!empty($business->features) && count((array)$business->features) > 0)
    <section class="tours1 section-padding">
        <div class="container">
            <div class="row justify-content-center mb-40">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>What We Offer</span></div>
                    <div class="section-title">Amenities &amp; <span>Services</span></div>
                </div>
            </div>
            <div class="row">
                @foreach((array)$business->features as $feature)
                @php $featName = is_array($feature) ? ($feature['text'] ?? $feature['name'] ?? '') : $feature; @endphp
                @if($featName)
                <div class="col-md-3 col-sm-6 mb-20">
                    <div style="display:flex;align-items:center;gap:10px;padding:14px 16px;background:#f9f7f2;border-left:3px solid #c8a96e;border-radius:4px;">
                        <i class="ti-check" style="color:#c8a96e;font-size:16px;flex-shrink:0;"></i>
                        <span style="font-size:14px;font-weight:500;color:#333;">{{ $featName }}</span>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ===== Photo Gallery Grid ===== --}}
    @php
        $galleryImages = !empty($business->gallery) && count((array)$business->gallery) > 1
            ? array_slice((array)$business->gallery, 0, 12)
            : [];
    @endphp
    @if(count($galleryImages) > 1)
    <section class="section-padding bg-lightnav">
        <div class="container">
            <div class="row justify-content-center mb-40">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>Inside the Hotel</span></div>
                    <div class="section-title">Photo <span>Gallery</span></div>
                </div>
            </div>
            <div class="row">
                @foreach($galleryImages as $index => $img)
                <div class="col-md-{{ $index < 2 ? '6' : '4' }} col-sm-6 mb-20">
                    <div style="border-radius:6px;overflow:hidden;height:{{ $index < 2 ? '280px' : '200px' }};position:relative;">
                        <img src="{{ \App\Helpers\Cms::imageUrl($img) }}" alt="{{ $business->name }} photo {{ $index + 1 }}"
                             style="width:100%;height:100%;object-fit:cover;transition:transform .4s ease;"
                             onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ===== Video Section ===== --}}
    @if($business->video_url)
    <section class="tours1 section-padding">
        <div class="container">
            <div class="row justify-content-center mb-40">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>See the Hotel</span></div>
                    <div class="section-title">Hotel <span>Video</span></div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div style="border-radius:8px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.12);position:relative;padding-bottom:56.25%;">
                        <iframe src="{{ $business->video_url }}" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                                style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ===== Map Section ===== --}}
    @if($business->map_embed)
    <section class="section-padding bg-lightnav">
        <div class="container">
            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>Find Us</span></div>
                    <div class="section-title">Location &amp; <span>Map</span></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div style="border-radius:8px;overflow:hidden;border:1px solid #e0ddd4;">
                        {!! $business->map_embed !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ===== Packages ===== --}}
    @if($packages->isNotEmpty())
    <section class="tours1 section-padding {{ $business->map_embed ? '' : 'bg-lightnav' }}">
        <div class="container">
            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>Our Offerings</span></div>
                    <div class="section-title">Hotel <span>Packages</span></div>
                </div>
            </div>
            <div class="row">
                @foreach($packages as $package)
                <div class="col-md-4 col-sm-6 mb-30">
                    <div class="item">
                        <a href="{{ route('packages.show', $package->slug) }}">
                            <div class="position-re o-hidden">
                                @if(!empty($package->photos))
                                    <img src="{{ asset('storage/' . $package->photos[0]) }}" alt="{{ $package->name }}">
                                @elseif($business->cover_photo)
                                    <img src="{{ \App\Helpers\Cms::imageUrl($business->cover_photo) }}" alt="{{ $package->name }}">
                                @else
                                    <img src="{{ asset('annapurna/img/hotels/hotel-kantipur-annapurna-region.jpg') }}" alt="{{ $package->name }}">
                                @endif
                            </div>
                        </a>
                        @if($package->isSponsored())
                        <span class="category" style="background:#c8a96e;"><span>Sponsored</span></span>
                        @else
                        <span class="category"><a href="#">{{ $package->duration }}</a></span>
                        @endif
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

    {{-- ===== Reviews ===== --}}
    <section class="tours2 section-padding bg-lightnav">
        <div class="container">

            {{-- Section Header --}}
            <div class="row justify-content-center mb-40">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>What Our Guests Say</span></div>
                    <div class="section-title">Guest <span>Reviews</span></div>
                    @if($reviews->count() > 0)
                    @php $avg = round($reviews->avg('rating'), 1); @endphp
                    <div style="display:flex;align-items:center;justify-content:center;gap:10px;margin-top:10px;">
                        <span style="color:#f4b942;font-size:24px;letter-spacing:2px;">
                            @for($i=1;$i<=5;$i++){!! $i<=round($avg)?'★':'☆' !!}@endfor
                        </span>
                        <span style="font-size:22px;font-weight:700;color:#0f2454;">{{ $avg }}</span>
                        <span style="color:#888;font-size:14px;">/ 5 &nbsp;·&nbsp; {{ $reviews->count() }} {{ Str::plural('review', $reviews->count()) }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="row">

                {{-- Left: Reviews List --}}
                <div class="col-md-7">

                    @if(session('success') && str_contains(session('success'), 'review'))
                    <div class="alert alert-success mb-20">{{ session('success') }}</div>
                    @endif

                    @forelse($reviews as $review)
                    <div style="background:#fff;border-radius:8px;padding:24px;margin-bottom:20px;box-shadow:0 2px 12px rgba(0,0,0,.06);border-left:4px solid #c8a96e;">
                        <div style="display:flex;align-items:center;gap:14px;margin-bottom:12px;">
                            <div style="width:46px;height:46px;border-radius:50%;background:linear-gradient(135deg,#c8a96e,#a0823a);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:18px;flex-shrink:0;">
                                {{ strtoupper(substr($review->user->name ?? 'G', 0, 1)) }}
                            </div>
                            <div style="flex:1;">
                                <div style="font-weight:700;font-size:15px;color:#0f2454;">{{ $review->user->name }}</div>
                                <div style="display:flex;align-items:center;gap:8px;margin-top:2px;">
                                    <span style="color:#f4b942;font-size:14px;letter-spacing:1px;">
                                        @for($i=1;$i<=5;$i++){!! $i<=$review->rating?'★':'☆' !!}@endfor
                                    </span>
                                    <span style="color:#bbb;font-size:12px;">{{ $review->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                        @if($review->title)
                        <div style="font-weight:600;font-size:15px;color:#222;margin-bottom:6px;">{{ $review->title }}</div>
                        @endif
                        @if($review->body)
                        <p style="color:#666;font-size:14px;margin:0;line-height:1.8;">{{ $review->body }}</p>
                        @endif
                    </div>
                    @empty
                    <div style="text-align:center;padding:60px 30px;background:#fff;border-radius:8px;border:2px dashed #e0ddd4;">
                        <i class="ti-star" style="font-size:50px;color:#c8a96e;display:block;margin-bottom:18px;"></i>
                        <h5 style="color:#333;font-weight:600;margin-bottom:8px;">No Reviews Yet</h5>
                        <p style="color:#999;font-size:14px;margin-bottom:0;">Be the first to review <strong>{{ $business->name }}</strong>.<br>Your feedback helps other travelers make better choices.</p>
                    </div>
                    @endforelse
                </div>

                {{-- Right: Write Review Card --}}
                <div class="col-md-5">
                    <div style="background:#fff;border-radius:8px;padding:32px;box-shadow:0 2px 16px rgba(0,0,0,.08);position:sticky;top:80px;">

                        <div style="text-align:center;margin-bottom:24px;padding-bottom:20px;border-bottom:1px solid #f0ede6;">
                            <i class="ti-pencil-alt" style="font-size:32px;color:#c8a96e;display:block;margin-bottom:10px;"></i>
                            <div class="section-subtitle" style="justify-content:center;"><span>Share Your Stay</span></div>
                            <h4 style="color:#0f2454;margin:0;">Write a Review</h4>
                        </div>

                        @auth
                            @if($userReview)
                            <div style="background:#f0f8f0;border-left:3px solid #198754;padding:12px 14px;border-radius:4px;font-size:13px;color:#2d6a2d;margin-bottom:20px;">
                                <i class="ti-check" style="margin-right:6px;"></i>
                                Review submitted{{ !$userReview->is_approved ? ' — pending approval' : '' }}.
                                You can update it below.
                            </div>
                            @endif

                            <form method="POST" action="{{ route('businesses.reviews.store', $business) }}" class="item-form contac__form">
                                @csrf

                                {{-- Star Rating Picker --}}
                                <div class="form-group" style="margin-bottom:20px;">
                                    <label style="font-weight:600;display:block;margin-bottom:10px;color:#333;font-size:14px;">Your Rating *</label>
                                    <div class="star-picker" style="display:flex;gap:4px;font-size:34px;cursor:pointer;">
                                        @for($i=1;$i<=5;$i++)
                                        <label style="cursor:pointer;color:#ddd;line-height:1;" data-value="{{ $i }}">
                                            <input type="radio" name="rating" value="{{ $i }}" style="display:none;"
                                                {{ old('rating', $userReview?->rating) == $i ? 'checked' : '' }}>
                                            ★
                                        </label>
                                        @endfor
                                    </div>
                                    @error('rating')<span style="color:#e74c3c;font-size:12px;margin-top:4px;display:block;">{{ $message }}</span>@enderror
                                </div>

                                <div class="form-group">
                                    <input type="text" name="title" placeholder="Review title (optional)"
                                           value="{{ old('title', $userReview?->title) }}">
                                </div>
                                <div class="form-group">
                                    <textarea name="body" rows="4" placeholder="Tell us about your stay...">{{ old('body', $userReview?->body) }}</textarea>
                                </div>

                                <div class="butn-dark" style="margin-top:6px;">
                                    <button type="submit" style="width:100%;background:none;border:none;cursor:pointer;padding:0;">
                                        <span>{{ $userReview ? 'Update Review' : 'Submit Review' }} <i class="ti-arrow-right"></i></span>
                                    </button>
                                </div>
                            </form>

                        @else
                        <div style="text-align:center;padding:20px 10px;">
                            <i class="ti-user" style="font-size:42px;color:#c8a96e;display:block;margin-bottom:14px;"></i>
                            <h5 style="color:#0f2454;font-weight:600;margin-bottom:8px;">Sign In to Review</h5>
                            <p style="color:#888;font-size:14px;line-height:1.7;margin-bottom:24px;">
                                Stayed at {{ $business->name }}?<br>Share your experience to help other travelers.
                            </p>
                            <div class="butn-dark">
                                <a href="{{ route('login') }}"><span>Sign In <i class="ti-arrow-right"></i></span></a>
                            </div>
                            <p style="color:#bbb;font-size:12px;margin-top:14px;margin-bottom:0;">
                                Don't have an account?
                                <a href="{{ route('register') }}" style="color:#c8a96e;">Register free</a>
                            </p>
                        </div>
                        @endauth

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== Enquiry Form ===== --}}
    <section id="booking" class="tours2 section-padding bg-lightnav">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="section-subtitle"><span>Reserve Your Stay</span></div>
                    <div class="section-title">Book <span>{{ $business->name }}</span></div>
                    <p>Fill in your details below and we will confirm your reservation within 24 hours.</p>

                    @if(session('booking_success'))
                    <div class="alert alert-success" style="border-radius:8px; padding:16px 20px;">
                        <i class="ti-check" style="margin-right:8px;"></i>{{ session('booking_success') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger" style="border-radius:8px;">
                        <ul class="mb-0">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('bookings.hotel.store', $business) }}" class="right-sidebar item-form contac__form mt-30">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input name="guest_name" type="text" placeholder="Full Name *"
                                       value="{{ old('guest_name', auth()->user()?->name) }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <input name="guest_email" type="email" placeholder="Email Address *"
                                       value="{{ old('guest_email', auth()->user()?->email) }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <input name="guest_phone" type="text" placeholder="Phone / WhatsApp"
                                       value="{{ old('guest_phone', auth()->user()?->phone) }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <input name="guests" type="number" placeholder="Number of Guests *"
                                       min="1" max="50" value="{{ old('guests', 1) }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label style="font-size:12px;color:#888;margin-bottom:4px;display:block;">Check-in Date *</label>
                                <input name="check_in" type="date"
                                       min="{{ date('Y-m-d') }}"
                                       value="{{ old('check_in') }}" required
                                       style="width:100%;padding:14px 20px;border:1px solid #e1ddd8;border-radius:4px;font-size:14px;">
                            </div>
                            <div class="col-md-6 form-group">
                                <label style="font-size:12px;color:#888;margin-bottom:4px;display:block;">Check-out Date *</label>
                                <input name="check_out" type="date"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       value="{{ old('check_out') }}" required
                                       style="width:100%;padding:14px 20px;border:1px solid #e1ddd8;border-radius:4px;font-size:14px;">
                            </div>
                            <div class="col-md-6 form-group">
                                <input name="rooms" type="number" placeholder="Number of Rooms *"
                                       min="1" max="20" value="{{ old('rooms', 1) }}" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <textarea name="special_requests" cols="30" rows="3"
                                          placeholder="Special requests (dietary needs, room preferences, early check-in...)">{{ old('special_requests') }}</textarea>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit">
                                    <span><i class="ti-calendar" style="margin-right:6px;"></i>Request Booking</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Sidebar --}}
                <div class="col-md-4">
                    <div class="widget clearfix usful-links mt-30">
                        <h4 class="widget-title">Quick Info</h4>
                        <ul>
                            @if($business->subtitle)
                            <li><i class="ti-tag"></i> {{ $business->subtitle }}</li>
                            @endif
                            @if($business->address)
                            <li><i class="ti-location-pin"></i> {{ $business->address }}</li>
                            @endif
                            @if($business->opening_hours)
                            <li><i class="ti-time"></i> {{ $business->opening_hours }}</li>
                            @endif
                            @if($business->phone)
                            <li><i class="flaticon-phone-call"></i> <a href="tel:{{ $business->phone }}">{{ $business->phone }}</a></li>
                            @endif
                            @if($business->email)
                            <li><i class="flaticon-message"></i> <a href="mailto:{{ $business->email }}">{{ $business->email }}</a></li>
                            @endif
                            @if($business->website)
                            <li><i class="ti-world"></i> <a href="{{ $business->website }}" target="_blank" rel="noopener noreferrer">Visit Website</a></li>
                            @endif
                        </ul>
                    </div>

                    <div class="widget clearfix usful-links mt-30">
                        <h4 class="widget-title">Popular Nearby Treks</h4>
                        <ul>
                            @foreach(\App\Models\TrekRoute::active()->limit(5)->get() as $trek)
                            <li><a href="{{ route('trek-routes.show', $trek->slug) }}"><i class="ti-arrow-right"></i> {{ $trek->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="widget clearfix usful-links mt-30">
                        <h4 class="widget-title">Explore More</h4>
                        <ul>
                            <li><a href="{{ route('hotels.index') }}"><i class="ti-arrow-right"></i> All Hotels</a></li>
                            <li><a href="{{ route('restaurants.index') }}"><i class="ti-arrow-right"></i> Restaurants</a></li>
                            <li><a href="{{ route('trek-routes.index') }}"><i class="ti-arrow-right"></i> Trek Routes</a></li>
                            <li><a href="{{ route('destinations.index') }}"><i class="ti-arrow-right"></i> Destinations</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== Related Hotels ===== --}}
    @if($relatedHotels->isNotEmpty())
    <section class="tours1 section-padding">
        <div class="container">
            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>More Options</span></div>
                    <div class="section-title">Similar <span>Hotels</span></div>
                </div>
            </div>
            <div class="row">
                @foreach($relatedHotels->take(3) as $related)
                <div class="col-md-4 col-sm-6 mb-30">
                    <div class="item">
                        <a href="{{ route('hotels.show', $related->slug) }}">
                            <div class="position-re o-hidden">
                                @if($related->cover_photo)
                                    <img src="{{ \App\Helpers\Cms::imageUrl($related->cover_photo) }}" alt="{{ $related->name }}">
                                @else
                                    <img src="{{ asset('annapurna/img/hotels/hotel-kantipur-annapurna-region.jpg') }}" alt="{{ $related->name }}">
                                @endif
                            </div>
                            @if($related->subtitle)
                            <span class="category"><a href="#">{{ $related->subtitle }}</a></span>
                            @endif
                        </a>
                        <div class="con">
                            <h5><a href="{{ route('hotels.show', $related->slug) }}">{{ $related->name }}</a></h5>
                            @if($related->short_description)
                            <p>{{ Str::limit($related->short_description, 90) }}</p>
                            @endif
                            <div class="line"></div>
                            <div class="row facilities">
                                <div class="col col-md-12"><ul>
                                    @if($related->address)<li><i class="ti-location-pin"></i> {{ Str::limit($related->address, 40) }}</li>@endif
                                    @if($related->phone)<li><i class="flaticon-phone-call"></i> {{ $related->phone }}</li>@endif
                                </ul></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row mt-20">
                <div class="col-md-12 text-center">
                    <div class="butn-dark">
                        <a href="{{ route('hotels.index') }}"><span>View All Hotels <i class="ti-arrow-right"></i></span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

@push('scripts')
<script>
    var readMoreBtn = document.getElementById('readMoreBtn');
    if (readMoreBtn) {
        readMoreBtn.addEventListener('click', function () {
            var s = document.getElementById('shortText');
            var m = document.getElementById('moreText');
            if (m.style.display === 'none') {
                m.style.display = 'block'; s.style.display = 'none';
                this.textContent = 'Read Less';
            } else {
                m.style.display = 'none'; s.style.display = 'block';
                this.textContent = 'Read More';
            }
        });
    }

    document.querySelectorAll('.star-picker label').forEach(function (label) {
        var value = parseInt(label.dataset.value);
        label.addEventListener('mouseenter', function () {
            document.querySelectorAll('.star-picker label').forEach(function (l) {
                l.style.color = parseInt(l.dataset.value) <= value ? '#f4b942' : '#ddd';
            });
        });
        label.addEventListener('mouseleave', function () {
            var checked = document.querySelector('.star-picker input:checked');
            var checkedVal = checked ? parseInt(checked.value) : 0;
            document.querySelectorAll('.star-picker label').forEach(function (l) {
                l.style.color = parseInt(l.dataset.value) <= checkedVal ? '#f4b942' : '#ddd';
            });
        });
        label.addEventListener('click', function () {
            label.querySelector('input').checked = true;
            document.querySelectorAll('.star-picker label').forEach(function (l) {
                l.style.color = parseInt(l.dataset.value) <= value ? '#f4b942' : '#ddd';
            });
        });
    });
    (function () {
        var checked = document.querySelector('.star-picker input:checked');
        if (checked) {
            var val = parseInt(checked.value);
            document.querySelectorAll('.star-picker label').forEach(function (l) {
                l.style.color = parseInt(l.dataset.value) <= val ? '#f4b942' : '#ddd';
            });
        }
    })();
</script>
@endpush

@endsection
