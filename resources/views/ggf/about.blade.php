@extends('ggf.layouts.app')

@section('title', \App\Helpers\Cms::setting('ggf_about_page_title', 'About Us') . ' | ' . \App\Helpers\Cms::setting('ggf_site_name', 'Guru Goraksanatha Foundation'))
@section('meta_description', \App\Helpers\Cms::setting('ggf_about_meta_description', 'About Guru Goraksanatha Foundation - Our history, vision, and mission.'))

@section('header')
    <header class="header-image ken-burn-center" data-parallax="true" data-natural-height="500" data-natural-width="1920" data-bleed="0" data-image-src="{{ asset('ggf/media/' . \App\Helpers\Cms::setting('ggf_about_header_image', 'hd-1.jpg')) }}" data-offset="0">
        <div class="container">
            <h1>{{ \App\Helpers\Cms::setting('ggf_about_header_title', 'About us') }}</h1>
            <h2>{{ \App\Helpers\Cms::setting('ggf_about_header_subtitle', 'Our core values') }}</h2>
            <ol class="breadcrumb">
                <li><a href="{{ route('ggf.home') }}">Home</a></li>
                <li><a href="#">About Foundation</a></li>
                <li>About</li>
            </ol>
        </div>
    </header>
@endsection

@section('content')
<section class="section-base">
    <div class="container">

        @if($page && $page->content)
            {!! $page->content !!}
        @else
        <div class="row row-fit-lg">
            <div class="col-lg-4">
                <p>{{ \App\Helpers\Cms::setting('ggf_about_text_1', 'Guru Goraksanatha Foundation is a non-profit spiritual and cultural organization dedicated to preserving and promoting the divine legacy of Guru Goraksanatha, the Nath tradition, and the sacred heritage of Devbhumi Gorkha, Nepal.') }}</p>
                <p>{{ \App\Helpers\Cms::setting('ggf_about_text_2', 'Our mission is rooted in the belief that the teachings of Guru Goraksanatha—yoga, discipline, devotion, self-realization, and service—are timeless sources of spiritual strength and global harmony.') }}</p>
            </div>
            <div class="col-lg-4">
                <p>{{ \App\Helpers\Cms::setting('ggf_about_text_3', 'The Foundation works to safeguard the Nath yogic heritage, uplift communities, and promote spiritual awareness that has flourished in the Himalayan region for centuries. Our efforts ensure that future generations can connect with this timeless wisdom.') }}</p>
            </div>
            <div class="col-lg-4">
                <ul class="slider light" data-options="arrows:false,nav:true">
                    <li><a class="img-box lightbox" href="{{ asset('ggf/media/' . \App\Helpers\Cms::setting('ggf_about_slider_1', 'gorkha-1975.png')) }}"><img src="{{ asset('ggf/media/' . \App\Helpers\Cms::setting('ggf_about_slider_1', 'gorkha-1975.png')) }}" alt="{{ \App\Helpers\Cms::setting('ggf_about_slider_1_alt', 'Gorkha 1975') }}"></a></li>
                    <li><a class="img-box lightbox" href="{{ asset('ggf/media/' . \App\Helpers\Cms::setting('ggf_about_slider_2', 'gorkha-2025.png')) }}"><img src="{{ asset('ggf/media/' . \App\Helpers\Cms::setting('ggf_about_slider_2', 'gorkha-2025.png')) }}" alt="{{ \App\Helpers\Cms::setting('ggf_about_slider_2_alt', 'Gorkha 2025') }}"></a></li>
                    <li><a class="img-box lightbox" href="{{ asset('ggf/media/' . \App\Helpers\Cms::setting('ggf_about_slider_3', 'gorakh.png')) }}"><img src="{{ asset('ggf/media/' . \App\Helpers\Cms::setting('ggf_about_slider_3', 'gorakh.png')) }}" alt="{{ \App\Helpers\Cms::setting('ggf_about_slider_3_alt', 'Gorakh') }}"></a></li>
                </ul>
            </div>
        </div>

        <hr class="space" />

        <div class="title">
            <h2>{{ \App\Helpers\Cms::setting('ggf_about_history_title', 'History of Guru Goraksanatha Foundation') }}</h2>
            <p>{{ \App\Helpers\Cms::setting('ggf_about_history_subtitle', 'Our Journey') }}</p>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <p style="text-align: justify;">
                    {!! nl2br(e(\App\Helpers\Cms::setting('ggf_about_history_text', 'Guru Goraksanatha Foundation was established with the sacred vision of preserving, reviving, and promoting the profound spiritual legacy of Guru Goraksanatha and the Nath Yogic tradition rooted in Gorkha, Nepal.'))) !!}
                </p>
            </div>
            <div class="col-lg-4">
                <div style="background:#f7f7f7; padding:20px; border-radius:8px;">
                    <p>
                        <b>{{ \App\Helpers\Cms::setting('ggf_about_vision_title', 'Our Vision') }}</b><br>
                        {{ \App\Helpers\Cms::setting('ggf_about_vision_intro', 'To establish Gorakshadham Gorkha as an international center for:') }}<br>
                        {!! nl2br(e(\App\Helpers\Cms::setting('ggf_about_vision_items', "• Spiritual learning\n• Yoga & meditation\n• Nath culture & heritage\n• Religious tourism\n• Cultural and academic research"))) !!}
                        <br><br>
                        <b>{{ \App\Helpers\Cms::setting('ggf_about_purpose_title', 'Our Core Purpose') }}</b><br>
                        {!! nl2br(e(\App\Helpers\Cms::setting('ggf_about_purpose_items', "• Revive and strengthen Nepal–India's shared spiritual heritage\n• Restore and conserve ancient Nath sites\n• Promote cultural tourism for Gorkha and Gorakhpur\n• Produce documentaries, books, and digital archives\n• Build a global spiritual hub in Gorkha"))) !!}
                    </p>
                </div>
            </div>
        </div>
        @endif

        <hr class="space" />

        {{-- Counters --}}
        <table class="table table-grid table-border align-left table-6-md">
            <tbody>
                <tr>
                    @if(isset($counters) && $counters->count())
                        @foreach($counters as $counter)
                        <td>
                            <div class="counter counter-horizontal counter-icon">
                                @if($counter->icon)<i class="{{ $counter->icon }} text-md"></i>@else<i class="im-globe text-md"></i>@endif
                                <div>
                                    <h3>{{ $counter->label }}</h3>
                                    <div class="value">
                                        <span class="text-md" data-to="{{ $counter->numeric_value }}" data-speed="5000">{{ $counter->numeric_value }}</span>
                                        <span>{{ $counter->suffix }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        @endforeach
                    @else
                        <td><div class="counter counter-horizontal counter-icon"><i class="im-globe text-md"></i><div><h3>Communities Reached</h3><div class="value"><span class="text-md" data-to="120" data-speed="5000">120</span><span>+</span></div></div></div></td>
                        <td><div class="counter counter-horizontal counter-icon"><i class="im-business-man text-md"></i><div><h3>Children Supported</h3><div class="value"><span class="text-md" data-to="4500" data-speed="5000">4500</span><span>+</span></div></div></div></td>
                        <td><div class="counter counter-horizontal counter-icon"><i class="im-charger text-md"></i><div><h3>Projects Completed</h3><div class="value"><span class="text-md" data-to="320" data-speed="5000">320</span><span>+</span></div></div></div></td>
                        <td><div class="counter counter-horizontal counter-icon"><i class="im-support text-md"></i><div><h3>Volunteers</h3><div class="value"><span class="text-md" data-to="850" data-speed="5000">850</span><span>+</span></div></div></div></td>
                    @endif
                </tr>
            </tbody>
        </table>

    </div>
</section>
@endsection
