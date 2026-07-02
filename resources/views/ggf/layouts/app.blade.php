<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', \App\Helpers\Cms::setting('ggf_site_name', 'Guru Goraksanatha Foundation'))</title>
    <meta name="description" content="@yield('meta_description', \App\Helpers\Cms::setting('ggf_meta_description', ''))">
    <script src="{{ asset('ggf/themekit/scripts/jquery.min.js') }}"></script>
    <script src="{{ asset('ggf/themekit/scripts/main.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('ggf/themekit/css/bootstrap-grid.css') }}">
    <link rel="stylesheet" href="{{ asset('ggf/themekit/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('ggf/themekit/css/glide.css') }}">
    <link rel="stylesheet" href="{{ asset('ggf/themekit/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('ggf/themekit/css/content-box.css') }}">
    <link rel="stylesheet" href="{{ asset('ggf/themekit/css/contact-form.css') }}">
    <link rel="stylesheet" href="{{ asset('ggf/themekit/css/media-box.css') }}">
    <link rel="stylesheet" href="{{ asset('ggf/skin.css') }}">
    <link rel="icon" href="{{ \App\Helpers\Cms::setting('ggf_favicon') ? asset('storage/' . \App\Helpers\Cms::setting('ggf_favicon')) : asset('ggf/media/guru-fav-logo.png') }}">
    @stack('head')
</head>
<body>
    <div id="preloader"></div>

    {{-- Navigation --}}
    <nav class="menu-top-logo menu-fixed menu-background" data-menu-anima="fade-in">
        <div class="container">
            <div class="menu-brand">
                <a href="{{ route('ggf.home') }}">
                    @php $logo = \App\Helpers\Cms::setting('ggf_site_logo'); @endphp
                    @if($logo)
                        <img class="logo-default scroll-hide" src="{{ asset('storage/' . $logo) }}" alt="logo" />
                        <img class="logo-retina scroll-hide" src="{{ asset('storage/' . $logo) }}" alt="logo" />
                        <img class="logo-default scroll-show" src="{{ asset('storage/' . $logo) }}" alt="logo" />
                        <img class="logo-retina scroll-show" src="{{ asset('storage/' . $logo) }}" alt="logo" />
                    @else
                        <img class="logo-default scroll-hide" src="{{ asset('ggf/media/logos/guru-logo1.png') }}" alt="logo" />
                        <img class="logo-retina scroll-hide" src="{{ asset('ggf/media/logos/guru-logo1.png') }}" alt="logo" />
                        <img class="logo-default scroll-show" src="{{ asset('ggf/media/logos/guru-logo1.png') }}" alt="logo" />
                        <img class="logo-retina scroll-show" src="{{ asset('ggf/media/logos/guru-logo1.png') }}" alt="logo" />
                    @endif
                </a>
            </div>
            <i class="menu-btn"></i>
            <div class="menu-cnt">
                <ul id="main-menu">
                    <li class="{{ request()->routeIs('ggf.home') ? 'active' : '' }}">
                        <a href="{{ route('ggf.home') }}">Home</a>
                    </li>
                    <li class="dropdown {{ request()->routeIs('ggf.about*') || request()->routeIs('ggf.team') || request()->routeIs('ggf.history') ? 'active' : '' }}">
                        <a href="#">About Foundation</a>
                        <ul>
                            <li><a href="{{ route('ggf.about') }}">About</a></li>
                            <li><a href="{{ route('ggf.team') }}">Team</a></li>
                            <li><a href="{{ route('ggf.history') }}">History</a></li>
                        </ul>
                    </li>
                    <li class="{{ request()->routeIs('ggf.services*') ? 'active' : '' }}">
                        <a href="{{ route('ggf.services') }}">Services</a>
                    </li>
                    <li class="{{ request()->routeIs('ggf.programs') ? 'active' : '' }}">
                        <a href="{{ route('ggf.programs') }}">Upcoming Programs</a>
                    </li>
                    <li class="{{ request()->routeIs('ggf.donation') ? 'active' : '' }}">
                        <a href="{{ route('ggf.donation') }}">Donation</a>
                    </li>
                    <li class="{{ request()->routeIs('ggf.contact') ? 'active' : '' }}">
                        <a href="{{ route('ggf.contact') }}">Contact Us</a>
                    </li>
                    <li class="nav-label">
                        <a href="tel:{{ \App\Helpers\Cms::setting('ggf_contact_phone', '+977-9851362653') }}">
                            <span>Call us:</span> {{ \App\Helpers\Cms::setting('ggf_contact_phone', '+977-9851362653') }}
                        </a>
                    </li>
                </ul>
                <div class="menu-right">
                    <div class="custom-area">
                        {{ \App\Helpers\Cms::setting('ggf_address_line1', '(HO) Gorkha, Nepal') }}<br />
                        {{ \App\Helpers\Cms::setting('ggf_address_line2', 'Kathmandu, Nepal') }}
                    </div>
                    <form role="search" method="get" id="searchform" class="search-btn">
                        <div class="search-box-menu">
                            <input type="text" placeholder="Search ...">
                            <i></i>
                        </div>
                    </form>
                    <ul class="lan-menu">
                        <li class="dropdown">
                            <a href="#"><img src="{{ asset('ggf/media/en.png') }}" alt="lang" />EN</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    @yield('header')

    <main>
        @yield('content')
    </main>

    <i class="scroll-top-btn scroll-top show"></i>

    {{-- Footer --}}
    <footer class="light">
        <div class="container">
            <div class="row">
                {{-- Col 1: About --}}
                <div class="col-lg-4">
                    <h3>{{ \App\Helpers\Cms::setting('ggf_site_name', 'Guru Goraksanatha Foundation') }}</h3>
                    <p>{{ \App\Helpers\Cms::setting('ggf_footer_tagline', 'Guru Goraksanatha Foundation is a non-profit spiritual and cultural organization') }}</p>
                    <div class="icon-links icon-social icon-links-grid social-colors">
                        <a class="facebook" href="{{ \App\Helpers\Cms::setting('ggf_social_facebook', '#') ?: '#' }}"><i class="icon-facebook"></i></a>
                        <a class="Youtube" href="{{ \App\Helpers\Cms::setting('ggf_social_youtube', '#') ?: '#' }}"><i class="icon-youtube"></i></a>
                        <a class="instagram" href="{{ \App\Helpers\Cms::setting('ggf_social_instagram', '#') ?: '#' }}"><i class="icon-instagram"></i></a>
                        <a class="linkedin" href="{{ \App\Helpers\Cms::setting('ggf_social_linkedin', '#') ?: '#' }}"><i class="icon-linkedin"></i></a>
                    </div>
                </div>

                {{-- Col 2: Quick Links --}}
                <div class="col-lg-3">
                    <h3>{{ \App\Helpers\Cms::setting('ggf_footer_links_title', 'Quick Links') }}</h3>
                    <ul class="icon-list icon-line">
                        <li><a href="{{ route('ggf.about') }}">{{ \App\Helpers\Cms::setting('ggf_footer_link1_label', 'About the Foundation') }}</a></li>
                        <li><a href="{{ route('ggf.programs') }}">{{ \App\Helpers\Cms::setting('ggf_footer_link2_label', 'Programs & Initiatives') }}</a></li>
                        <li><a href="{{ route('ggf.donation') }}">{{ \App\Helpers\Cms::setting('ggf_footer_link3_label', 'Volunteer & Support') }}</a></li>
                        <li><a href="{{ route('ggf.contact') }}">{{ \App\Helpers\Cms::setting('ggf_footer_link4_label', 'Contact Us') }}</a></li>
                    </ul>
                </div>

                {{-- Col 3: Contact Info --}}
                <div class="col-lg-5">
                    <ul class="text-list text-list-line">
                        <li><b>{{ \App\Helpers\Cms::setting('ggf_footer_address_label', 'Address') }}</b><hr /><p>{{ \App\Helpers\Cms::setting('ggf_contact_address', 'Kathmandu | Gorkha, Nepal') }}</p></li>
                        <li><b>{{ \App\Helpers\Cms::setting('ggf_footer_email_label', 'Email') }}</b><hr /><p>{{ \App\Helpers\Cms::setting('ggf_contact_email', 'gurugoraksanathafoundation@gmail.com') }}</p></li>
                        <li><b>{{ \App\Helpers\Cms::setting('ggf_footer_phone_label', 'Phone') }}</b><hr /><p>{{ \App\Helpers\Cms::setting('ggf_contact_phone', '+977-9851362653') }}</p></li>
                        <li><b>{{ \App\Helpers\Cms::setting('ggf_footer_youtube_label', 'YouTube') }}</b><hr /><p><a href="{{ \App\Helpers\Cms::setting('ggf_social_youtube', '#') ?: '#' }}">{{ \App\Helpers\Cms::setting('ggf_site_name', 'Guru Goraksanatha Foundation') }}</a></p></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bar">
            <div class="container">
                <span>&copy; {{ date('Y') }} {{ \App\Helpers\Cms::setting('ggf_site_name', 'Guru Goraksanatha Foundation') }}. All rights reserved. | Powered by <a href="{{ \App\Helpers\Cms::setting('ggf_footer_powered_url', 'https://www.globalstudio.com.np') }}"><span style="color:#fff;">{{ \App\Helpers\Cms::setting('ggf_footer_powered_text', 'Global Studio') }}</span></a></span>
                <span>
                    <a href="{{ route('ggf.contact') }}"><span style="color:#fff;">Contact</span></a>
                    | <a href="{{ \App\Helpers\Cms::setting('ggf_footer_privacy_url', '#') }}"><span style="color:#fff;">{{ \App\Helpers\Cms::setting('ggf_footer_privacy_label', 'Privacy Policy') }}</span></a>
                </span>
            </div>
        </div>
        <link rel="stylesheet" href="{{ asset('ggf/themekit/media/icons/iconsmind/line-icons.min.css') }}">
        <script src="{{ asset('ggf/themekit/scripts/parallax.min.js') }}"></script>
        <script src="{{ asset('ggf/themekit/scripts/glide.min.js') }}"></script>
        <script src="{{ asset('ggf/themekit/scripts/magnific-popup.min.js') }}"></script>
        <script src="{{ asset('ggf/themekit/scripts/tab-accordion.js') }}"></script>
        <script src="{{ asset('ggf/themekit/scripts/imagesloaded.min.js') }}"></script>
        <script src="{{ asset('ggf/themekit/scripts/isotope.min.js') }}" defer></script>
        <script src="{{ asset('ggf/themekit/scripts/progress.js') }}" defer></script>
        @stack('scripts')
    </footer>
</body>
</html>
