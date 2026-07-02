@extends('layouts.app')

@section('meta_title', ($package->meta_title ?: $package->name) . ' — Annapurna Region')
@section('meta_description', $package->meta_description ?: 'Book the ' . $package->name . ' package from ' . $package->business->name . '. ' . $package->duration . ' starting at Rs. ' . number_format($package->price) . '.')
@section('og_title', $package->meta_title ?: $package->name)

@section('content')

    {{-- Header Banner --}}
    <div class="banner-header section-padding back-position-center valign bg-img bg-fixed"
         data-overlay-dark="5"
         data-background="{{ !empty($package->photos) ? asset('storage/' . $package->photos[0]) : ($package->business->cover_photo ? \App\Helpers\Cms::imageUrl($package->business->cover_photo) : asset('annapurna/img/slider/pokhara-valley-tour.jpg')) }}">
        <div class="container">
            <div class="row">
                <div class="col-md-9 text-left caption mt-90">
                    <h6>
                        <a href="{{ route('packages.index') }}">Packages</a> /
                        <a href="{{ route('businesses.show', $package->business->slug) }}">{{ $package->business->name }}</a>
                    </h6>
                    <h1>{{ $package->name }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('packages.index') }}">Packages</a></li>
                            <li class="breadcrumb-item active">{{ $package->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <section class="tours1 section-padding">
        <div class="container">
            <div class="row">

                {{-- Left: Package Details --}}
                <div class="col-md-8">

                    {{-- Sponsored badge --}}
                    @if($package->isSponsored())
                    <div style="display:inline-block; background:#c8a96e; color:#fff; font-size:11px; font-weight:600;
                                padding:4px 14px; border-radius:20px; margin-bottom:16px; letter-spacing:0.5px;">
                        SPONSORED LISTING
                    </div>
                    @endif

                    {{-- Business link --}}
                    <div class="section-subtitle">
                        <span>by <a href="{{ route('businesses.show', $package->business->slug) }}"
                              style="color: #c8a96e;">{{ $package->business->name }}</a></span>
                    </div>
                    <div class="section-title2">{{ $package->name }}</div>

                    {{-- Quick facts --}}
                    <div class="row tour-list mt-20 mb-30">
                        <div class="col-md-6">
                            <ul>
                                <li><i class="ti-money"></i> <strong>Price:</strong> Rs. {{ number_format($package->price) }} per person</li>
                                <li><i class="ti-time"></i> <strong>Duration:</strong> {{ $package->duration }}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul>
                                @if($package->business->phone)
                                <li><i class="flaticon-phone-call"></i>
                                    <a href="tel:{{ $package->business->phone }}" class="link-btn">{{ $package->business->phone }}</a>
                                </li>
                                @endif
                                @if($package->business->address)
                                <li><i class="flaticon-placeholder"></i> {{ $package->business->address }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    {{-- Photo Gallery --}}
                    @if(!empty($package->photos) && count($package->photos) > 0)
                    <div class="owl-carousel owl-theme mb-40">
                        @foreach($package->photos as $photo)
                        <div class="item">
                            <div class="position-re o-hidden">
                                <img src="{{ asset('storage/' . $photo) }}" alt="{{ $package->name }}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    {{-- Video --}}
                    @if($package->video_url)
                    <div class="mb-40">
                        <h4 style="font-weight: 600; color: #1a1a2e; margin-bottom: 16px;">Video</h4>
                        <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 6px;">
                            <iframe src="{{ $package->video_url }}" frameborder="0"
                                    style="position: absolute; top:0; left:0; width:100%; height:100%;"
                                    allowfullscreen></iframe>
                        </div>
                    </div>
                    @endif

                    {{-- Highlights --}}
                    @if(!empty($package->highlights))
                    <div class="mb-40">
                        <h4 style="font-weight: 600; color: #1a1a2e; margin-bottom: 16px;">Highlights</h4>
                        <div class="row tour-list">
                            <div class="col-md-12">
                                <ul>
                                    @foreach($package->highlights as $highlight)
                                    <li><i class="ti-check" style="color: #c8a96e;"></i> {{ $highlight }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Itinerary --}}
                    @if(!empty($package->itinerary))
                    <div class="mb-40">
                        <h4 style="font-weight: 600; color: #1a1a2e; margin-bottom: 20px;">Full Itinerary</h4>

                        <div class="accordion" id="itineraryAccordion">
                            @foreach($package->itinerary as $index => $day)
                            <div style="border: 1px solid #eee; border-radius: 6px; margin-bottom: 8px; overflow: hidden;">
                                <button type="button"
                                        style="width:100%; text-align:left; background: {{ $index === 0 ? '#1a1a2e' : '#f8f9fa' }};
                                               color: {{ $index === 0 ? '#fff' : '#333' }};
                                               border: none; padding: 14px 20px; font-size: 14px; font-weight: 600;
                                               cursor: pointer; display: flex; align-items: center; gap: 12px;"
                                        onclick="toggleItinerary({{ $index }})">
                                    <span style="background: #c8a96e; color: #fff; border-radius: 50%; width: 28px; height: 28px;
                                                 display: inline-flex; align-items: center; justify-content: center;
                                                 font-size: 12px; flex-shrink: 0;">
                                        {{ $day['day'] ?? ($index + 1) }}
                                    </span>
                                    {{ $day['title'] ?? 'Day ' . ($index + 1) }}
                                </button>
                                <div id="itinerary-{{ $index }}" style="{{ $index === 0 ? '' : 'display: none;' }} padding: 16px 20px; background: #fff; color: #555; font-size: 14px; line-height: 1.7;">
                                    {!! $day['description'] ?? '' !!}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- FAQs --}}
                    @if(!empty($package->faqs))
                    <div class="mb-40">
                        <h4 style="font-weight: 600; color: #1a1a2e; margin-bottom: 20px;">Frequently Asked Questions</h4>
                        @foreach($package->faqs as $faq)
                        <div style="border-bottom: 1px solid #eee; padding: 14px 0;">
                            <div style="font-weight: 600; color: #1a1a2e; margin-bottom: 6px;">
                                <i class="ti-help-alt" style="color: #c8a96e; margin-right: 8px;"></i>
                                {{ $faq['question'] ?? '' }}
                            </div>
                            @if(!empty($faq['answer']))
                            <div style="color: #555; font-size: 14px; padding-left: 24px;">
                                {{ $faq['answer'] }}
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif

                    {{-- Map --}}
                    @if($package->map_embed)
                    <div class="mb-40">
                        <h4 style="font-weight: 600; color: #1a1a2e; margin-bottom: 16px;">Route Map</h4>
                        <div style="border-radius: 6px; overflow: hidden;">
                            {!! $package->map_embed !!}
                        </div>
                    </div>
                    @endif

                </div>

                {{-- Right Sidebar --}}
                <div class="col-md-4">
                    <div style="background:#fff; border:2px solid #c8a96e; border-radius:10px; overflow:hidden; position:sticky; top:80px;">

                        {{-- Price header --}}
                        <div style="padding:20px 24px 16px; border-bottom:1px solid #f0ebe3;">
                            <h4 style="font-size:20px; font-weight:700; color:#1a1a2e; margin:0 0 2px;">
                                Rs. {{ number_format($package->price) }}
                            </h4>
                            <p style="color:#888; font-size:13px; margin:0;">per person &middot; {{ $package->duration }}</p>
                        </div>

                        {{-- Tab switcher --}}
                        <div style="display:flex; border-bottom:1px solid #ede8e0;">
                            <button id="pkg-tab-book" onclick="pkgTab('book')"
                                    style="flex:1; padding:12px 8px; border:none; background:#fff; font-size:13px; font-weight:700;
                                           color:#c8a96e; border-bottom:2px solid #c8a96e; cursor:pointer; font-family:inherit; transition:all .2s;">
                                <i class="ti-calendar"></i> Book Now
                            </button>
                            <button id="pkg-tab-inquiry" onclick="pkgTab('inquiry')"
                                    style="flex:1; padding:12px 8px; border:none; background:#f8f5f0; font-size:13px; font-weight:600;
                                           color:#888; border-bottom:2px solid transparent; cursor:pointer; font-family:inherit; transition:all .2s;">
                                <i class="ti-comment"></i> Inquiry
                            </button>
                        </div>

                        {{-- Alerts (shared) --}}
                        <div style="padding: 0 20px;">
                            @if(session('booking_success'))
                            <div style="background:#d4edda; color:#155724; border:1px solid #c3e6cb;
                                        border-radius:6px; padding:11px 14px; margin-top:16px; font-size:13px;">
                                <i class="ti-check"></i> {{ session('booking_success') }}
                            </div>
                            @endif
                            @if(session('inquiry_success'))
                            <div style="background:#d4edda; color:#155724; border:1px solid #c3e6cb;
                                        border-radius:6px; padding:11px 14px; margin-top:16px; font-size:13px;">
                                <i class="ti-check"></i> {{ session('inquiry_success') }}
                            </div>
                            @endif
                            @if($errors->any())
                            <div style="background:#f8d7da; color:#721c24; border:1px solid #f5c6cb;
                                        border-radius:6px; padding:11px 14px; margin-top:16px; font-size:13px;">
                                <ul style="margin:0; padding-left:16px;">
                                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                                </ul>
                            </div>
                            @endif
                        </div>

                        @php $ifield = 'width:100%;padding:10px 13px;border:1px solid #ddd;border-radius:6px;font-size:13px;margin-bottom:11px;font-family:inherit;'; @endphp

                        {{-- ── BOOK NOW panel ── --}}
                        <div id="pkg-panel-book" style="padding:18px 20px 20px;">
                            <form method="POST" action="{{ route('bookings.package.store', $package) }}">
                                @csrf
                                <input type="text"  name="guest_name"   placeholder="Full Name *"
                                       value="{{ old('guest_name', auth()->user()?->name) }}"
                                       style="{{ $ifield }}" required>
                                <input type="email" name="guest_email"  placeholder="Email Address *"
                                       value="{{ old('guest_email', auth()->user()?->email) }}"
                                       style="{{ $ifield }}" required>
                                <input type="text"  name="guest_phone"  placeholder="Phone / WhatsApp"
                                       value="{{ old('guest_phone', auth()->user()?->phone) }}"
                                       style="{{ $ifield }}">
                                <input type="date"  name="travel_date"  min="{{ date('Y-m-d') }}"
                                       value="{{ old('travel_date') }}"
                                       style="{{ $ifield }} color:#555;" required>
                                <input type="number" name="guests" placeholder="Number of Guests *"
                                       min="1" max="50" value="{{ old('guests', 1) }}"
                                       style="{{ $ifield }}" required>
                                <textarea name="special_requests" rows="3"
                                          placeholder="Special requests or notes..."
                                          style="{{ $ifield }} resize:vertical;">{{ old('special_requests') }}</textarea>
                                <button type="submit" class="btn btn-primary" style="width:100%;padding:12px;margin-top:2px;">
                                    <i class="ti-calendar" style="margin-right:6px;"></i>Confirm Booking
                                </button>
                            </form>
                        </div>

                        {{-- ── INQUIRY panel ── --}}
                        <div id="pkg-panel-inquiry" style="padding:18px 20px 20px; display:none;">
                            <form method="POST" action="{{ route('packages.inquire', $package) }}">
                                @csrf
                                <input type="text"  name="name"        placeholder="Your Name *"
                                       value="{{ old('name', auth()->user()?->name) }}"
                                       style="{{ $ifield }}" required>
                                <input type="email" name="email"       placeholder="Email Address *"
                                       value="{{ old('email', auth()->user()?->email) }}"
                                       style="{{ $ifield }}" required>
                                <input type="text"  name="phone"       placeholder="Phone / WhatsApp"
                                       value="{{ old('phone') }}"
                                       style="{{ $ifield }}">
                                <input type="date"  name="travel_date" min="{{ date('Y-m-d') }}"
                                       value="{{ old('travel_date') }}"
                                       style="{{ $ifield }} color:#555;">
                                <input type="number" name="group_size" placeholder="Group Size"
                                       min="1" max="100" value="{{ old('group_size') }}"
                                       style="{{ $ifield }}">
                                <textarea name="message" rows="3"
                                          placeholder="Questions or special requirements..."
                                          style="{{ $ifield }} resize:vertical;">{{ old('message') }}</textarea>
                                <button type="submit" class="btn btn-primary" style="width:100%;padding:12px;margin-top:2px;background:#888;border-color:#888;">
                                    <i class="ti-comment" style="margin-right:6px;"></i>Send Inquiry
                                </button>
                            </form>
                        </div>

                        <div style="text-align:center; padding:0 20px 16px; border-top:1px solid #f0ebe3; padding-top:14px;">
                            <a href="{{ route('businesses.show', $package->business->slug) }}"
                               style="font-size:12px; color:#c8a96e;">
                                View {{ $package->business->name }} Profile
                            </a>
                        </div>
                    </div>
                </div>

                @push('scripts')
                <script>
                function pkgTab(tab) {
                    var isBook = tab === 'book';
                    document.getElementById('pkg-panel-book').style.display    = isBook ? 'block' : 'none';
                    document.getElementById('pkg-panel-inquiry').style.display = isBook ? 'none'  : 'block';

                    var btnBook    = document.getElementById('pkg-tab-book');
                    var btnInquiry = document.getElementById('pkg-tab-inquiry');

                    btnBook.style.color          = isBook ? '#c8a96e' : '#888';
                    btnBook.style.background     = isBook ? '#fff'    : '#f8f5f0';
                    btnBook.style.borderBottom   = isBook ? '2px solid #c8a96e' : '2px solid transparent';
                    btnBook.style.fontWeight     = isBook ? '700'     : '600';

                    btnInquiry.style.color       = isBook ? '#888'    : '#c8a96e';
                    btnInquiry.style.background  = isBook ? '#f8f5f0' : '#fff';
                    btnInquiry.style.borderBottom= isBook ? '2px solid transparent' : '2px solid #c8a96e';
                    btnInquiry.style.fontWeight  = isBook ? '600'     : '700';
                }
                </script>
                @endpush

            </div>
        </div>
    </section>

    {{-- Related Packages --}}
    @if($related->isNotEmpty())
    <section class="tours1 section-padding bg-lightnav">
        <div class="container">
            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>More Options</span></div>
                    <div class="section-title">Other Packages by <span>{{ $package->business->name }}</span></div>
                </div>
            </div>
            <div class="row">
                @foreach($related as $rel)
                <div class="col-md-4 mb-30">
                    @include('packages.partials.card', ['package' => $rel, 'featured' => false])
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

@endsection

@push('scripts')
<script>
    function toggleItinerary(index) {
        var el = document.getElementById('itinerary-' + index);
        var btn = el.previousElementSibling;
        if (el.style.display === 'none') {
            el.style.display = 'block';
            btn.style.background = '#1a1a2e';
            btn.style.color = '#fff';
        } else {
            el.style.display = 'none';
            btn.style.background = '#f8f9fa';
            btn.style.color = '#333';
        }
    }
</script>
@endpush
