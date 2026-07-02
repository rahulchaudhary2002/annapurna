@php
    $siteName  = \App\Helpers\Cms::siteName();
    $siteLogo  = \App\Helpers\Cms::siteLogo();
    $tagline   = \App\Helpers\Cms::setting('footer_tagline', 'Discover trekking, tours, and travel in the Annapurna region.');
    $contact   = \App\Helpers\Cms::contactInfo();
    $social    = \App\Helpers\Cms::socialLinks();
@endphp

<footer class="footer clearfix">
    <div class="container">

        {{-- First footer: contact bar --}}
        <div class="first-footer">
            <div class="row">
                <div class="col-md-12">
                    <div class="links dark footer-contact-links">
                        <div class="footer-contact-links-wrapper">

                            @if($contact['phone'])
                            <div class="footer-contact-link-wrapper">
                                <div class="image-wrapper footer-contact-link-icon">
                                    <div class="icon-footer"><i class="flaticon-phone-call"></i></div>
                                </div>
                                <div class="footer-contact-link-content">
                                    <h6>Call us</h6>
                                    <p><a href="tel:{{ $contact['phone'] }}">{{ $contact['phone'] }}</a></p>
                                </div>
                            </div>
                            <div class="footer-contact-links-divider"></div>
                            @endif

                            @if($contact['email'])
                            <div class="footer-contact-link-wrapper">
                                <div class="image-wrapper footer-contact-link-icon">
                                    <div class="icon-footer"><i class="flaticon-message"></i></div>
                                </div>
                                <div class="footer-contact-link-content">
                                    <h6>Write to us</h6>
                                    <p><a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a></p>
                                </div>
                            </div>
                            <div class="footer-contact-links-divider"></div>
                            @endif

                            @if($contact['address'])
                            <div class="footer-contact-link-wrapper">
                                <div class="image-wrapper footer-contact-link-icon">
                                    <div class="icon-footer"><i class="flaticon-placeholder"></i></div>
                                </div>
                                <div class="footer-contact-link-content">
                                    <h6>Address</h6>
                                    <p>{{ $contact['address'] }}</p>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Second footer: logo, links, newsletter --}}
        <div class="second-footer">
            <div class="row">

                {{-- About & social icons --}}
                <div class="col-md-4 widget-area">
                    <div class="widget clearfix">
                        <div class="footer-logo">
                            <a href="{{ route('home') }}">
                                @if($siteLogo)
                                    <img class="img-fluid" src="{{ $siteLogo }}" alt="{{ $siteName }}">
                                @else
                                    <h2 class="text-white">{{ $siteName }}</h2>
                                @endif
                            </a>
                        </div>
                        <div class="widget-text">
                            @if($tagline)
                                <p>{{ $tagline }}</p>
                            @endif
                            <div class="social-icons">
                                <ul class="list-inline">
                                    @if($social['instagram'])
                                        <li><a href="{{ $social['instagram'] }}" target="_blank" rel="noopener noreferrer"><i class="ti-instagram"></i></a></li>
                                    @endif
                                    @if($social['twitter'])
                                        <li><a href="{{ $social['twitter'] }}" target="_blank" rel="noopener noreferrer"><i class="ti-twitter"></i></a></li>
                                    @endif
                                    @if($social['facebook'])
                                        <li><a href="{{ $social['facebook'] }}" target="_blank" rel="noopener noreferrer"><i class="ti-facebook"></i></a></li>
                                    @endif
                                    @if($social['youtube'])
                                        <li><a href="{{ $social['youtube'] }}" target="_blank" rel="noopener noreferrer"><i class="ti-youtube"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick links --}}
                <div class="col-md-3 offset-md-1 widget-area">
                    <div class="widget clearfix usful-links">
                        <h3 class="widget-title">Quick Links</h3>
                        <ul>
                            <li><a href="{{ route('trek-routes.index') }}">Trek Routes</a></li>
                            <li><a href="{{ route('travel-agencies.index') }}">Travel Agencies</a></li>
                            <li><a href="{{ route('destinations.index') }}">Destinations</a></li>
                            <li><a href="{{ route('hotels.index') }}">Hotels</a></li>
                            <li><a href="{{ route('restaurants.index') }}">Restaurants</a></li>
                            <li><a href="{{ route('blog.index') }}">Blog</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>

                {{-- Subscribe --}}
                <div class="col-md-4 widget-area">
                    <div class="widget clearfix">
                        <h3 class="widget-title">Subscribe</h3>
                        <p>Sign up for our monthly newsletter to stay informed about Annapurna travel and tours.</p>
                        <div class="widget-newsletter">
                            <form action="{{ route('contact') }}" method="GET">
                                <input type="email" name="email" placeholder="Email Address" required>
                                <button type="submit">Send</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Bottom footer --}}
        <div class="bottom-footer-text">
            <div class="row copyright">
                <div class="col-md-12">
                    <p class="mb-0">&copy;{{ date('Y') }} <a href="{{ route('home') }}">{{ $siteName }}</a>. All rights reserved.</p>
                </div>
            </div>
        </div>

    </div>
</footer>
