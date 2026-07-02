@extends('layouts.app')

@section('meta_title', isset($page) && $page?->meta_title ? $page->meta_title : \App\Helpers\Cms::setting('contact_meta_title', 'Contact Us - Annapurna Region'))
@section('meta_description', isset($page) && $page?->meta_description ? $page->meta_description : \App\Helpers\Cms::setting('contact_meta_description', 'Get in touch with the Annapurna Region team for inquiries, support, and collaboration.'))

@section('content')

    {{-- Header Banner — title/image editable via Admin → Pages → "Contact" --}}
    @php
        $bannerBg   = (isset($page) && $page?->featured_image)
                        ? \App\Helpers\Cms::imageUrl($page->featured_image)
                        : asset('annapurna/img/slider/pokhara-valley-tour.jpg');
        $bannerTitle = isset($page) && $page?->title ? $page->title : 'Contact Us';
    @endphp
    <div class="banner-header section-padding back-position-center valign bg-img bg-fixed"
         data-overlay-dark="5"
         data-background="{{ $bannerBg }}">
        <div class="container">
            <div class="row">
                <div class="col-md-12 caption mt-90">
                    <h6>Get in touch</h6>
                    <h1>{!! $bannerTitle !!}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Contact</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Editable intro content block (managed via Admin → Pages → "Contact") --}}
    @if(isset($page) && $page?->content)
    <section class="section-padding pb-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center page-content">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="container mt-20">
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    </div>
    @endif
    @if(session('error'))
    <div class="container mt-20">
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    </div>
    @endif

    {{-- Contact Section --}}
    @php $contact = \App\Helpers\Cms::contactInfo(); @endphp
    <section class="contact section-padding">
        <div class="container">
            <div class="row mb-90">

                {{-- Contact Info --}}
                <div class="col-md-6 mb-60">
                    <h3>{{ \App\Helpers\Cms::siteName() }}</h3>
                    <p>{{ \App\Helpers\Cms::setting('contact_description', 'The Annapurna Region in central Nepal is one of the most famous destinations globally for its panoramic views, culture, and exciting adventure. We are here to help you plan your perfect journey.') }}</p>

                    @if($contact['phone'])
                    <div class="phone-call mb-30">
                        <div class="icon"><span class="flaticon-phone-call"></span></div>
                        <div class="text">
                            <p>Phone</p>
                            <a href="tel:{{ $contact['phone'] }}">{{ $contact['phone'] }}</a>
                        </div>
                    </div>
                    @endif

                    @if($contact['email'])
                    <div class="phone-call mb-30">
                        <div class="icon"><span class="flaticon-message"></span></div>
                        <div class="text">
                            <p>e-Mail Address</p>
                            <a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a>
                        </div>
                    </div>
                    @endif

                    @if($contact['address'])
                    <div class="phone-call">
                        <div class="icon"><span class="flaticon-placeholder"></span></div>
                        <div class="text">
                            <p>Location</p>
                            {{ $contact['address'] }}
                        </div>
                    </div>
                    @endif

                    {{-- Social Links --}}
                    @php $social = \App\Helpers\Cms::socialLinks(); @endphp
                    @if(array_filter($social))
                    <div class="social-icons mt-30">
                        <ul class="list-inline">
                            @if($social['instagram'])<li><a href="{{ $social['instagram'] }}" target="_blank" rel="noopener noreferrer"><i class="ti-instagram"></i></a></li>@endif
                            @if($social['twitter'])<li><a href="{{ $social['twitter'] }}" target="_blank" rel="noopener noreferrer"><i class="ti-twitter"></i></a></li>@endif
                            @if($social['facebook'])<li><a href="{{ $social['facebook'] }}" target="_blank" rel="noopener noreferrer"><i class="ti-facebook"></i></a></li>@endif
                            @if($social['youtube'])<li><a href="{{ $social['youtube'] }}" target="_blank" rel="noopener noreferrer"><i class="ti-youtube"></i></a></li>@endif
                        </ul>
                    </div>
                    @endif
                </div>

                {{-- Contact Form --}}
                <div class="col-md-5 mb-30 offset-md-1">
                    <div class="sidebar">
                        <div class="right-sidebar">
                            <div class="right-sidebar item">
                                <h2>Get in touch</h2>

                                @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <form method="POST" action="{{ route('contact.submit') }}" class="right-sidebar item-form contac__form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <input name="name" type="text" placeholder="Your Name *"
                                                   value="{{ old('name') }}" required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <input name="email" type="email" placeholder="Your Email *"
                                                   value="{{ old('email') }}" required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <input name="phone" type="text" placeholder="Your Phone Number"
                                                   value="{{ old('phone') }}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <input name="subject" type="text" placeholder="Subject *"
                                                   value="{{ old('subject') }}" required>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <textarea name="message" cols="30" rows="4" placeholder="Your Message...">{{ old('message') }}</textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" type="submit">
                                                <span>Send Message</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Map Section --}}
            @php $mapUrl = \App\Helpers\Cms::setting('contact_map_url'); @endphp
            <div class="row">
                <div class="col-md-12 animate-box" data-animate-effect="fadeInUp">
                    @if($mapUrl)
                    <iframe src="{{ $mapUrl }}" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @else
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d708680.3404182498!2d82.72004664687498!3d28.613611100000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39be1ec6808cffc1%3A0x48172cc9dd372cef!2sAnnapurna%20I!5e1!3m2!1sen!2snp!4v1742794719877!5m2!1sen!2snp" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @endif
                </div>
            </div>

        </div>
    </section>

    {{-- Testimonials Banner --}}
    <section class="testimonials">
        <div class="background bg-img bg-fixed section-padding pb-0"
             data-background="{{ asset('annapurna/img/slider/panaromic.jpg') }}"
             data-overlay-dark="5">
            <div class="container">
                <div class="row">
                    {{-- Call Now --}}
                    <div class="col-md-5 mb-30 mt-30">
                        <p><i class="star-rating"></i><i class="star-rating"></i><i class="star-rating"></i><i class="star-rating"></i><i class="star-rating"></i></p>
                        <h5>We Provide Top Destinations Especially For You. Book Now and Enjoy!</h5>
                        @if($contact['phone'])
                        <div class="phone-call mb-10">
                            <div class="icon color-1"><span class="flaticon-phone-call"></span></div>
                            <div class="text">
                                <p class="color-1">Call Now</p>
                                <a class="color-1" href="tel:{{ $contact['phone'] }}">{{ $contact['phone'] }}</a>
                            </div>
                        </div>
                        @endif
                        <p><i class="ti-check"></i><small>We are here to help you plan your Annapurna adventure.</small></p>
                    </div>
                    {{-- Testimonials --}}
                    <div class="col-md-5 offset-md-2">
                        <div class="testimonials-box">
                            <div class="head-box">
                                <h6>Testimonials</h6>
                                <h4>Travelers Reviews</h4>
                            </div>
                            <div class="owl-carousel owl-theme">
                                @forelse($testimonials ?? collect() as $testimonial)
                                <div class="item">
                                    <p>"{{ $testimonial->content }}"</p>
                                    <div class="info">
                                        <div class="author-img">
                                            @if($testimonial->image)
                                                <img src="{{ \App\Helpers\Cms::imageUrl($testimonial->image) }}" alt="{{ $testimonial->name }}">
                                            @else
                                                <img src="{{ asset('annapurna/img/team/04.png') }}" alt="{{ $testimonial->name }}">
                                            @endif
                                        </div>
                                        <div class="cont">
                                            <div class="rating">
                                                @for($i = 0; $i < 5; $i++)<i class="star {{ $i < ($testimonial->rating ?? 5) ? 'active' : '' }}"></i>@endfor
                                            </div>
                                            <h6>{{ $testimonial->name }}</h6>
                                            @if($testimonial->position ?? null)<span>{{ $testimonial->position }}</span>@endif
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="item">
                                    <p>"Wonderful experience exploring the Annapurna Region. Highly recommended for all adventure seekers!"</p>
                                    <div class="info">
                                        <div class="author-img"><img src="{{ asset('annapurna/img/team/04.png') }}" alt="Guest"></div>
                                        <div class="cont">
                                            <div class="rating"><i class="star active"></i><i class="star active"></i><i class="star active"></i><i class="star active"></i><i class="star active"></i></div>
                                            <h6>Happy Traveler</h6><span>Guest review</span>
                                        </div>
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
