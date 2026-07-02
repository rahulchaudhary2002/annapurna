@extends('layouts.app')

@section('meta_title', 'About – ' . \App\Helpers\Cms::siteName())
@section('meta_description', \App\Helpers\Cms::setting('about_meta_description', 'Discover trekking, tours, and travel experiences in the Annapurna region.'))

@section('content')

    {{-- Page Banner --}}
    <div class="banner-header section-padding valign bg-img bg-fixed" data-background="{{ asset('annapurna/img/slider/panaromic.jpg') }}" data-overlay-dark="5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center caption mt-90">
                    <h5>Annapurna Region</h5>
                    <h1>About <span>Us</span></h1>
                </div>
            </div>
        </div>
    </div>

    {{-- About --}}
    <section class="about cover section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-30 animate-box" data-animate-effect="fadeInUp">
                    <div class="section-subtitle">{{ \App\Helpers\Cms::setting('home_about_subtitle', 'Annapurna Region – A Lifetime Experience') }}</div>
                    <div class="section-title">{{ \App\Helpers\Cms::setting('home_about_title', 'Discover') }} <span>{{ \App\Helpers\Cms::setting('home_about_span', 'Annapurna') }}</span></div>
                    {!! \App\Helpers\Cms::setting('home_about_body', '<p style="text-align:justify">The <b>Annapurna Region</b> in central Nepal is one of the world\'s most renowned destinations for trekking, known for its panoramic mountain views, living cultures, and diverse adventure experiences.</p><p style="text-align:justify">Anchored by <b>Pokhara</b>, the main gateway to Annapurna—travelers are welcomed by the calm waters of Phewa Lake, where clear mornings often reflect the Annapurna range and Machapuchare (Fishtail), creating one of Nepal\'s most iconic Himalayan landscapes.</p><p style="text-align:justify">The region is home to Tilicho Lake, among the highest lakes in the world. Classic routes such as the <b>Annapurna Circuit Trek</b> and <b>Annapurna Base Camp (ABC) Trek</b> are internationally recognized for their variety of terrain, passing through subtropical forests, terraced farmlands, alpine meadows, and high mountain deserts.</p><p style="text-align:justify">Beyond trekking, the Annapurna Region offers rich cultural and natural diversity. From traditional village walks in Ghandruk and Manang to adventure activities like paragliding in Pokhara and sunrise viewpoints at Sarangkot, the region balances both adventure and tranquility.</p>') !!}
                </div>
                <div class="col-md-5 offset-md-1 animate-box" data-animate-effect="fadeInUp">
                    <div class="img-exp">
                        <div class="about-img">
                            <div class="img">
                                @php $aboutImg = \App\Helpers\Cms::setting('home_about_image'); @endphp
                                <img src="{{ $aboutImg ? \App\Helpers\Cms::imageUrl($aboutImg) : asset('annapurna/img/about1.jpg') }}" class="img-fluid" alt="About Annapurna Region">
                            </div>
                        </div>
                        <div id="circle">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="300px" height="300px" viewBox="0 0 300 300" enable-background="new 0 0 300 300" xml:space="preserve">
                                <defs><path id="circlePath" d=" M 150, 150 m -60, 0 a 60,60 0 0,1 120,0 a 60,60 0 0,1 -120,0 " /></defs>
                                <circle cx="150" cy="100" r="75" fill="none" />
                                <g>
                                    <use xlink:href="#circlePath" fill="none" />
                                    <text fill="#0f2454"><textPath xlink:href="#circlePath">. Annapurna Region . Annapurna Circuit</textPath></text>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Popular Destinations --}}
    <section class="tours1 section-padding bg-lightnav">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-subtitle"><span>Choose your place</span></div>
                    <div class="section-title">Popular <span>Destinations</span></div>
                </div>
            </div>
            <div class="row">
                @forelse($popularTreks as $trek)
                <div class="{{ $loop->first ? 'col-md-8' : 'col-md-4' }}">
                    <div class="item">
                        <div class="position-re o-hidden">
                            @php
                                $img = $trek->featured_image
                                    ? (str_starts_with($trek->featured_image, 'annapurna/')
                                        ? asset($trek->featured_image)
                                        : \App\Helpers\Cms::imageUrl($trek->featured_image))
                                    : asset('annapurna/img/tours/annapurna-circuit.jpg');
                            @endphp
                            <img src="{{ $img }}" alt="{{ $trek->name }}">
                        </div>
                        @if($trek->price_range)<span class="category"><a href="{{ route('trek-routes.show', $trek->slug) }}">{{ $trek->price_range }}</a></span>@endif
                        <div class="con">
                            @if($loop->first)
                            <div class="rating"><i class="star active"></i><i class="star active"></i><i class="star active"></i><i class="star active"></i><i class="star"></i><div class="reviews-count">(0 Reviews)</div></div>
                            @endif
                            <h5><a href="{{ route('trek-routes.show', $trek->slug) }}">{{ $trek->name }}</a></h5>
                            <div class="line"></div>
                            <div class="row facilities"><div class="col col-md-12"><ul>
                                @if($trek->duration_days)<li><i class="ti-time"></i> {{ $trek->duration_days }} Days</li>@endif
                                @if($trek->group_size_min)<li><i class="ti-user"></i> {{ $trek->group_size_min }}+</li>@endif
                                @if($trek->max_altitude)<li><i class="ti-location-pin"></i> {{ $trek->max_altitude }}</li>@endif
                            </ul></div></div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-md-8"><div class="item"><div class="position-re o-hidden"><img src="{{ asset('annapurna/img/tours/annapurna-circuit.jpg') }}" alt="Annapurna Base Camp"></div><span class="category"><a href="{{ route('trek-routes.index') }}">$2,500 - $5,000</a></span><div class="con"><div class="rating"><i class="star active"></i><i class="star active"></i><i class="star active"></i><i class="star active"></i><i class="star"></i><div class="reviews-count">(0 Reviews)</div></div><h5><a href="{{ route('trek-routes.index') }}">Annapurna Base Camp</a></h5><div class="line"></div><div class="row facilities"><div class="col col-md-12"><ul><li><i class="ti-time"></i> 10-20 Days</li><li><i class="ti-user"></i> 12+</li><li><i class="ti-location-pin"></i> Gandaki Province, Nepal</li></ul></div></div></div></div></div>
                <div class="col-md-4"><div class="item"><div class="position-re o-hidden"><img src="{{ asset('annapurna/img/tours/pokhara.jpg') }}" alt="Pokhara"></div><span class="category"><a href="{{ route('trek-routes.index') }}">$1,300 - $4,000</a></span><div class="con"><h5><a href="{{ route('trek-routes.index') }}">Pokhara</a></h5><div class="line"></div><div class="row facilities"><div class="col col-md-12"><ul><li><i class="ti-time"></i> 3-6 Days</li><li><i class="ti-user"></i> 10+</li><li><i class="ti-location-pin"></i> Kaski District</li></ul></div></div></div></div></div>
                <div class="col-md-4"><div class="item"><div class="position-re o-hidden"><img src="{{ asset('annapurna/img/tours/annapurna-base-camp.jpg') }}" alt="Annapurna Circuit"></div><span class="category"><a href="{{ route('trek-routes.index') }}">$400 - $2,000</a></span><div class="con"><h5><a href="{{ route('trek-routes.index') }}">Annapurna Circuit</a></h5><div class="line"></div><div class="row facilities"><div class="col col-md-12"><ul><li><i class="ti-time"></i> 7-10 Days</li><li><i class="ti-user"></i> 6+</li><li><i class="ti-location-pin"></i> Gandaki Province</li></ul></div></div></div></div></div>
                <div class="col-md-4"><div class="item"><div class="position-re o-hidden"><img src="{{ asset('annapurna/img/tours/aca.jpg') }}" alt="ACA"></div><span class="category"><a href="{{ route('trek-routes.index') }}">$500 - $2,000</a></span><div class="con"><h5><a href="{{ route('trek-routes.index') }}">Annapurna Conservation Area</a></h5><div class="line"></div><div class="row facilities"><div class="col col-md-12"><ul><li><i class="ti-time"></i> 7-20 Days</li><li><i class="ti-user"></i> 12+</li><li><i class="ti-location-pin"></i> Gandaki Province</li></ul></div></div></div></div></div>
                <div class="col-md-4"><div class="item"><div class="position-re o-hidden"><img src="{{ asset('annapurna/img/tours/poon-hill.jpg') }}" alt="Poon Hill"></div><span class="category"><a href="{{ route('trek-routes.index') }}">$300 - $1,000</a></span><div class="con"><h5><a href="{{ route('trek-routes.index') }}">Poon Hill</a></h5><div class="line"></div><div class="row facilities"><div class="col col-md-12"><ul><li><i class="ti-time"></i> 7-14 Days</li><li><i class="ti-user"></i> 10+</li><li><i class="ti-location-pin"></i> Nepal</li></ul></div></div></div></div></div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Numbers --}}
    <section class="numbers">
        <div class="section-padding bg-img bg-fixed back-position-center" data-background="{{ asset('annapurna/img/slider/panaromic.jpg') }}" data-overlay-dark="6">
            <div class="container">
                <div class="row">
                    @forelse($counters as $counter)
                    <div class="col-md-3 col-sm-6">
                        <div class="item text-center">
                            <span class="icon"><i class="front {{ $counter->icon ?? 'flaticon-placeholder' }}"></i><i class="back {{ $counter->icon ?? 'flaticon-placeholder' }}"></i></span>
                            <h3 class="count">{{ $counter->label }}</h3>
                            <h6>{{ $counter->value }}</h6>
                        </div>
                    </div>
                    @empty
                    <div class="col-md-3 col-sm-6"><div class="item text-center"><span class="icon"><i class="front flaticon-placeholder"></i><i class="back flaticon-placeholder"></i></span><h3>Tilicho Lake</h3><h6>Highest Altitude Lake (4,919 M)</h6></div></div>
                    <div class="col-md-3 col-sm-6"><div class="item text-center"><span class="icon"><i class="front flaticon-placeholder"></i><i class="back flaticon-placeholder"></i></span><h3>Thorong La Pass</h3><h6>World's Highest Trekking Pass</h6></div></div>
                    <div class="col-md-3 col-sm-6"><div class="item text-center"><span class="icon"><i class="front flaticon-placeholder"></i><i class="back flaticon-placeholder"></i></span><h3>ACA</h3><h6>Largest Protected Area (7,629 Sq.KM)</h6></div></div>
                    <div class="col-md-3 col-sm-6"><div class="item text-center"><span class="icon"><i class="front flaticon-placeholder"></i><i class="back flaticon-placeholder"></i></span><h3>Annapurna I</h3><h6>10th Highest Mountain (8,091 M)</h6></div></div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- Activities - Trekking & Mountaineering --}}
    <section class="tours1 section-padding">
        <div class="container">
            <div class="row mb-30">
                <div class="col-md-12">
                    <div class="section-subtitle">Most Popular Activities</div>
                    <div class="section-title"><span>Annapurna</span> Region</div>
                </div>
            </div>
            <div class="row mb-90">
                <div class="col-md-5">
                    <div class="country country1 mt-30">
                        <div class="section-title2">Trekking in Nepal</div>
                        <p><b>The Annapurna Region is a heaven for trekkers.</b> It has some of Nepal's most iconic trails — from the magnificent peaks of Annapurna and Machapuchare to lush forests, alpine meadows, and high mountain deserts.</p>
                        <div class="row tour-list">
                            <div class="col-md-6"><ul>
                                <li><i class="ti-location-pin"></i> <a href="{{ route('trek-routes.index') }}" class="link-btn">Annapurna Circuit Trek</a></li>
                                <li><i class="ti-location-pin"></i> <a href="{{ route('trek-routes.index') }}" class="link-btn">Annapurna Base Camp</a></li>
                                <li><i class="ti-location-pin"></i> <a href="{{ route('trek-routes.index') }}" class="link-btn">Tilicho Lake Trek</a></li>
                            </ul></div>
                            <div class="col-md-6"><ul>
                                <li><i class="ti-location-pin"></i> <a href="{{ route('trek-routes.index') }}" class="link-btn">Ghorepani Poon Hill</a></li>
                                <li><i class="ti-location-pin"></i> <a href="{{ route('trek-routes.index') }}" class="link-btn">Mardi Himal Trek</a></li>
                                <li><i class="ti-location-pin"></i> <a href="{{ route('trek-routes.index') }}" class="link-btn">Jomsom – Muktinath</a></li>
                            </ul></div>
                        </div>
                        <div class="butn-dark mt-30 mb-30"><a href="{{ route('trek-routes.index') }}"><span>All Treks <i class="ti-arrow-right"></i></span></a></div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="owl-carousel owl-theme">
                        <div class="item"><div class="position-re o-hidden"><img src="{{ asset('annapurna/img/destination/annapurna-circuit1.jpg') }}" alt="Annapurna Circuit"></div><span class="category"><a href="{{ route('trek-routes.index') }}">$1,500–$3,000</a></span><div class="con"><h5><a href="{{ route('trek-routes.index') }}">Annapurna Circuit</a></h5><div class="line"></div><div class="row facilities"><div class="col col-md-12"><ul><li><i class="ti-time"></i> 7-15 Days</li><li><i class="ti-user"></i> 10+</li><li><i class="ti-location-pin"></i> Nepal</li></ul></div></div></div></div>
                        <div class="item"><div class="position-re o-hidden"><img src="{{ asset('annapurna/img/destination/ghorepani-hill-trek.jpg') }}" alt="Ghorepani Hill Trek"></div><span class="category"><a href="{{ route('trek-routes.index') }}">$300–$1,300</a></span><div class="con"><h5><a href="{{ route('trek-routes.index') }}">Ghorepani Hill Trek</a></h5><div class="line"></div><div class="row facilities"><div class="col col-md-12"><ul><li><i class="ti-time"></i> 4-15 Days</li><li><i class="ti-user"></i> 8+</li><li><i class="ti-location-pin"></i> Nepal</li></ul></div></div></div></div>
                        <div class="item"><div class="position-re o-hidden"><img src="{{ asset('annapurna/img/destination/mardi-himal-trek.jpg') }}" alt="Mardi Himal Trek"></div><span class="category"><a href="{{ route('trek-routes.index') }}">$800–$1,500</a></span><div class="con"><h5><a href="{{ route('trek-routes.index') }}">Mardi Himal Trek</a></h5><div class="line"></div><div class="row facilities"><div class="col col-md-12"><ul><li><i class="ti-time"></i> 6-9 Days</li><li><i class="ti-user"></i> 6+</li><li><i class="ti-location-pin"></i> Nepal</li></ul></div></div></div></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7">
                    <div class="owl-carousel owl-theme">
                        <div class="item"><div class="position-re o-hidden"><img src="{{ asset('annapurna/img/destination/machhapuchree-expedition.jpg') }}" alt="Machapuchare Trek"></div><span class="category"><a href="{{ route('destinations.index') }}">$1,250–$2,500</a></span><div class="con"><h5><a href="{{ route('destinations.index') }}">Machapuchare Trek</a></h5><div class="line"></div><div class="row facilities"><div class="col col-md-12"><ul><li><i class="ti-time"></i> 7-14 Days</li><li><i class="ti-user"></i> 12+</li><li><i class="ti-location-pin"></i> Nepal</li></ul></div></div></div></div>
                        <div class="item"><div class="position-re o-hidden"><img src="{{ asset('annapurna/img/destination/pisang-peak.jpg') }}" alt="Pisang Peak Trek"></div><span class="category"><a href="{{ route('destinations.index') }}">$1,500–$2,500</a></span><div class="con"><h5><a href="{{ route('destinations.index') }}">Pisang Peak Trek</a></h5><div class="line"></div><div class="row facilities"><div class="col col-md-12"><ul><li><i class="ti-time"></i> 4-7 Days</li><li><i class="ti-user"></i> 6+</li><li><i class="ti-location-pin"></i> Nepal</li></ul></div></div></div></div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="country country1 mt-30">
                        <div class="section-title2">Mountaineering &amp; Expedition</div>
                        <p><b>Annapurna I (8,091 m)</b> was the first 8,000-meter peak ever climbed. The region offers challenging and rewarding peaks for all levels of mountaineers.</p>
                        <div class="row tour-list">
                            <div class="col-md-6"><ul>
                                <li><i class="ti-location-pin"></i> <a href="{{ route('destinations.index') }}" class="link-btn">Annapurna I</a></li>
                                <li><i class="ti-location-pin"></i> <a href="{{ route('destinations.index') }}" class="link-btn">Machapuchare (6,993m)</a></li>
                                <li><i class="ti-location-pin"></i> <a href="{{ route('destinations.index') }}" class="link-btn">Tent Peak (5,695m)</a></li>
                            </ul></div>
                            <div class="col-md-6"><ul>
                                <li><i class="ti-location-pin"></i> <a href="{{ route('destinations.index') }}" class="link-btn">Singu Chuli (6,501m)</a></li>
                                <li><i class="ti-location-pin"></i> <a href="{{ route('destinations.index') }}" class="link-btn">Pisang Peak (6,091m)</a></li>
                                <li><i class="ti-location-pin"></i> <a href="{{ route('destinations.index') }}" class="link-btn">Annapurna South</a></li>
                            </ul></div>
                        </div>
                        <div class="butn-dark mt-30 mb-30"><a href="{{ route('destinations.index') }}"><span>All Mountaineering <i class="ti-arrow-right"></i></span></a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    @php $heroPhone = \App\Helpers\Cms::contactInfo()['phone']; @endphp
    <section class="testimonials">
        <div class="background bg-img bg-fixed section-padding pb-0" data-background="{{ asset('annapurna/img/slider/panaromic.jpg') }}" data-overlay-dark="5">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 mb-30 mt-30">
                        <p><i class="star-rating"></i><i class="star-rating"></i><i class="star-rating"></i><i class="star-rating"></i><i class="star-rating"></i></p>
                        <h5>Reflections on the Majesty of Annapurna from Legends and Explorers</h5>
                        @if($heroPhone)
                        <div class="phone-call mb-10">
                            <div class="icon color-1"><span class="flaticon-phone-call"></span></div>
                            <div class="text"><p class="color-1">Call Now</p><a class="color-1" href="tel:{{ $heroPhone }}">{{ $heroPhone }}</a></div>
                        </div>
                        @endif
                        <p><i class="ti-check"></i><small>Contact us to list your business, packages &amp; itineraries.</small></p>
                        <div class="butn-light mt-20 mb-10"><a href="{{ route('contact') }}"><span>Get In Touch <i class="ti-arrow-right"></i></span></a></div>
                    </div>
                    <div class="col-md-5 offset-md-2">
                        <div class="testimonials-box">
                            <div class="head-box"><h6>Testimonials</h6><h4>Travelers Reviews</h4></div>
                            <div class="owl-carousel owl-theme">
                                @forelse($testimonials as $t)
                                <div class="item">
                                    <p>"{{ $t->content }}"</p>
                                    <div class="info">
                                        <div class="author-img"><img src="{{ $t->image ? \App\Helpers\Cms::imageUrl($t->image) : asset('annapurna/img/team/08.png') }}" alt="{{ $t->name }}"></div>
                                        <div class="cont">
                                            <div class="rating">@for($i=0;$i<5;$i++)<i class="star {{ $i<($t->rating??5)?'active':'' }}"></i>@endfor</div>
                                            <h6>{{ $t->name }}</h6>
                                            @if($t->position ?? null)<span>{{ $t->position }}</span>@endif
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="item"><p>"It's not about conquering mountains, but about the journey and the experiences along the way."</p><div class="info"><div class="author-img"><img src="{{ asset('annapurna/img/team/08.png') }}" alt="Jimmy Chin"></div><div class="cont"><div class="rating"><i class="star active"></i><i class="star active"></i><i class="star active"></i><i class="star active"></i><i class="star active"></i></div><h6>Jimmy Chin</h6><span>Renowned climber &amp; filmmaker</span></div></div></div>
                                <div class="item"><p>"Annapurna, to which we had gone empty-handed, was a treasure on which we should live the rest of our days."</p><div class="info"><div class="author-img"><img src="{{ asset('annapurna/img/team/07.png') }}" alt="Maurice Herzog"></div><div class="cont"><div class="rating"><i class="star active"></i><i class="star active"></i><i class="star active"></i><i class="star active"></i><i class="star active"></i></div><h6>Maurice Herzog</h6><span>First Conquest of an 8,000-Meter Peak</span></div></div></div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Partners --}}
    <section class="clients">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="owl-carousel owl-theme">
                        @forelse($partners as $partner)
                        <div class="clients-logo">
                            @if($partner->url ?? null)<a href="{{ $partner->url }}" target="_blank" rel="noopener noreferrer"><img src="{{ \App\Helpers\Cms::imageUrl($partner->logo) }}" alt="{{ $partner->name }}"></a>
                            @else<img src="{{ \App\Helpers\Cms::imageUrl($partner->logo) }}" alt="{{ $partner->name }}">@endif
                        </div>
                        @empty
                        <div class="clients-logo"><a href="#"><img src="{{ asset('annapurna/img/clients/1.png') }}" alt="Partner"></a></div>
                        <div class="clients-logo"><a href="#"><img src="{{ asset('annapurna/img/clients/2.png') }}" alt="Partner"></a></div>
                        <div class="clients-logo"><a href="#"><img src="{{ asset('annapurna/img/clients/3.png') }}" alt="Partner"></a></div>
                        <div class="clients-logo"><a href="#"><img src="{{ asset('annapurna/img/clients/4.png') }}" alt="Partner"></a></div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
