<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta --}}
    <title>@yield('meta_title', \App\Helpers\Cms::defaultMetaTitle())</title>
    <meta name="description" content="@yield('meta_description', \App\Helpers\Cms::defaultMetaDescription())">
    @if(isset($page) && !empty($page->meta_keywords))
        <meta name="keywords" content="{{ $page->meta_keywords }}">
    @endif
    @if(isset($page) && !empty($page->no_index))
        <meta name="robots" content="noindex, nofollow">
    @endif

    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="@yield('og_title', \App\Helpers\Cms::defaultMetaTitle())" />
    <meta property="og:description" content="@yield('og_description', \App\Helpers\Cms::defaultMetaDescription())" />
    <meta property="og:type" content="@yield('og_type', 'website')" />
    <meta property="og:url" content="{{ url()->current() }}" />
    @if(isset($page) && !empty($page->og_image))
        <meta property="og:image" content="{{ \App\Helpers\Cms::imageUrl($page->og_image) }}" />
    @else
        <meta property="og:image" content="{{ asset('annapurna/img/slider/annapurna-region.png') }}" />
    @endif
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />

    {{-- Twitter Cards --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="@yield('og_title', \App\Helpers\Cms::defaultMetaTitle())" />
    <meta name="twitter:description" content="@yield('og_description', \App\Helpers\Cms::defaultMetaDescription())" />
    @if(isset($page) && !empty($page->og_image))
        <meta name="twitter:image" content="{{ \App\Helpers\Cms::imageUrl($page->og_image) }}" />
    @else
        <meta name="twitter:image" content="{{ asset('annapurna/img/slider/annapurna-region.png') }}" />
    @endif

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ \App\Helpers\Cms::siteFavicon() }}" />

    {{-- Google Fonts --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;500&family=Poppins:wght@300;400;500;600;700&display=swap">

    {{-- Annapurna Theme CSS --}}
    <link rel="stylesheet" href="{{ asset('annapurna/css/plugins.css') }}" />
    <link rel="stylesheet" href="{{ asset('annapurna/css/style.css') }}" />

    {{-- Page-specific styles --}}
    @stack('styles')

    {{-- Google Analytics --}}
    @if(\App\Helpers\Cms::setting('google_analytics'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ \App\Helpers\Cms::setting('google_analytics') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ \App\Helpers\Cms::setting('google_analytics') }}');
    </script>
    @endif
</head>
<body>

    {{-- Preloader --}}
    <div class="preloader-bg"></div>
    <div id="preloader">
        <div id="preloader-status">
            <div class="preloader-position loader"> <span></span> </div>
        </div>
    </div>

    {{-- Progress scroll to top --}}
    <div class="progress-wrap cursor-pointer">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    {{-- Header / Navbar --}}
    @include('partials.header')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Annapurna Theme JS (same order as original theme) --}}
    <script src="{{ asset('annapurna/js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('annapurna/js/jquery-migrate-3.0.0.min.js') }}"></script>
    <script src="{{ asset('annapurna/js/modernizr-2.6.2.min.js') }}"></script>
    <script src="{{ asset('annapurna/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('annapurna/js/jquery.isotope.v3.0.2.js') }}"></script>
    <script src="{{ asset('annapurna/js/pace.js') }}"></script>
    <script src="{{ asset('annapurna/js/popper.min.js') }}"></script>
    <script src="{{ asset('annapurna/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('annapurna/js/scrollIt.min.js') }}"></script>
    <script src="{{ asset('annapurna/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('annapurna/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('annapurna/js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('annapurna/js/jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset('annapurna/js/YouTubePopUp.js') }}"></script>
    <script src="{{ asset('annapurna/js/select2.js') }}"></script>
    <script src="{{ asset('annapurna/js/datepicker.js') }}"></script>
    <script src="{{ asset('annapurna/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('annapurna/js/smooth-scroll.min.js') }}"></script>
    <script src="{{ asset('annapurna/js/vegas.slider.min.js') }}"></script>
    <script src="{{ asset('annapurna/js/custom.js') }}"></script>

    {{-- Page-specific scripts --}}
    @stack('scripts')

</body>
</html>
