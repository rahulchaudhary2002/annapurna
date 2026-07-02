@extends('ggf.layouts.app')

e ggf@section('title', \App\Helpers\Cms::setting('ggf_history_page_title', 'History') . ' | ' . \App\Helpers\Cms::setting('ggf_site_name', 'Guru Goraksanatha Foundation'))
@section('meta_description', \App\Helpers\Cms::setting('ggf_history_meta_description', 'The history and journey of Guru Goraksanatha Foundation.'))

@section('header')
    <header class="header-image ken-burn-center" data-parallax="true" data-natural-height="500" data-natural-width="1920" data-bleed="0" data-image-src="{{ asset('ggf/media/' . \App\Helpers\Cms::setting('ggf_history_header_image', 'hd-4.jpg')) }}" data-offset="0">
        <div class="container">
            <h1>{{ \App\Helpers\Cms::setting('ggf_history_header_title', 'Our history') }}</h1>
            <h2>{{ \App\Helpers\Cms::setting('ggf_history_header_subtitle', 'How we came here') }}</h2>
            <ol class="breadcrumb">
                <li><a href="{{ route('ggf.home') }}">Home</a></li>
                <li><a href="#">About Foundation</a></li>
                <li>History</li>
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
            <div class="row">
                <div class="col-lg-9">
                    <div class="timeline">
                        <div>
                            <div class="badge">
                                <p>{{ \App\Helpers\Cms::setting('ggf_history_timeline_1_year', '2015') }}</p>
                                <span>{{ \App\Helpers\Cms::setting('ggf_history_timeline_1_label', 'Foundation') }}</span>
                            </div>
                            <div class="panel">
                                <h3 class="timeline-title">{{ \App\Helpers\Cms::setting('ggf_history_timeline_1_title', 'Establishment of the Foundation') }}</h3>
                                <p>{{ \App\Helpers\Cms::setting('ggf_history_timeline_1_text', 'Guru Goraksanatha Foundation was established with the sacred vision of preserving, reviving, and promoting the profound spiritual legacy of Guru Goraksanatha and the Nath Yogic tradition rooted in Gorkha, Nepal — historically known as the divine tapobhoomi (meditation ground) of Guru Goraksanatha.') }}</p>
                            </div>
                        </div>
                        <div class="inverted">
                            <div class="badge">
                                <p>{{ \App\Helpers\Cms::setting('ggf_history_timeline_2_year', '2018') }}</p>
                                <span>{{ \App\Helpers\Cms::setting('ggf_history_timeline_2_label', 'Registration') }}</span>
                            </div>
                            <div class="panel">
                                <h3 class="timeline-title">{{ \App\Helpers\Cms::setting('ggf_history_timeline_2_title', 'Formal Registration & Community Outreach') }}</h3>
                                <p>{{ \App\Helpers\Cms::setting('ggf_history_timeline_2_text', 'A group of devoted practitioners, community leaders, and spiritual seekers formally registered the Foundation with the purpose of revitalizing the ancient heritage and transforming Gorkha into a global center of spiritual learning.') }}</p>
                            </div>
                        </div>
                        <div>
                            <div class="badge">
                                <p>{{ \App\Helpers\Cms::setting('ggf_history_timeline_3_year', '2021') }}</p>
                                <span>{{ \App\Helpers\Cms::setting('ggf_history_timeline_3_label', 'Collaboration') }}</span>
                            </div>
                            <div class="panel">
                                <h3 class="timeline-title">{{ \App\Helpers\Cms::setting('ggf_history_timeline_3_title', 'Nepal–India Spiritual Collaboration') }}</h3>
                                <p>{{ \App\Helpers\Cms::setting('ggf_history_timeline_3_text', 'The Foundation fostered Nepal–India spiritual friendship rooted in the teachings of Guru Goraksanatha, protecting traditional Nath practices, promoting yoga and meditation, and conserving sacred sites across the Himalayan region.') }}</p>
                            </div>
                        </div>
                        <div class="inverted">
                            <div class="badge">
                                <p>{{ \App\Helpers\Cms::setting('ggf_history_timeline_4_year', '2024') }}</p>
                                <span>{{ \App\Helpers\Cms::setting('ggf_history_timeline_4_label', 'Gorakshadham') }}</span>
                            </div>
                            <div class="panel">
                                <h3 class="timeline-title">{{ \App\Helpers\Cms::setting('ggf_history_timeline_4_title', 'Gorakshadham Gorkha Project Launched') }}</h3>
                                <p>{{ \App\Helpers\Cms::setting('ggf_history_timeline_4_text', 'The Foundation initiated the ambitious Gorakshadham Gorkha Project — a long-term vision to develop a spiritual and cultural destination incorporating temples, gurukul, meditation centers, cultural hubs, vedic museums, ashram, dharmashala, gaushala, and eco-friendly infrastructure.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="menu-inner menu-inner-vertical boxed-area">
                        <ul>
                            <li><a href="{{ route('ggf.about') }}">About us</a></li>
                            <li><a href="{{ route('ggf.team') }}">Our team</a></li>
                            <li class="active"><a href="{{ route('ggf.history') }}">History</a></li>
                            <li><a href="{{ route('ggf.programs') }}">Programs</a></li>
                            <li><a href="{{ route('ggf.contact') }}">Contact us</a></li>
                        </ul>
                    </div>
                    <hr class="space-sm" />
                    <div class="cnt-box cnt-box-top-icon boxed">
                        <i class="im-envelope"></i>
                        <div class="caption">
                            <h2>{{ \App\Helpers\Cms::setting('ggf_history_contact_title', 'Need more information?') }}</h2>
                            <p>{{ \App\Helpers\Cms::setting('ggf_history_contact_text', 'Reach out to us — we are happy to share more about the Foundation and our mission.') }}</p>
                            <a href="{{ route('ggf.contact') }}" class="btn-text">Contact us</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
