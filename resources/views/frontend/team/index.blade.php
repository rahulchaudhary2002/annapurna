@extends('layouts.app')

@section('meta_title', \App\Helpers\Cms::setting('team_meta_title', 'Our Team - ' . \App\Helpers\Cms::siteName()))

@section('content')

@php
    $pageSubtitle = \App\Helpers\Cms::setting('team_page_subtitle', 'Our Team');
    $pageTitle = \App\Helpers\Cms::setting('team_page_title', 'People Behind The Work');
    $pageDescription = \App\Helpers\Cms::setting('team_page_description', '');
    $breadcrumbImage = \App\Helpers\Cms::setting('team_breadcrumb_image');
@endphp

@include('partials.breadcrumb', [
    'title' => \App\Helpers\Cms::setting('team_breadcrumb_title', 'Team'),
    'bgImage' => $breadcrumbImage ? \App\Helpers\Cms::imageUrl($breadcrumbImage) : null,
])

<section class="team-section section-padding fix">
    <div class="container">
        <div class="section-title text-center mb-5">
            <span class="sub-title">{{ $pageSubtitle }}</span>
            <h2>{{ $pageTitle }}</h2>
            @if($pageDescription)
                <p class="mt-3">{{ $pageDescription }}</p>
            @endif
        </div>

        @if($departments->count() > 1)
        <div class="team-filter text-center mb-5">
            <ul class="filter-list list-unstyled d-flex flex-wrap justify-content-center gap-2">
                <li><button class="filter-btn active" data-filter="all">All</button></li>
                @foreach($departments as $dept)
                    <li><button class="filter-btn" data-filter="{{ Str::slug($dept) }}">{{ $dept }}</button></li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="row">
            @foreach($teamMembers as $member)
            <div class="col-xl-3 col-lg-3 col-md-6 mb-4 wow fadeInUp team-item" data-dept="{{ Str::slug($member->department ?? 'general') }}">
                <div class="team-box-items text-center">
                    <div class="team-image">
                        <a href="{{ route('team.show', $member->slug) }}">
                            <img src="{{ \App\Helpers\Cms::imageUrl($member->image, asset('assets/img/team/placeholder.jpg')) }}"
                                 alt="{{ $member->name }}" class="img-fluid">
                        </a>
                        <div class="team-social">
                            @if($member->facebook)<a href="{{ $member->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a>@endif
                            @if($member->twitter)<a href="{{ $member->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a>@endif
                            @if($member->linkedin)<a href="{{ $member->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>@endif
                            @if($member->instagram)<a href="{{ $member->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a>@endif
                        </div>
                    </div>
                    <div class="team-content mt-3">
                        <h4><a href="{{ route('team.show', $member->slug) }}">{{ $member->name }}</a></h4>
                        <p>{{ $member->position }}</p>
                        @if($member->department)
                            <span class="badge bg-primary">{{ $member->department }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
