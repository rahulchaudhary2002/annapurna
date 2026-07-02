@extends('layouts.app')

@section('meta_title', ($business->meta_title ?: $business->name) . ' - Annapurna Region')
@section('meta_description', $business->meta_description ?: Str::limit($business->short_description ?? $business->name, 160))
@section('og_title', $business->meta_title ?: $business->name)

@section('content')

    {{-- Header Banner --}}
    <div class="banner-header section-padding back-position-center valign bg-img bg-fixed"
         data-overlay-dark="5"
         data-background="{{ $business->cover_photo ? \App\Helpers\Cms::imageUrl($business->cover_photo) : asset('annapurna/img/slider/pokhara-valley-tour.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-9 text-left caption mt-90">
                    @php
                        $typeLabel = match($business->type ?? '') {
                            'hotel'          => 'Hotels',
                            'restaurant'     => 'Restaurants',
                            'travel_agency'  => 'Travel Agencies',
                            default          => 'Businesses',
                        };
                        $typeRoute = match($business->type ?? '') {
                            'hotel'          => 'hotels.index',
                            'restaurant'     => 'restaurants.index',
                            'travel_agency'  => 'travel-agencies.index',
                            default          => 'home',
                        };
                    @endphp
                    <h6><a href="{{ route($typeRoute) }}">{{ $typeLabel }}</a> / {{ $business->name }}</h6>
                    <h1>{{ $business->name }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route($typeRoute) }}">{{ $typeLabel }}</a></li>
                            <li class="breadcrumb-item active">{{ $business->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Overview Section --}}
    <section class="tours1 section-padding">
        <div class="container">
            <div class="row mb-60">

                {{-- Left: Business Info --}}
                <div class="col-md-7">
                    <div class="country">
                        @if($business->subtitle)
                        <div class="section-subtitle">{{ $business->subtitle }}</div>
                        @endif
                        <div class="section-title2" style="display:flex;align-items:center;gap:10px;">
                            {{ $business->name }}
                            @if($business->is_verified)
                            <span title="Verified Business" style="display:inline-flex;align-items:center;background:#198754;color:#fff;font-size:11px;font-weight:600;padding:2px 8px;border-radius:20px;letter-spacing:.5px;">
                                ✓ Verified
                            </span>
                            @endif
                        </div>

                        {{-- Star Rating Display --}}
                        @php $avgRating = $business->average_rating; $reviewCount = $business->review_count; @endphp
                        @if($reviewCount > 0)
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
                            <span style="color:#f4b942;font-size:18px;letter-spacing:2px;">
                                @for($i=1;$i<=5;$i++)
                                    {!! $i <= round($avgRating) ? '★' : '☆' !!}
                                @endfor
                            </span>
                            <span style="font-weight:600;color:#333;">{{ number_format($avgRating,1) }}</span>
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
                                        <a href="tel:{{ $business->phone }}" class="link-btn">{{ $business->phone }}</a>
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
                                    <li><i class="flaticon-placeholder"></i>
                                        <a href="{{ $business->website }}" target="_blank" rel="noopener noreferrer" class="link-btn">{{ $business->website }}</a>
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

                        {{-- Features List --}}
                        @if(!empty($business->features) && count($business->features) > 0)
                        <div class="row tour-list mt-20">
                            <div class="col-md-12">
                                <ul>
                                    @foreach(array_slice((array)$business->features, 0, 6) as $feature)
                                    <li><i class="ti-check"></i> {{ is_array($feature) ? ($feature['name'] ?? $feature) : $feature }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        <div class="butn-dark mt-30 mb-30">
                            <a href="{{ route('contact') }}"><span>Enquire Now <i class="ti-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>

                {{-- Right: Gallery Carousel --}}
                <div class="col-md-5">
                    @if(!empty($business->gallery) && count($business->gallery) > 0)
                    <div class="owl-carousel owl-theme">
                        @foreach($business->gallery as $image)
                        <div class="item">
                            <div class="position-re o-hidden">
                                <img src="{{ \App\Helpers\Cms::imageUrl($image) }}" alt="{{ $business->name }}">
                            </div>
                            <span class="category"><a href="#">{{ $business->name }}</a></span>
                        </div>
                        @endforeach
                    </div>
                    @elseif($business->cover_photo)
                    <div class="owl-carousel owl-theme">
                        <div class="item">
                            <div class="position-re o-hidden">
                                <img src="{{ \App\Helpers\Cms::imageUrl($business->cover_photo) }}" alt="{{ $business->name }}">
                            </div>
                            <span class="category"><a href="#">{{ $business->name }}</a></span>
                        </div>
                    </div>
                    @else
                    <div class="owl-carousel owl-theme">
                        <div class="item">
                            <div class="position-re o-hidden">
                                <img src="{{ asset('annapurna/img/tours/annapurna-circuit.jpg') }}" alt="{{ $business->name }}">
                            </div>
                            <span class="category"><a href="#">{{ $business->name }}</a></span>
                        </div>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

    {{-- Full Description --}}
    @if($business->description ?? null)
    <section class="section-padding bg-lightnav">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div id="shortText">
                        {!! Str::words(strip_tags($business->description), 100, '...') !!}
                    </div>
                    @if(str_word_count(strip_tags($business->description)) > 100)
                    <div id="moreText" style="display: none;">
                        {!! $business->description !!}
                    </div>
                    <button class="btn btn-primary mt-2" id="readMoreBtn">Read More</button>
                    @endif
                </div>

                {{-- Contact Sidebar --}}
                <div class="col-md-4">
                    <div class="widget clearfix" style="background:#d1d1ff; padding: 20px; border-radius: 8px;">
                        <h4>Contact {{ $business->name }}</h4>
                        @if($business->phone)
                        <div class="mb-10">
                            <i class="flaticon-phone-call"></i>
                            <a href="tel:{{ $business->phone }}">{{ $business->phone }}</a>
                        </div>
                        @endif
                        @if($business->email)
                        <div class="mb-10">
                            <i class="flaticon-message"></i>
                            <a href="mailto:{{ $business->email }}">{{ $business->email }}</a>
                        </div>
                        @endif
                        @if($business->address)
                        <div class="mb-10">
                            <i class="flaticon-placeholder"></i> {{ $business->address }}
                        </div>
                        @endif
                        <div class="butn-dark mt-20">
                            <a href="{{ route('contact') }}"><span>Send Enquiry <i class="ti-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Packages Section --}}
    @if(isset($packages) && $packages->isNotEmpty())
    <section class="tours1 section-padding bg-lightnav">
        <div class="container">
            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>Our Offerings</span></div>
                    <div class="section-title">Tour &amp; Travel <span>Packages</span></div>
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
                                    <img src="{{ asset('annapurna/img/tours/annapurna-circuit.jpg') }}" alt="{{ $package->name }}">
                                @endif
                            </div>
                        </a>
                        @if($package->isSponsored())
                        <span class="category" style="background: #c8a96e;"><span>Sponsored</span></span>
                        @else
                        <span class="category"><a href="#">{{ $package->duration }}</a></span>
                        @endif
                        <div class="con">
                            <h5><a href="{{ route('packages.show', $package->slug) }}">{{ $package->name }}</a></h5>
                            <div class="line"></div>
                            <div class="row facilities">
                                <div class="col col-md-12">
                                    <ul>
                                        <li><i class="ti-time"></i> {{ $package->duration }}</li>
                                        <li><i class="ti-money"></i> Rs. {{ number_format($package->price) }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row mt-10">
                <div class="col-md-12 text-center">
                    <div class="butn-dark">
                        <a href="{{ route('packages.index') }}"><span>Browse All Packages <i class="ti-arrow-right"></i></span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Reviews Section --}}
    <section class="tours1 section-padding">
        <div class="container">
            <div class="row">
                {{-- Existing Reviews --}}
                <div class="col-md-7">
                    <div class="section-subtitle"><span>Community Feedback</span></div>
                    <div class="section-title">Ratings &amp; <span>Reviews</span></div>

                    @if(session('success') && str_contains(session('success'), 'review'))
                    <div class="alert alert-success mb-20">{{ session('success') }}</div>
                    @endif

                    @forelse($reviews as $review)
                    <div style="padding:20px 0;border-bottom:1px solid #f0f0f0;">
                        <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px;">
                            <div style="width:40px;height:40px;border-radius:50%;background:#c8a96e;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:16px;flex-shrink:0;">
                                {{ strtoupper(substr($review->user->name ?? 'G', 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:600;font-size:14px;">{{ $review->user->name }}</div>
                                <div style="color:#f4b942;font-size:14px;letter-spacing:1px;">
                                    @for($i=1;$i<=5;$i++){!! $i<=$review->rating?'★':'☆' !!}@endfor
                                    <span style="color:#888;font-size:12px;margin-left:6px;">{{ $review->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                        @if($review->title)
                        <div style="font-weight:600;margin-bottom:4px;">{{ $review->title }}</div>
                        @endif
                        @if($review->body)
                        <p style="color:#555;font-size:14px;margin:0;">{{ $review->body }}</p>
                        @endif
                    </div>
                    @empty
                    <p style="color:#888;padding:20px 0;">No reviews yet. Be the first to share your experience!</p>
                    @endforelse
                </div>

                {{-- Write a Review --}}
                <div class="col-md-5">
                    <div style="background:#f9f9f9;border-radius:8px;padding:30px;margin-top:60px;">
                        <h4 style="margin-bottom:20px;">Write a Review</h4>

                        @auth
                            @if($userReview)
                            <div class="alert alert-info" style="font-size:13px;">
                                You have already submitted a review
                                @if(!$userReview->is_approved) (pending approval)@endif.
                                Submitting again will update your existing review.
                            </div>
                            @endif

                            <form method="POST" action="{{ route('businesses.reviews.store', $business) }}">
                                @csrf
                                <div class="form-group mb-20">
                                    <label style="font-weight:600;display:block;margin-bottom:8px;">Rating *</label>
                                    <div class="star-picker" style="display:flex;gap:6px;font-size:28px;cursor:pointer;">
                                        @for($i=1;$i<=5;$i++)
                                        <label style="cursor:pointer;color:#ddd;" data-value="{{ $i }}">
                                            <input type="radio" name="rating" value="{{ $i }}" style="display:none;"
                                                {{ old('rating', $userReview?->rating) == $i ? 'checked' : '' }}>
                                            ★
                                        </label>
                                        @endfor
                                    </div>
                                    @error('rating')<span style="color:red;font-size:12px;">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group mb-20">
                                    <input type="text" name="title" placeholder="Review title (optional)"
                                           value="{{ old('title', $userReview?->title) }}"
                                           style="width:100%;padding:10px;border:1px solid #ddd;border-radius:4px;">
                                </div>
                                <div class="form-group mb-20">
                                    <textarea name="body" rows="4" placeholder="Share your experience..."
                                              style="width:100%;padding:10px;border:1px solid #ddd;border-radius:4px;resize:vertical;">{{ old('body', $userReview?->body) }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary" style="width:100%;">
                                    <span>{{ $userReview ? 'Update Review' : 'Submit Review' }}</span>
                                </button>
                            </form>
                        @else
                        <p style="color:#666;font-size:14px;">
                            <a href="{{ route('login') }}" style="color:#c8a96e;font-weight:600;">Sign in</a>
                            to leave a review.
                        </p>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Enquiry Form Section --}}
    <section class="tours2 section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="section-subtitle"><span>Get In Touch</span></div>
                    <div class="section-title">Make an <span>Enquiry</span></div>
                    <p>Interested in {{ $business->name }}? Fill in the form and we will get back to you shortly.</p>

                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}" class="right-sidebar item-form contac__form mt-30">
                        @csrf
                        <input type="hidden" name="subject" value="Enquiry: {{ $business->name }}">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input name="name" type="text" placeholder="Your Name *" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <input name="email" type="email" placeholder="Your Email *" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <input name="phone" type="text" placeholder="Phone Number" value="{{ old('phone') }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <input name="arrival_date" type="text" placeholder="Arrival Date" value="{{ old('arrival_date') }}">
                            </div>
                            <div class="col-md-12 form-group">
                                <textarea name="message" cols="30" rows="4" placeholder="Your message or special requirements...">{{ old('message') }}</textarea>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit">
                                    <span>Send Message</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Key Info Sidebar --}}
                <div class="col-md-4">
                    <div class="widget clearfix usful-links mt-30">
                        <h4 class="widget-title">Quick Info</h4>
                        <ul>
                            @if($business->type)
                            <li><i class="ti-tag"></i> {{ ucfirst(str_replace('_', ' ', $business->type)) }}</li>
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
                            @if($business->website)
                            <li><i class="ti-world"></i> <a href="{{ $business->website }}" target="_blank" rel="noopener noreferrer">Visit Website</a></li>
                            @endif
                        </ul>
                    </div>

                    {{-- Popular Trek Routes Widget --}}
                    <div class="widget clearfix usful-links mt-30">
                        <h4 class="widget-title">Popular Treks Nearby</h4>
                        <ul>
                            <li><a href="{{ route('trek-routes.index') }}"><i class="ti-arrow-right"></i> Annapurna Circuit Trek</a></li>
                            <li><a href="{{ route('trek-routes.index') }}"><i class="ti-arrow-right"></i> Annapurna Base Camp Trek</a></li>
                            <li><a href="{{ route('trek-routes.index') }}"><i class="ti-arrow-right"></i> Poon Hill Trek</a></li>
                            <li><a href="{{ route('trek-routes.index') }}"><i class="ti-arrow-right"></i> Mardi Himal Trek</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Related Businesses --}}
    @if(isset($relatedBusinesses) && $relatedBusinesses->isNotEmpty())
    <section class="tours1 section-padding bg-lightnav">
        <div class="container">
            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>More Options</span></div>
                    <div class="section-title">Similar <span>{{ $typeLabel }}</span></div>
                </div>
            </div>
            <div class="row">
                @foreach($relatedBusinesses->take(3) as $related)
                <div class="col-md-4 col-sm-6 mb-30">
                    <div class="item">
                        <a href="{{ route('businesses.show', $related->slug) }}">
                            <div class="position-re o-hidden">
                                @if($related->cover_photo)
                                    <img src="{{ \App\Helpers\Cms::imageUrl($related->cover_photo) }}" alt="{{ $related->name }}">
                                @else
                                    <img src="{{ asset('annapurna/img/tours/annapurna-circuit.jpg') }}" alt="{{ $related->name }}">
                                @endif
                            </div>
                            @if($related->type)
                            <span class="category">
                                <a href="#">{{ ucfirst(str_replace('_', ' ', $related->type)) }}</a>
                            </span>
                            @endif
                            <div class="con">
                                <h5><a href="{{ route('businesses.show', $related->slug) }}">{{ $related->name }}</a></h5>
                                @if($related->short_description)<p>{{ Str::limit($related->short_description, 100) }}</p>@endif
                                <div class="line"></div>
                                <div class="row facilities">
                                    <div class="col col-md-12">
                                        <ul>
                                            @if($related->address)<li><i class="ti-location-pin"></i> {{ Str::limit($related->address, 40) }}</li>@endif
                                            @if($related->phone)<li><i class="flaticon-phone-call"></i> {{ $related->phone }}</li>@endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row mt-20">
                <div class="col-md-12 text-center">
                    <div class="butn-dark">
                        <a href="{{ route($typeRoute) }}"><span>View All {{ $typeLabel }} <i class="ti-arrow-right"></i></span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

@push('scripts')
<script>
    // Read More / Read Less toggle
    var readMoreBtn = document.getElementById('readMoreBtn');
    if (readMoreBtn) {
        readMoreBtn.addEventListener('click', function () {
            var shortText = document.getElementById('shortText');
            var moreText = document.getElementById('moreText');
            if (moreText.style.display === 'none') {
                moreText.style.display = 'block';
                shortText.style.display = 'none';
                this.textContent = 'Read Less';
            } else {
                moreText.style.display = 'none';
                shortText.style.display = 'block';
                this.textContent = 'Read More';
            }
        });
    }

    // Interactive star picker
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

    // Initialise star state on page load (e.g. existing review)
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
