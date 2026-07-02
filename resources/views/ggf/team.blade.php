@extends('ggf.layouts.app')

@section('title', \App\Helpers\Cms::setting('ggf_team_page_title', 'Our Team') . ' | ' . \App\Helpers\Cms::setting('ggf_site_name', 'Guru Goraksanatha Foundation'))
@section('meta_description', \App\Helpers\Cms::setting('ggf_team_meta_description', 'Meet the dedicated team behind Guru Goraksanatha Foundation.'))

@section('header')
    <header class="header-image ken-burn-center" data-parallax="true" data-natural-height="500" data-natural-width="1920" data-bleed="0" data-image-src="{{ asset('ggf/media/' . \App\Helpers\Cms::setting('ggf_team_header_image', 'hd-1.jpg')) }}" data-offset="0">
        <div class="container">
            <h1>{{ \App\Helpers\Cms::setting('ggf_team_header_title', 'Our team') }}</h1>
            <h2>{{ \App\Helpers\Cms::setting('ggf_team_header_subtitle', 'Our big family') }}</h2>
            <ol class="breadcrumb">
                <li><a href="{{ route('ggf.home') }}">Home</a></li>
                <li><a href="#">About Foundation</a></li>
                <li>Team</li>
            </ol>
        </div>
    </header>
@endsection

@section('content')
<section class="section-base section-color">
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <p>{{ \App\Helpers\Cms::setting('ggf_team_intro_text', 'The Guru Goraksanatha Foundation is led by a dedicated team of spiritual leaders, social volunteers, cultural researchers, and community mobilizers who collectively work to preserve and promote the timeless legacy of Guru Goraksanatha. Our team brings together individuals with deep faith, professional expertise, and a strong commitment to service. Guided by the principles of discipline, compassion, and divine knowledge inherited from the Nath tradition, the foundation\'s members oversee religious activities, community welfare programs, heritage conservation efforts, and the development of Gorakshaham Gorkha. Each member contributes through their specialized roles—administration, research, outreach, event coordination, documentation, and project management—ensuring that every initiative is carried out with integrity, transparency, and devotion. United by a shared spiritual purpose, the Guru Goraksanatha Foundation team strives to uplift society, strengthen Nepal–India cultural ties, and carry forward the profound teachings of Guru Goraksanatha for future generations.') }}</p>
            </div>
        </div>

        <hr class="space-sm" />
        <hr class="space" />

        <div class="title">
            <h2>{{ \App\Helpers\Cms::setting('ggf_team_section_title', 'Our team of experts') }}</h2>
            <p>{{ \App\Helpers\Cms::setting('ggf_team_section_subtitle', 'Team members') }}</p>
        </div>

        <div class="grid-list" data-columns="4" data-columns-md="2" data-columns-sm="1">
            <div class="grid-box">
                @forelse($teamMembers as $member)
                    <div class="grid-item">
                        <div class="cnt-box-team boxed">
                            @if($member->image)
                                <img src="{{ \App\Helpers\Cms::imageUrl($member->image) }}" alt="{{ $member->name }}" />
                            @else
                                <img src="{{ asset('ggf/media/user-1.jpg') }}" alt="{{ $member->name }}" />
                            @endif
                            <div class="caption">
                                <h2>{{ $member->name }}</h2>
                                <span>{{ $member->position }}</span>
                                <span class="icon-links">
                                    @if($member->facebook)<a href="{{ $member->facebook }}" target="_blank"><i class="icon-facebook"></i></a>@endif
                                    @if($member->twitter)<a href="{{ $member->twitter }}" target="_blank"><i class="icon-twitter"></i></a>@endif
                                    @if($member->instagram)<a href="{{ $member->instagram }}" target="_blank"><i class="icon-instagram"></i></a>@endif
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="grid-item">
                        <div class="cnt-box-team boxed">
                            <img src="{{ asset('ggf/media/user-1.jpg') }}" alt="Team Member" />
                            <div class="caption">
                                <h2>Team Member</h2>
                                <span>Foundation Member</span>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <hr class="space-lg" />

        <div class="row">
            <div class="col-lg-4">
                <div class="icon-box icon-box-left">
                    <i class="{{ \App\Helpers\Cms::setting('ggf_team_box1_icon', 'im-air-balloon') }}"></i>
                    <div class="caption">
                        <h3>{{ \App\Helpers\Cms::setting('ggf_team_box1_title', 'The best job') }}</h3>
                        <p>{{ \App\Helpers\Cms::setting('ggf_team_box1_text', 'All day immerse into the nature and amazing views.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="icon-box icon-box-left">
                    <i class="{{ \App\Helpers\Cms::setting('ggf_team_box2_icon', 'im-bar-chart2') }}"></i>
                    <div class="caption">
                        <h3>{{ \App\Helpers\Cms::setting('ggf_team_box2_title', 'Career opportunities') }}</h3>
                        <p>{{ \App\Helpers\Cms::setting('ggf_team_box2_text', 'Grow with us is possible thanks to our levels structure.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="icon-box icon-box-left">
                    <i class="{{ \App\Helpers\Cms::setting('ggf_team_box3_icon', 'im-bee') }}"></i>
                    <div class="caption">
                        <h3>{{ \App\Helpers\Cms::setting('ggf_team_box3_title', 'Meet amazing people') }}</h3>
                        <p>{{ \App\Helpers\Cms::setting('ggf_team_box3_text', 'We\'re the best team ever! Funny and friendly with each other.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="space" />

        <div class="cnt-box cnt-call">
            <div class="caption">
                <h2>{{ \App\Helpers\Cms::setting('ggf_team_join_title', 'Join our team') }}</h2>
                <p>{{ \App\Helpers\Cms::setting('ggf_team_join_text', 'We welcome devoted individuals who wish to contribute to the preservation of Nath heritage, community upliftment, and the sacred mission of Guru Goraksanatha Foundation.') }}</p>
                <a href="{{ route('ggf.contact') }}" class="btn btn-xs">{{ \App\Helpers\Cms::setting('ggf_team_join_button', 'Contact us') }}</a>
            </div>
        </div>

    </div>
</section>
@endsection
