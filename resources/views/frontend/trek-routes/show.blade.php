@extends('layouts.app')

@section('meta_title', $trekRoute->meta_title ?: $trekRoute->name . ' - Annapurna Region')
@section('meta_description', $trekRoute->meta_description ?: Str::limit($trekRoute->excerpt, 160))
@section('og_title', $trekRoute->meta_title ?: $trekRoute->name)

@push('styles')
<style>
.custom-input {
    padding: 1px 10px;
    height: 38px;
    font-size: 14px;
    border: 1px solid #888;
    border-radius: 6px;
}
.custom-input:focus {
    border-color: #6a0dad;
    box-shadow: 0 0 4px rgba(106,13,173,0.3);
}
textarea.custom-input { height: auto; }
.sticky-form {
    background-color: #d1d1ff;
    position: sticky;
    top: 90px;
    border: 1px solid #f1f1f1;
}
.text-purple { color: #6a0dad; }
.info-card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: all 0.4s ease;
    transform: translateY(30px);
    opacity: 0;
    animation: flyUp 0.8s ease forwards;
}
.info-card:nth-child(1) { animation-delay: 0.1s; }
.info-card:nth-child(2) { animation-delay: 0.3s; }
.info-card:nth-child(3) { animation-delay: 0.5s; }
.info-card:hover {
    transform: translateY(-8px);
    background-color: #f4e9ff;
    box-shadow: 0 10px 25px rgba(106,13,173,0.2);
}
@keyframes flyUp {
    from { opacity: 0; transform: translateY(30px); }
    to   { opacity: 1; transform: translateY(0); }
}
@media (max-width: 767px) { .info-card { margin-bottom: 1rem; } }
</style>
@endpush

@section('content')

    {{-- ═══════════════════════════════════════════════
         1. BANNER HEADER
    ═══════════════════════════════════════════════ --}}
    <div class="banner-header section-padding back-position-center valign bg-img bg-fixed"
         data-overlay-dark="5"
         data-background="{{ $trekRoute->banner_image ? \App\Helpers\Cms::imageUrl($trekRoute->banner_image) : asset('annapurna/img/slider/pokhara-valley-tour.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-10 text-left caption mt-90">
                    <h5><a href="{{ route('destinations.index') }}">Destination</a> / {{ $trekRoute->name }}</h5>
                    <h1><span style="font-size:30px;color:#fff">{{ $trekRoute->meta_title ?: $trekRoute->name }}</span></h1>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         2. INTRODUCTION + HIGHLIGHTS TABLE
    ═══════════════════════════════════════════════ --}}
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 style="font-size:30px;">{{ $trekRoute->excerpt ?: $trekRoute->name }}</h2>
                    <div class="row">

                        {{-- Left: description with Read More --}}
                        <div class="col-md-7">
                            @php
                                $fullDesc = $trekRoute->description ?: ('<p>' . ($trekRoute->excerpt ?? '') . '</p>');
                                $paragraphs = preg_split('/<\/p>\s*<p/i', $fullDesc);
                                $visibleCount = 4;
                                $hasMore = count($paragraphs) > $visibleCount;
                                if ($hasMore) {
                                    $shortHtml = implode('</p><p', array_slice($paragraphs, 0, $visibleCount));
                                    if (!str_ends_with(rtrim($shortHtml), '</p>')) $shortHtml .= '</p>';
                                    $moreHtml = '<p' . implode('</p><p', array_slice($paragraphs, $visibleCount));
                                    if (!str_ends_with(rtrim($moreHtml), '</p>')) $moreHtml .= '</p>';
                                } else {
                                    $shortHtml = $fullDesc;
                                }
                            @endphp
                            <div id="shortText">{!! $shortHtml !!}</div>
                            @if($hasMore)
                            <div id="moreText" style="display:none;">{!! $moreHtml !!}</div>
                            <button class="btn btn-primary mt-2" id="readMoreBtn">Read More</button>
                            @endif
                        </div>

                        {{-- Right: Highlights table --}}
                        <div class="col-lg-5 col-md-12">
                            <div class="p-3 rounded shadow-sm" style="background-color:#d1d1ff;">
                                <h4>{{ $trekRoute->name }} Highlights</h4>
                                <table class="table table-borderless">
                                    <tbody>
                                        @if($trekRoute->attractions && count((array)$trekRoute->attractions))
                                        {{-- City tour table --}}
                                        @if($trekRoute->total_distance)
                                        <tr><th>Duration</th><td>{{ $trekRoute->total_distance }}</td></tr>
                                        @endif
                                        @php
                                            $attractionNames = collect((array)$trekRoute->attractions)->pluck('name')->filter()->implode(', ');
                                        @endphp
                                        @if($attractionNames)
                                        <tr><th>Main Attractions</th><td>{{ $attractionNames }}</td></tr>
                                        @endif
                                        @if($trekRoute->difficulty)
                                        <tr><th>Difficulty</th><td>{{ $trekRoute->difficulty }}</td></tr>
                                        @endif
                                        @if($trekRoute->best_season)
                                        <tr><th>Best Season</th><td>{{ $trekRoute->best_season }}</td></tr>
                                        @endif
                                        @if($trekRoute->start_point)
                                        <tr><th>Points</th><td>{{ $trekRoute->start_point }}</td></tr>
                                        @endif
                                        @if($trekRoute->included_services && count((array)$trekRoute->included_services))
                                        <tr><th>Activities</th><td>{{ implode(', ', (array)$trekRoute->included_services) }}</td></tr>
                                        @endif
                                        @else
                                        {{-- Standard trek table --}}
                                        @if($trekRoute->duration_days)
                                        <tr><th>Duration</th><td>{{ $trekRoute->duration_days }} Days</td></tr>
                                        @elseif($trekRoute->total_distance && !str_contains($trekRoute->total_distance, 'km'))
                                        <tr><th>Duration</th><td>{{ $trekRoute->total_distance }}</td></tr>
                                        @endif
                                        @if($trekRoute->max_altitude)
                                        <tr><th>Max Elevation</th><td>{{ $trekRoute->max_altitude }}</td></tr>
                                        @endif
                                        @if($trekRoute->total_distance && str_contains($trekRoute->total_distance, 'km'))
                                        <tr><th>Trek Length</th><td>{{ $trekRoute->total_distance }}</td></tr>
                                        @endif
                                        @if($trekRoute->difficulty)
                                        <tr><th>Difficulty</th><td>{{ $trekRoute->difficulty }}</td></tr>
                                        @endif
                                        @if($trekRoute->best_season)
                                        <tr><th>Best Seasons</th><td>{{ $trekRoute->best_season }}</td></tr>
                                        @endif
                                        @if($trekRoute->start_point)
                                        <tr><th>Start Point</th><td>{{ $trekRoute->start_point }}</td></tr>
                                        @endif
                                        @if($trekRoute->end_point)
                                        <tr><th>End Point</th><td>{{ $trekRoute->end_point }}</td></tr>
                                        @endif
                                        <tr><th>Accommodation</th><td>Teahouse Trek</td></tr>
                                        <tr><th>Permits</th><td>ACAP &amp; TIMS (Required)</td></tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         3. FEATURES / HIGHLIGHTS CAROUSEL
    ═══════════════════════════════════════════════ --}}
    <section class="tours2 section-padding bg-lightnav" data-scroll-index="1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="owl-carousel owl-theme">
                        @if($trekRoute->gallery && count((array)$trekRoute->gallery))
                            @foreach((array)$trekRoute->gallery as $img)
                            <div class="tours2 left">
                                <figure><img src="{{ \App\Helpers\Cms::imageUrl($img) }}" alt="{{ $trekRoute->name }}" class="img-fluid"></figure>
                                <div class="caption padding-left">
                                    <div class="country country1">
                                        <h3>{{ $trekRoute->name }}</h3>
                                        <h4>Trek Experience</h4>
                                        <p>{{ $trekRoute->excerpt }}</p>
                                        @if($trekRoute->highlights && count((array)$trekRoute->highlights))
                                        <div class="row tour-list">
                                            @foreach(array_slice((array)$trekRoute->highlights, 0, 4) as $h)
                                            @php $hText = is_array($h) ? ($h['item'] ?? '') : $h; @endphp
                                            @if($hText)
                                            <div class="col-md-12"><ul><li><i class="ti-location-pin"></i> {{ $hText }}</li></ul></div>
                                            @endif
                                            @endforeach
                                        </div>
                                        @endif
                                        <div class="info-wrapper">
                                            <div class="more"><a href="#attractions" class="link-btn">View all attractions <i class="ti-arrow-right"></i></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                        @php
                            $carouselImg = $trekRoute->featured_image
                                ? (str_starts_with($trekRoute->featured_image, 'annapurna/')
                                    ? asset($trekRoute->featured_image)
                                    : \App\Helpers\Cms::imageUrl($trekRoute->featured_image))
                                : asset('annapurna/img/tours/annapurna-circuit-trek.jpg');
                            $hasHighlights = $trekRoute->highlights && count((array)$trekRoute->highlights);
                        @endphp
                        <div class="tours2 left">
                            <figure><img src="{{ $carouselImg }}" alt="{{ $trekRoute->name }}" class="img-fluid"></figure>
                            <div class="caption padding-left">
                                <div class="country country1">
                                    <h3>Best Tours</h3>
                                    <h4>Why Visit, {{ explode(' ', $trekRoute->name)[0] }}</h4>
                                    <p>{{ $trekRoute->excerpt }}</p>
                                    @if($hasHighlights)
                                    <div class="row tour-list">
                                        @foreach(array_slice((array)$trekRoute->highlights, 0, 4) as $h)
                                        @php $hText = is_array($h) ? ($h['item'] ?? '') : $h; @endphp
                                        @if($hText)
                                        <div class="col-md-12">
                                            <ul>
                                                <li><i class="ti-location-pin"></i> {{ $hText }}</li>
                                            </ul>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                    @endif
                                    <div class="info-wrapper">
                                        <div class="more"><a href="#attractions" class="link-btn" tabindex="0">View all attractions <i class="ti-arrow-right"></i></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         4. ITINERARY ACCORDION + BOOKING SIDEBAR
    ═══════════════════════════════════════════════ --}}
    <section class="tours2 section-padding101" data-scroll-index="1">
        <div class="container my-5">
            <div class="row">

                {{-- Left: Itinerary --}}
                <div class="col-lg-8 col-md-7 mb-4">
                    <div class="main-content">
                        <h2>{{ $trekRoute->name }} Itinerary and Daily Highlights</h2>
                        <p>Experience one of Nepal's most iconic treks through stunning mountain scenery and diverse local culture.</p>

                        @if($trekRoute->itinerary && count((array)$trekRoute->itinerary))
                        <ul class="accordion-box clearfix">
                            @foreach((array)$trekRoute->itinerary as $day)
                            <li class="accordion block">
                                <div class="acc-btn">{{ $day['day'] ?? '' }}: {{ $day['title'] ?? '' }}</div>
                                <div class="acc-content">
                                    <div class="content">
                                        <div class="text">
                                            <div>{!! $day['description'] ?? '' !!}</div>
                                            @if(!empty($day['highlights']))<p><i class="fa-solid fa-mountain-sun text-primary" style="margin-right:6px;"></i> <strong>Highlights:</strong> {{ $day['highlights'] }}</p>@endif
                                            @if(!empty($day['stay']))<p><i class="fa-solid fa-bed text-success" style="margin-right:6px;"></i> <strong>Stay:</strong> {{ $day['stay'] }}</p>@endif
                                            @if(!empty($day['altitude']))<p><i class="ti-location-pin text-primary"></i> <strong>Altitude:</strong> {{ $day['altitude'] }}</p>@endif
                                            @if(!empty($day['distance']))<p><i class="ti-map text-primary"></i> <strong>Distance:</strong> {{ $day['distance'] }}</p>@endif
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p>Detailed itinerary coming soon. Contact us for a complete day-by-day plan.</p>
                        @endif

                        {{-- Included / Excluded --}}
                        @if($trekRoute->included_services && count((array)$trekRoute->included_services) || $trekRoute->excluded_services && count((array)$trekRoute->excluded_services))
                        <div class="row mt-30">
                            @if($trekRoute->included_services && count((array)$trekRoute->included_services))
                            <div class="col-md-6">
                                <h5 style="color:#28a745;"><i class="ti-check"></i> Included</h5>
                                <ul class="list-unstyled">
                                    @foreach((array)$trekRoute->included_services as $item)
                                    <li><i class="ti-check" style="color:#28a745;margin-right:6px;"></i> {{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @if($trekRoute->excluded_services && count((array)$trekRoute->excluded_services))
                            <div class="col-md-6">
                                <h5 style="color:#dc3545;"><i class="ti-close"></i> Excluded</h5>
                                <ul class="list-unstyled">
                                    @foreach((array)$trekRoute->excluded_services as $item)
                                    <li><i class="ti-close" style="color:#dc3545;margin-right:6px;"></i> {{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                        @endif

                    </div>
                </div>

                {{-- Right: Booking Sidebar --}}
                <div class="col-lg-4 col-md-5">
                    <div class="sticky-form p-4 rounded-3 shadow-sm">
                        <h5 class="mb-3 text-center">Book This Trek</h5>

                        @if(session('success'))
                        <div class="alert alert-success d-flex align-items-center gap-2 mb-3" style="font-size:13px;border-radius:8px;">
                            <i class="ti-check-box"></i> {{ session('success') }}
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="alert alert-danger mb-3" style="font-size:13px;border-radius:8px;">
                            <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                        </div>
                        @endif

                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <input type="hidden" name="subject" value="Trek Booking Inquiry: {{ $trekRoute->name }}">
                            <div class="mb-3">
                                <label class="form-label">Package</label>
                                <input type="text" class="form-control custom-input" value="{{ $trekRoute->name }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control custom-input" placeholder="Your Name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control custom-input" placeholder="you@example.com" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control custom-input" placeholder="City, Country">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. of People</label>
                                <select name="people" class="form-select custom-input">
                                    <option>1</option><option>2</option><option>3</option><option>4</option><option>5+</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Message</label>
                                <textarea name="message" class="form-control custom-input" rows="3" placeholder="Your message..."></textarea>
                            </div>
                            <button type="submit" class="btn w-100 btn-dark">Send Enquiry</button>
                        </form>
                        @php $contact = \App\Helpers\Cms::contactInfo(); @endphp
                        @if($contact['phone'])
                        <div class="mt-20 text-center">
                            <p class="mb-5">Or call us directly:</p>
                            <a href="tel:{{ $contact['phone'] }}" class="btn btn-outline-dark btn-sm">
                                <i class="flaticon-phone-call"></i> {{ $contact['phone'] }}
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         5. ATTRACTIONS / TREK INFO (square-flip cards)
    ═══════════════════════════════════════════════ --}}
    @if($trekRoute->attractions && count((array)$trekRoute->attractions))
    {{-- Dynamic attraction cards from DB --}}
    <div id="attractions" class="tours3 section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-subtitle"><span>Most Popular Attractions</span></div>
                    <div class="section-title">{{ $trekRoute->name }} <span>Attractions</span></div>
                </div>
            </div>
            <div class="row">
                @php
                    $attrImageMap = [
                        'fewa'        => 'annapurna/img/destination/fewa-lake.jpg',
                        'sarangkot'   => 'annapurna/img/destination/sarangkot.jpg',
                        'davis'       => 'annapurna/img/destination/devis-fall.jpg',
                        'devis'       => 'annapurna/img/destination/devis-fall.jpg',
                        'gupteshwor'  => 'annapurna/img/destination/gupteshwor-mahadev.jpg',
                        'guptesh'     => 'annapurna/img/destination/gupteshwor-mahadev.jpg',
                        'begnas'      => 'annapurna/img/destination/begnas-lake.jpg',
                        'rupa'        => 'annapurna/img/destination/begnas-lake.jpg',
                        'seti'        => 'annapurna/img/destination/seti.jpg',
                        'bat cave'    => 'annapurna/img/destination/bat-cave.jpg',
                        'chamero'     => 'annapurna/img/destination/bat-cave.jpg',
                        'hilltop'     => 'annapurna/img/destination/village.jpg',
                        'village'     => 'annapurna/img/destination/village.jpg',
                    ];
                @endphp
                @foreach((array)$trekRoute->attractions as $attraction)
                @php
                    if (!empty($attraction['image'])) {
                        $attrImg = \App\Helpers\Cms::imageUrl($attraction['image']);
                    } else {
                        $nameLower = strtolower($attraction['name'] ?? '');
                        $attrImg = asset('annapurna/img/destination/fewa-lake.jpg');
                        foreach ($attrImageMap as $key => $path) {
                            if (str_contains($nameLower, $key)) { $attrImg = asset($path); break; }
                        }
                    }
                @endphp
                <div class="col-md-3">
                    <div class="square-flip">
                        <div class="square bg-img" data-background="{{ $attrImg }}">
                            <span class="category"><a href="#">{{ $attraction['category'] ?? 'Nepal' }}</a></span>
                            <div class="square-container d-flex align-items-end justify-content-end">
                                <div class="box-title"><h4>{{ $attraction['name'] ?? '' }}</h4></div>
                            </div>
                            <div class="flip-overlay"></div>
                        </div>
                        <div class="square2">
                            <div class="square-container2">
                                <h4>{{ $attraction['name'] ?? '' }}</h4>
                                <p>{{ $attraction['description'] ?? '' }}</p>
                                <div class="row tour-list mb-30">
                                    <div class="col col-md-12">
                                        <ul>
                                            @if(!empty($attraction['location']))<li><i class="ti-location-pin"></i> {{ $attraction['location'] }}</li>@endif
                                            @if(!empty($attraction['rating']))<li><i class="ti-face-smile"></i> {{ $attraction['rating'] }}</li>@endif
                                        </ul>
                                    </div>
                                </div>
                                <div class="btn-line"><a href="{{ route('trek-routes.index') }}">Find Agencies</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @else
    {{-- Generic trek information cards (shown for hiking/trekking routes) --}}
    <div class="tours3 section-padding bg-lightnav">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-subtitle"><span>Annapurna Region Guide</span></div>
                    <div class="section-title">Essential <span>Trek Information</span></div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-4">
                    <div class="square-flip">
                        <div class="square bg-img" data-background="{{ asset('annapurna/img/destination/ghandruk-village-annapurna.png') }}">
                            <span class="category"><a href="#">Annapurna</a></span>
                            <div class="square-container d-flex align-items-end justify-content-end">
                                <div class="box-title"><h4>Accommodation</h4><h6>Comfortable Lodges</h6></div>
                            </div>
                            <div class="flip-overlay"></div>
                        </div>
                        <div class="square2 bg-white">
                            <div class="square-container2">
                                <h4>Accommodation on the Trek</h4>
                                <h6>Teahouses &amp; Lodges</h6>
                                <p>Stay in cozy teahouses offering twin-sharing rooms and warm hospitality. Hot showers and charging are available at lower altitudes.</p>
                                <div class="row tour-list mb-30">
                                    <div class="col-md-6"><ul><li style="font-size:16px;"><i class="ti-home"></i> Twin Rooms</li><li style="font-size:16px;"><i class="ti-bolt"></i> Hot Showers</li></ul></div>
                                    <div class="col-md-6"><ul><li style="font-size:16px;"><i class="ti-plug"></i> Solar Power</li><li style="font-size:16px;"><i class="ti-star"></i> Shared Toilets</li></ul></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="square-flip">
                        <div class="square bg-img" data-background="{{ asset('annapurna/img/destination/food-annapurna-region.jpg') }}">
                            <span class="category"><a href="#">Annapurna</a></span>
                            <div class="square-container d-flex align-items-end justify-content-end">
                                <div class="box-title"><h4>Food</h4><h6>Healthy Meals</h6></div>
                            </div>
                            <div class="flip-overlay"></div>
                        </div>
                        <div class="square2 bg-white">
                            <div class="square-container2">
                                <h4>Food on the Trek</h4>
                                <h6>Nutritious &amp; Local</h6>
                                <p>Enjoy "Dal Bhat Power", noodles, fried rice, pasta, and soups. Fresh vegetarian options and teas are available at every stop.</p>
                                <div class="row tour-list mb-30">
                                    <div class="col-md-6"><ul><li style="font-size:16px;"><i class="ti-cup"></i> Tea &amp; Coffee</li><li style="font-size:16px;"><i class="ti-face-smile"></i> Veg Options</li></ul></div>
                                    <div class="col-md-6"><ul><li style="font-size:16px;"><i class="ti-money"></i> Prices vary</li><li style="font-size:16px;"><i class="ti-star"></i> Local Dal Bhat</li></ul></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="square-flip">
                        <div class="square bg-img" data-background="{{ asset('annapurna/img/destination/muktinath-jomsom-annapurna.png') }}">
                            <span class="category"><a href="#">Annapurna</a></span>
                            <div class="square-container d-flex align-items-end justify-content-end">
                                <div class="box-title"><h4>Local Culture</h4><h6>Warm Hospitality</h6></div>
                            </div>
                            <div class="flip-overlay"></div>
                        </div>
                        <div class="square2 bg-white">
                            <div class="square-container2">
                                <h4>Local People &amp; Culture</h4>
                                <h6>Gurung &amp; Magar Villages</h6>
                                <p>Meet friendly locals, taste traditional food, and experience Buddhist influence in the villages of the Annapurna region.</p>
                                <div class="row tour-list mb-30">
                                    <div class="col-md-6"><ul><li style="font-size:16px;"><i class="ti-heart"></i> Friendly Locals</li><li style="font-size:16px;"><i class="ti-world"></i> Buddhist Heritage</li></ul></div>
                                    <div class="col-md-6"><ul><li style="font-size:16px;"><i class="ti-user"></i> English Guides</li><li style="font-size:16px;"><i class="ti-map"></i> Cultural Trails</li></ul></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="square-flip">
                        <div class="square bg-img" data-background="{{ asset('annapurna/img/destination/annapurna-circuit.png') }}">
                            <span class="category"><a href="#">Annapurna</a></span>
                            <div class="square-container d-flex align-items-end justify-content-end">
                                <div class="box-title"><h4>Difficulty</h4><h6>{{ $trekRoute->difficulty ?? 'Moderate' }} Level</h6></div>
                            </div>
                            <div class="flip-overlay"></div>
                        </div>
                        <div class="square2 bg-white">
                            <div class="square-container2">
                                <h4>Trek Difficulty &amp; Fitness</h4>
                                <h6>{{ $trekRoute->difficulty ?? 'Moderate' }} Challenge</h6>
                                <p>Average 5–7 hours walking daily on mountain trails. Some steep climbs and stone steps. Regular pace makes it enjoyable for all.</p>
                                <div class="row tour-list mb-30">
                                    <div class="col-md-6"><ul><li style="font-size:16px;"><i class="ti-time"></i> 5–7 hrs/day</li><li style="font-size:16px;"><i class="ti-stats-up"></i> Gradual Ascent</li></ul></div>
                                    <div class="col-md-6"><ul><li style="font-size:16px;"><i class="ti-pulse"></i> {{ $trekRoute->difficulty ?? 'Moderate' }}</li><li style="font-size:16px;"><i class="ti-thumb-up"></i> Beginner Friendly</li></ul></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="square-flip">
                        <div class="square bg-img" data-background="{{ asset('annapurna/img/destination/travelling-cost-annapurna-region.jpg') }}">
                            <div class="square-container d-flex align-items-end justify-content-end">
                                <div class="box-title"><h4>Permits &amp; Costs</h4><h6>ACAP + TIMS</h6></div>
                            </div>
                            <div class="flip-overlay"></div>
                        </div>
                        <div class="square2 bg-white">
                            <div class="square-container2">
                                <h4>Permits &amp; Trek Costs</h4>
                                <h6>Required Documents</h6>
                                <p>ACAP and TIMS permits are mandatory. Guides cost $25–35/day and porters $20–30/day. Meals and lodging $25–40/day.</p>
                                <div class="row tour-list mb-30">
                                    <div class="col-md-6"><ul><li style="font-size:16px;"><i class="ti-id-badge"></i> ACAP Permit</li><li style="font-size:16px;"><i class="ti-bookmark-alt"></i> TIMS Card</li></ul></div>
                                    <div class="col-md-6"><ul><li style="font-size:16px;"><i class="ti-wallet"></i> $25–40/day</li><li style="font-size:16px;"><i class="ti-flag-alt"></i> Local Fees</li></ul></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="square-flip">
                        <div class="square bg-img" data-background="{{ asset('annapurna/img/destination/best-time-annapurna-region.jpg') }}">
                            <div class="square-container d-flex align-items-end justify-content-end">
                                <div class="box-title"><h4>Best Time</h4><h6>{{ $trekRoute->best_season ? Str::limit($trekRoute->best_season, 20) : 'Seasons' }}</h6></div>
                            </div>
                            <div class="flip-overlay"></div>
                        </div>
                        <div class="square2 bg-white">
                            <div class="square-container2">
                                <h4>Best Time to Trek</h4>
                                <h6>{{ $trekRoute->best_season ?? 'Spring &amp; Autumn' }}</h6>
                                <p>March–May and September–November are ideal. Clear skies, moderate temperatures, and rhododendron blooms make these months perfect.</p>
                                <div class="row tour-list mb-30">
                                    <div class="col-md-6"><ul><li style="font-size:16px;"><i class="ti-sun"></i> Clear Skies</li><li style="font-size:16px;"><i class="ti-leaf"></i> Rhododendrons</li></ul></div>
                                    <div class="col-md-6"><ul><li style="font-size:16px;"><i class="ti-rain"></i> Avoid Monsoon</li><li style="font-size:16px;"><i class="ti-weather-night"></i> Cold Winters</li></ul></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endif

    {{-- ═══════════════════════════════════════════════
         6. FAQ INFO CARDS
    ═══════════════════════════════════════════════ --}}
    <section class="tours2 section-padding bg-lightnav">
        <div class="container my-5">
            <div class="text-center mb-5">
                <h3 class="fw-bold">Frequently Asked Questions (FAQs)</h3>
                <p class="text-muted">Get answers to common queries about trekking in the Annapurna region.</p>
            </div>
            <div class="row g-4">

                @if($trekRoute->faqs && count((array)$trekRoute->faqs))
                    @php
                        $faqIcons = ['flaticon-wifi','flaticon-shower','flaticon-cash','flaticon-water','flaticon-toilet','flaticon-location','flaticon-backpack','flaticon-budget','flaticon-weather','flaticon-snow','flaticon-heart','flaticon-mountain','flaticon-map','flaticon-plane','flaticon-question'];
                    @endphp
                    @foreach((array)$trekRoute->faqs as $i => $faq)
                    <div class="col-md-4">
                        <div class="info-card h-100 text-center p-4">
                            <div class="icon mb-3">
                                <i class="{{ $faqIcons[$i % count($faqIcons)] }} display-5 text-purple"></i>
                            </div>
                            <h5 class="fw-semibold mb-2">{{ $faq['question'] ?? '' }}</h5>
                            <p class="text-muted">{{ $faq['answer'] ?? '' }}</p>
                        </div>
                    </div>
                    @endforeach
                @else
                {{-- Generic FAQ cards for all Annapurna treks --}}
                <div class="col-md-4">
                    <div class="info-card h-100 text-center p-4">
                        <div class="icon mb-3"><i class="flaticon-wifi display-5 text-purple"></i></div>
                        <h5 class="fw-semibold mb-2">Is WiFi available?</h5>
                        <p class="text-muted">Yes, paid WiFi is available in most teahouses; free WiFi in a few lower altitude lodges.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card h-100 text-center p-4">
                        <div class="icon mb-3"><i class="flaticon-shower display-5 text-purple"></i></div>
                        <h5 class="fw-semibold mb-2">Hot showers available?</h5>
                        <p class="text-muted">Hot showers are common in lower altitude lodges; higher elevations may have limited or paid facilities.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card h-100 text-center p-4">
                        <div class="icon mb-3"><i class="flaticon-cash display-5 text-purple"></i></div>
                        <h5 class="fw-semibold mb-2">How do I pay on the trek?</h5>
                        <p class="text-muted">Cash is essential; ATMs are only in Pokhara, Jomsom, and some major villages.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card h-100 text-center p-4">
                        <div class="icon mb-3"><i class="flaticon-water display-5 text-purple"></i></div>
                        <h5 class="fw-semibold mb-2">Is the water safe to drink?</h5>
                        <p class="text-muted">Drinking water should be purified. Bottled water is available at most teahouses.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card h-100 text-center p-4">
                        <div class="icon mb-3"><i class="flaticon-toilet display-5 text-purple"></i></div>
                        <h5 class="fw-semibold mb-2">Type of toilets?</h5>
                        <p class="text-muted">Mixture of Western and squat toilets, depending on the lodge and altitude.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card h-100 text-center p-4">
                        <div class="icon mb-3"><i class="flaticon-location display-5 text-purple"></i></div>
                        <h5 class="fw-semibold mb-2">Starting Point</h5>
                        <p class="text-muted">{{ $trekRoute->start_point ? 'Most treks start from ' . $trekRoute->start_point . '.' : 'Most treks start from Pokhara.' }} Accessible by domestic flight, tourist bus, or private car hire.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-card h-100 text-center p-4">
                        <div class="icon mb-3"><i class="flaticon-backpack display-5 text-purple"></i></div>
                        <h5 class="fw-semibold mb-2">Packing Essentials</h5>
                        <p class="text-muted">
                            Trekking boots, layered clothing, gloves, hat, raincoat.<br>
                            Backpack (30–40L) with rain cover.<br>
                            Sleeping bag (up to –10°C).<br>
                            Trekking poles, headlamp, personal medicines.<br>
                            Reusable water bottle &amp; purification tablets.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-card h-100 text-center p-4">
                        <div class="icon mb-3"><i class="flaticon-budget display-5 text-purple"></i></div>
                        <h5 class="fw-semibold mb-2">Estimated Budget</h5>
                        <p class="text-muted">
                            Guide: USD 25–35/day<br>
                            Porter: USD 20–30/day<br>
                            Meals &amp; Stay: USD 25–40/day depending on altitude
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card h-100 text-center p-4">
                        <div class="icon mb-3"><i class="flaticon-weather display-5 text-purple"></i></div>
                        <h5 class="fw-semibold mb-2">Best Time to Visit?</h5>
                        <p class="text-muted">{{ $trekRoute->best_season ? 'Best season: ' . $trekRoute->best_season . '.' : 'Ideal months are March–May (Spring) and September–November (Autumn).' }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card h-100 text-center p-4">
                        <div class="icon mb-3"><i class="flaticon-snow display-5 text-purple"></i></div>
                        <h5 class="fw-semibold mb-2">Weather &amp; Temperature</h5>
                        <p class="text-muted">Cold nights above 3,000m; day temperatures moderate. Carry warm layers, gloves, and thermal wear.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card h-100 text-center p-4">
                        <div class="icon mb-3"><i class="flaticon-heart display-5 text-purple"></i></div>
                        <h5 class="fw-semibold mb-2">Health &amp; Safety</h5>
                        <p class="text-muted">Acclimatize properly to avoid altitude sickness. Carry first aid and medications. Avoid alcohol at high altitudes.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-card h-100 text-center p-4">
                        <div class="icon mb-3"><i class="flaticon-mountain display-5 text-purple"></i></div>
                        <h5 class="fw-semibold mb-2">Trek Difficulty</h5>
                        <p class="text-muted">{{ $trekRoute->difficulty ?? 'Moderate' }} difficulty; 5–7 hours trekking per day. Steep climbs in parts. Suitable for beginners with fitness preparation.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-card h-100 text-center p-4">
                        <div class="icon mb-3"><i class="flaticon-map display-5 text-purple"></i></div>
                        <h5 class="fw-semibold mb-2">Guides &amp; Porters</h5>
                        <p class="text-muted">Hiring a guide is recommended for safety, cultural insight, and navigation. Porters carry luggage for easier trekking.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-card h-100 text-center p-4">
                        <div class="icon mb-3"><i class="flaticon-plane display-5 text-purple"></i></div>
                        <h5 class="fw-semibold mb-2">Transportation Options</h5>
                        <p class="text-muted">Pokhara accessible via domestic flight or bus. Trek start points reachable by jeep or bus. Return to Pokhara by same options.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-card h-100 text-center p-4">
                        <div class="icon mb-3"><i class="flaticon-question display-5 text-purple"></i></div>
                        <h5 class="fw-semibold mb-2">Connectivity &amp; Mobile Network</h5>
                        <p class="text-muted">Mobile networks present in major villages. SIM cards work in Pokhara, Jomsom, and Besisahar. Offline maps recommended for trekking.</p>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         7. TREK HIGHLIGHTS / WAYPOINTS GRID
    ═══════════════════════════════════════════════ --}}
    @if($trekRoute->itinerary && count((array)$trekRoute->itinerary))
    @php
        $waypointImages = [
            'pokhara'        => 'annapurna/img/tours/pokhara-tour-annapurna-region.jpg',
            'nayapul'        => 'annapurna/img/tours/nayapul-ghandruk-annapurna-region.jpg',
            'tikhedhunga'    => 'annapurna/img/tours/nayapul-ghandruk-annapurna-region.jpg',
            'ghorepani'      => 'annapurna/img/tours/ghorepani-poonhill-annapurna-region.jpg',
            'poon hill'      => 'annapurna/img/tours/ghorepani-poonhill-annapurna-region.jpg',
            'tadapani'       => 'annapurna/img/tours/tadapani-annapurna-region.jpg',
            'chhomrong'      => 'annapurna/img/tours/chhomrong-annapurna-region.jpg',
            'chomrong'       => 'annapurna/img/tours/chhomrong-annapurna-region.jpg',
            'bamboo'         => 'annapurna/img/tours/bamboo-dovan-annapurna-region.jpg',
            'dovan'          => 'annapurna/img/tours/bamboo-dovan-annapurna-region.jpg',
            'deurali'        => 'annapurna/img/tours/deurali-annapurna-region.jpg',
            'machapuchhre'   => 'annapurna/img/tours/abc-annapurna-range.jpg',
            'base camp'      => 'annapurna/img/tours/abc-annapurna-range.jpg',
            'chame'          => 'annapurna/img/tours/chame-ananpurna-region.jpg',
            'manang'         => 'annapurna/img/tours/manang-annapurna-region.jpg',
            'thorong'        => 'annapurna/img/tours/thorong-phedi-annapurna-region.jpg',
            'muktinath'      => 'annapurna/img/tours/muktinath-jomsom-annapurna-region.png',
            'jomsom'         => 'annapurna/img/tours/muktinath-jomsom-annapurna-region.png',
        ];
        $defaultWaypointImg = 'annapurna/img/tours/annapurna-circuit-trek.jpg';

        $getWaypointImage = function(string $title) use ($waypointImages, $defaultWaypointImg): string {
            $lower = strtolower($title);
            foreach ($waypointImages as $keyword => $img) {
                if (str_contains($lower, $keyword)) return $img;
            }
            return $defaultWaypointImg;
        };
    @endphp
    <section class="tours1 section-padding" id="attractions" data-scroll-index="1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-subtitle"><span>Trek Highlights</span></div>
                    <div class="section-title">From Pokhara to <span>{{ $trekRoute->name }}</span></div>
                </div>
            </div>
            <div class="row">
                @foreach((array)$trekRoute->itinerary as $day)
                @php
                    $wpTitle = $day['title'] ?? '';
                    $wpImg   = $getWaypointImage($wpTitle);
                    $wpAlt   = $day['altitude'] ?? '';
                @endphp
                <div class="col-md-4">
                    <div class="item">
                        <div class="position-re o-hidden">
                            <img src="{{ asset($wpImg) }}" alt="{{ $wpTitle }}">
                        </div>
                        <div class="con">
                            <h5><a href="#">{{ $wpTitle }}{{ $wpAlt ? ' (' . $wpAlt . ')' : '' }}</a></h5>
                            <div class="line"></div>
                            <div class="row facilities">
                                <div class="col-md-12">
                                    <ul>
                                        <li><i class="ti-time"></i> {{ $day['day'] ?? 'Day' }}</li>
                                        @if(!empty($day['distance']))<li><i class="ti-location-pin"></i> {{ $day['distance'] }}</li>@endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══════════════════════════════════════════════
         8. MAP EMBED
    ═══════════════════════════════════════════════ --}}
    @if($trekRoute->map_embed)
    <section class="section-padding pt-0">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="mb-20">Trek Map</h3>
                    {!! $trekRoute->map_embed !!}
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ═══════════════════════════════════════════════
         9. RELATED TREK ROUTES
    ═══════════════════════════════════════════════ --}}
    @if(isset($relatedTreks) && $relatedTreks->isNotEmpty())
    <section class="tours1 section-padding bg-lightnav">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>Explore More</span></div>
                    <div class="section-title">Related <span>Trek Routes</span></div>
                </div>
            </div>
            <div class="row">
                @foreach($relatedTreks as $related)
                <div class="col-md-4 col-sm-6">
                    <div class="item">
                        <a href="{{ route('trek-routes.show', $related->slug) }}">
                            <div class="position-re o-hidden">
                                @if($related->featured_image)
                                    <img src="{{ \App\Helpers\Cms::imageUrl($related->featured_image) }}" alt="{{ $related->name }}">
                                @else
                                    <img src="{{ asset('annapurna/img/tours/annapurna-circuit-trek.jpg') }}" alt="{{ $related->name }}">
                                @endif
                            </div>
                            <span class="category"><i class="ti-flag-alt"></i> {{ $related->difficulty ?? 'Moderate' }}</span>
                            <div class="con">
                                <h5><a href="{{ route('trek-routes.show', $related->slug) }}">{{ $related->name }}</a></h5>
                                <p>{{ Str::limit($related->excerpt, 100) }}</p>
                                <div class="line"></div>
                                <div class="row facilities">
                                    <div class="col col-md-12">
                                        <ul>
                                            @if($related->duration_days)<li><i class="ti-time"></i> {{ $related->duration_days }} Days</li>@endif
                                            @if($related->max_altitude)<li><i class="ti-location-pin"></i> {{ $related->max_altitude }}</li>@endif
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('readMoreBtn');
    if (btn) {
        btn.addEventListener('click', function () {
            var more  = document.getElementById('moreText');
            var short = document.getElementById('shortText');
            if (more.style.display === 'none') {
                more.style.display  = 'block';
                short.style.display = 'none';
                btn.textContent     = 'Read Less';
            } else {
                more.style.display  = 'none';
                short.style.display = 'block';
                btn.textContent     = 'Read More';
                more.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }
});
</script>
@endpush
