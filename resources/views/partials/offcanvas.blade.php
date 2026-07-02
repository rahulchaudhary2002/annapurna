@php
    $siteName = \App\Helpers\Cms::siteName();
    $siteLogo = \App\Helpers\Cms::siteLogo();
    $contact  = \App\Helpers\Cms::contactInfo();
    $social   = \App\Helpers\Cms::socialLinks();
    $siteTagline = \App\Helpers\Cms::siteTagline();
@endphp

<div class="fix-area">
    <div class="offcanvas__info">
        <div class="offcanvas__wrapper">
            <div class="offcanvas__content">
                <div class="offcanvas__top mb-5 d-flex justify-content-between align-items-center">
                    <div class="offcanvas__logo">
                        <a href="{{ route('home') }}">
                            @if($siteLogo)
                                <img src="{{ $siteLogo }}" alt="{{ $siteName }}">
                            @else
                                <span class="fw-bold">{{ $siteName }}</span>
                            @endif
                        </a>
                    </div>
                    <div class="offcanvas__close">
                        <button><i class="fas fa-times"></i></button>
                    </div>
                </div>

                @if($siteTagline)
                    <p class="text d-none d-xl-block">{{ $siteTagline }}</p>
                @endif

                <div class="mobile-menu fix mb-3"></div>

                <div class="offcanvas__contact d-xl-block">
                    <h4 class="d-xl-block">Contact Info</h4>
                    <ul class="d-xl-block">
                        @if($contact['address'])
                            <li class="d-flex align-items-center">
                                <div class="offcanvas__contact-icon"><i class="fal fa-map-marker-alt"></i></div>
                                <div class="offcanvas__contact-text"><a href="#">{{ $contact['address'] }}</a></div>
                            </li>
                        @endif
                        @if($contact['email'])
                            <li class="d-flex align-items-center">
                                <div class="offcanvas__contact-icon mr-15"><i class="fal fa-envelope"></i></div>
                                <div class="offcanvas__contact-text"><a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a></div>
                            </li>
                        @endif
                        @if($contact['hours'])
                            <li class="d-flex align-items-center">
                                <div class="offcanvas__contact-icon mr-15"><i class="fal fa-clock"></i></div>
                                <div class="offcanvas__contact-text">{{ $contact['hours'] }}</div>
                            </li>
                        @endif
                        @if($contact['phone'])
                            <li class="d-flex align-items-center">
                                <div class="offcanvas__contact-icon mr-15"><i class="far fa-phone"></i></div>
                                <div class="offcanvas__contact-text"><a href="tel:{{ $contact['phone'] }}">{{ $contact['phone'] }}</a></div>
                            </li>
                        @endif
                    </ul>
                    <div class="social-icon d-flex align-items-center">
                        @if($social['facebook'])<a href="{{ $social['facebook'] }}" target="_blank"><i class="fab fa-facebook-f"></i></a>@endif
                        @if($social['twitter'])<a href="{{ $social['twitter'] }}" target="_blank"><i class="fab fa-twitter"></i></a>@endif
                        @if($social['youtube'])<a href="{{ $social['youtube'] }}" target="_blank"><i class="fab fa-youtube"></i></a>@endif
                        @if($social['linkedin'])<a href="{{ $social['linkedin'] }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>@endif
                        @if($social['instagram'])<a href="{{ $social['instagram'] }}" target="_blank"><i class="fab fa-instagram"></i></a>@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas__overlay"></div>
