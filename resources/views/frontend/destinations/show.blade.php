@extends('layouts.app')

@section('meta_title', ($destination->meta_title ?: $destination->name) . ' - Annapurna Region')
@section('meta_description', $destination->meta_description ?: Str::limit($destination->excerpt, 160))
@section('og_title', $destination->meta_title ?: $destination->name)

@section('content')

    {{-- Header Banner --}}
    <div class="banner-header section-padding back-position-center valign bg-img bg-fixed"
         data-overlay-dark="5"
         data-background="{{ $destination->featured_image ? \App\Helpers\Cms::imageUrl($destination->featured_image) : asset('annapurna/img/slider/pokhara-valley-tour.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-9 text-left caption mt-90">
                    <h6><a href="{{ route('destinations.index') }}">Destinations</a> / {{ $destination->name }}</h6>
                    <h1>{{ $destination->name }} | <span style="font-size: 30px; color:#fff">Annapurna Region, Nepal</span></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('destinations.index') }}">Destinations</a></li>
                            <li class="breadcrumb-item active">{{ $destination->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Overview & Key Info --}}
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ $destination->name }}</h2>
                    <div class="row">

                        {{-- Left: Description --}}
                        <div class="col-md-7">
                            <div id="shortText">
                                {!! $destination->description ? Str::words(strip_tags($destination->description), 120, '...') : '<p>' . ($destination->excerpt ?? '') . '</p>' !!}
                            </div>
                            @if($destination->description && str_word_count(strip_tags($destination->description)) > 120)
                            <div id="moreText" style="display: none;">
                                {!! $destination->description !!}
                            </div>
                            <button class="btn btn-primary mt-2" id="readMoreBtn">Read More</button>
                            @endif
                        </div>

                        {{-- Right: Highlights Table --}}
                        <div class="col-lg-5 col-md-12">
                            <div class="p-3 rounded shadow-sm" style="background-color: #d1d1ff;">
                                <h4>{{ $destination->name }} Highlights</h4>
                                <table class="table table-borderless">
                                    <tbody>
                                        @if($destination->region)
                                        <tr>
                                            <th>Region</th>
                                            <td>{{ $destination->region }}</td>
                                        </tr>
                                        @endif
                                        @if($destination->altitude)
                                        <tr>
                                            <th>Altitude</th>
                                            <td>{{ $destination->altitude }}</td>
                                        </tr>
                                        @endif
                                        @if($destination->best_season)
                                        <tr>
                                            <th>Best Season</th>
                                            <td>{{ $destination->best_season }}</td>
                                        </tr>
                                        @endif
                                        @if(!empty($destination->activities))
                                        <tr>
                                            <th>Activities</th>
                                            <td>
                                                @if(is_array($destination->activities))
                                                    {{ implode(', ', $destination->activities) }}
                                                @else
                                                    {{ $destination->activities }}
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <div class="butn-dark mt-10">
                                    <a href="{{ route('contact') }}"><span>Plan Your Visit <i class="ti-arrow-right"></i></span></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Gallery Carousel --}}
    @if(!empty($destination->gallery) && count($destination->gallery) > 0)
    <section class="tours2 section-padding bg-lightnav">
        <div class="container">
            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-title">Photo <span>Gallery</span></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="owl-carousel owl-theme">
                        @foreach($destination->gallery as $image)
                        <div class="item">
                            <div class="position-re o-hidden">
                                <img src="{{ \App\Helpers\Cms::imageUrl($image) }}" alt="{{ $destination->name }}" class="img-fluid">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Activities Section --}}
    @if(!empty($destination->activities) && count($destination->activities) > 0)
    <section class="tours2 section-padding">
        <div class="container">
            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>Things to Do</span></div>
                    <div class="section-title">Activities in <span>{{ $destination->name }}</span></div>
                </div>
            </div>
            <div class="row">
                @foreach($destination->activities as $activity)
                <div class="col-md-4 col-sm-6 mb-30">
                    <div class="item-box">
                        <div class="cont">
                            <i class="ti-check-box" style="font-size: 24px; color: #6a0dad;"></i>
                            <h5 class="mt-10">{{ is_array($activity) ? ($activity['name'] ?? $activity) : $activity }}</h5>
                            @if(is_array($activity) && isset($activity['description']))
                            <p>{{ $activity['description'] }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Itinerary Section (if present) --}}
    @if(!empty($destination->itinerary) && count($destination->itinerary) > 0)
    <section class="tours2 section-padding101">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-7 mb-4">
                    <div class="main-content">
                        <h2>Suggested Itinerary for {{ $destination->name }}</h2>
                        <ul class="accordion-box clearfix">
                            @foreach($destination->itinerary as $index => $day)
                            <li class="accordion block">
                                <div class="acc-btn">{{ $day['day'] ?? ('Day ' . ($index + 1)) }}: {{ $day['title'] ?? '' }}</div>
                                <div class="acc-content">
                                    <div class="content">
                                        <div class="text">
                                            <p>{{ $day['description'] ?? '' }}</p>
                                            @if(!empty($day['altitude']))<p><i class="ti-location-pin"></i> <strong>Altitude:</strong> {{ $day['altitude'] }}</p>@endif
                                            @if(!empty($day['distance']))<p><i class="ti-arrow-right"></i> <strong>Distance:</strong> {{ $day['distance'] }}</p>@endif
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- Sticky Booking Sidebar --}}
                <div class="col-lg-4 col-md-5">
                    <div class="sticky-form p-4 rounded-3 shadow-sm" style="background-color: #d1d1ff; position: sticky; top: 90px;">
                        <h5 class="mb-3 text-center">Plan Your Visit</h5>

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

                        <form method="POST" action="{{ route('contact.submit') }}">
                            @csrf
                            <input type="hidden" name="subject" value="Inquiry: {{ $destination->name }}">
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Your Full Name" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="phone" class="form-control" placeholder="Phone Number">
                            </div>
                            <div class="mb-3">
                                <textarea name="message" class="form-control" rows="3" placeholder="Tell us about your travel plans..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-dark w-100">Send Enquiry</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @else
    {{-- Booking CTA when no itinerary --}}
    <section class="tours2 section-padding bg-lightnav">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="section-subtitle"><span>Plan Your Trip</span></div>
                    <div class="section-title">Visit <span>{{ $destination->name }}</span></div>
                    <p>Ready to explore {{ $destination->name }}? Get in touch with our team to plan your perfect adventure in the Annapurna Region.</p>
                    <div class="row mt-30">
                        <div class="col-md-12">
                            <div class="butn-dark">
                                <a href="{{ route('contact') }}"><span>Contact Us <i class="ti-arrow-right"></i></span></a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Inline Booking Form --}}
                <div class="col-md-4">
                    <div class="p-4 rounded shadow-sm" style="background-color: #d1d1ff;">
                        <h5 class="mb-3">Quick Enquiry</h5>
                        <form method="POST" action="{{ route('contact.submit') }}">
                            @csrf
                            <input type="hidden" name="subject" value="Inquiry: {{ $destination->name }}">
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Your Full Name" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="phone" class="form-control" placeholder="Phone Number">
                            </div>
                            <div class="mb-3">
                                <textarea name="message" class="form-control" rows="3" placeholder="Your message..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-dark w-100">Send Enquiry</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Attractions / Square Flip Cards --}}
    @if(isset($attractions) && $attractions->isNotEmpty())
    <div class="tours3 section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-subtitle"><span>Must-See Places</span></div>
                    <div class="section-title">{{ $destination->name }} <span>Attractions</span></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        @foreach($attractions as $attraction)
                        <div class="col-md-3">
                            <div class="square-flip">
                                <div class="square bg-img"
                                     data-background="{{ $attraction->featured_image ? \App\Helpers\Cms::imageUrl($attraction->featured_image) : asset('annapurna/img/destination/fewa-lake.jpg') }}">
                                    <span class="category"><a href="#">{{ $destination->region ?? 'Nepal' }}</a></span>
                                    <div class="square-container d-flex align-items-end justify-content-end">
                                        <div class="box-title">
                                            <h4>{{ $attraction->name }}</h4>
                                        </div>
                                    </div>
                                    <div class="flip-overlay"></div>
                                </div>
                                <div class="square2">
                                    <div class="square-container2">
                                        <h4>{{ $attraction->name }}</h4>
                                        <p>{{ Str::limit($attraction->excerpt ?? $attraction->description, 120) }}</p>
                                        <div class="row tour-list mb-30">
                                            <div class="col col-md-12">
                                                <ul>
                                                    @if($attraction->altitude)<li><i class="ti-location-pin"></i> {{ $attraction->altitude }}</li>@endif
                                                    @if($attraction->best_season)<li><i class="ti-calendar"></i> {{ $attraction->best_season }}</li>@endif
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="btn-line"><a href="{{ route('destinations.show', $attraction->slug) }}">Explore</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- FAQs Section --}}
    @if(isset($faqs) && $faqs->isNotEmpty())
    <section class="tours2 section-padding bg-lightnav">
        <div class="container">
            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>Common Questions</span></div>
                    <div class="section-title">FAQs About <span>{{ $destination->name }}</span></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    @foreach($faqs as $faq)
                    <ul class="accordion-box clearfix">
                        <li class="accordion block">
                            <div class="acc-btn">{{ $faq->question }}</div>
                            <div class="acc-content">
                                <div class="content">
                                    <div class="text">
                                        <p>{!! $faq->answer !!}</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Related Trek Routes --}}
    @if(isset($relatedTreks) && $relatedTreks->isNotEmpty())
    <section class="tours1 section-padding">
        <div class="container">
            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>Popular Treks Nearby</span></div>
                    <div class="section-title">Trek Routes in <span>{{ $destination->name }}</span></div>
                </div>
            </div>
            <div class="row">
                @foreach($relatedTreks as $trek)
                <div class="col-md-4 col-sm-6 mb-30">
                    <div class="item">
                        <a href="{{ route('trek-routes.show', $trek->slug) }}">
                            <div class="position-re o-hidden">
                                @if($trek->featured_image)
                                    <img src="{{ \App\Helpers\Cms::imageUrl($trek->featured_image) }}" alt="{{ $trek->name }}">
                                @else
                                    <img src="{{ asset('annapurna/img/tours/annapurna-circuit.jpg') }}" alt="{{ $trek->name }}">
                                @endif
                            </div>
                            @if($trek->difficulty)
                            <span class="category">
                                <a href="{{ route('trek-routes.show', $trek->slug) }}">{{ $trek->difficulty }}</a>
                            </span>
                            @endif
                            <div class="con">
                                <h5><a href="{{ route('trek-routes.show', $trek->slug) }}">{{ $trek->name }}</a></h5>
                                @if($trek->excerpt)<p>{{ Str::limit($trek->excerpt, 100) }}</p>@endif
                                <div class="line"></div>
                                <div class="row facilities">
                                    <div class="col col-md-12">
                                        <ul>
                                            @if($trek->duration_days)<li><i class="ti-time"></i> {{ $trek->duration_days }} Days</li>@endif
                                            @if($trek->max_altitude)<li><i class="ti-location-pin"></i> {{ $trek->max_altitude }}</li>@endif
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

    {{-- Related Destinations --}}
    @if(isset($relatedDestinations) && $relatedDestinations->isNotEmpty())
    <section class="tours1 section-padding bg-lightnav">
        <div class="container">
            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>Explore More</span></div>
                    <div class="section-title">Related <span>Destinations</span></div>
                </div>
            </div>
            <div class="row">
                @foreach($relatedDestinations as $related)
                <div class="col-md-4 col-sm-6 mb-30">
                    <div class="item">
                        <a href="{{ route('destinations.show', $related->slug) }}">
                            <div class="position-re o-hidden">
                                @if($related->featured_image)
                                    <img src="{{ \App\Helpers\Cms::imageUrl($related->featured_image) }}" alt="{{ $related->name }}">
                                @else
                                    <img src="{{ asset('annapurna/img/tours/annapurna-circuit.jpg') }}" alt="{{ $related->name }}">
                                @endif
                            </div>
                            @if($related->altitude)
                            <span class="category">
                                <a href="{{ route('destinations.show', $related->slug) }}"><i class="ti-location-pin"></i> {{ $related->altitude }}</a>
                            </span>
                            @endif
                            <div class="con">
                                <h5><a href="{{ route('destinations.show', $related->slug) }}">{{ $related->name }}</a></h5>
                                @if($related->excerpt)<p>{{ Str::limit($related->excerpt, 100) }}</p>@endif
                                <div class="line"></div>
                                <div class="row facilities">
                                    <div class="col col-md-12">
                                        <ul>
                                            @if($related->region)<li><i class="ti-location-pin"></i> {{ $related->region }}</li>@endif
                                            <li><i class="ti-calendar"></i> Best: {{ $related->best_season ?? 'Year-round' }}</li>
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
</script>
@endpush

@endsection
