@extends('layouts.app')

@section('meta_title', 'Our Guides — ' . \App\Helpers\Cms::siteName())
@section('meta_description', 'Meet our experienced trekking and tour guides in the Annapurna Region of Nepal.')

@section('content')

{{-- Banner --}}
<div class="banner-header section-padding valign bg-img bg-fixed back-position-center"
     data-overlay-dark="5"
     data-background="{{ asset('annapurna/img/slider/annapurna-region.png') }}">
    <div class="container">
        <div class="row">
            <div class="col-md-12 caption mt-90">
                <h6>Expert Local Knowledge</h6>
                <h1>Our <span>Guides</span></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Guides</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

{{-- Featured Guides --}}
@if($featured->isNotEmpty())
<section class="team section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-subtitle"><span>Top Picks</span></div>
                <div class="section-title">Featured <span>Guides</span></div>
            </div>
        </div>
        <div class="row">
            @foreach($featured as $guide)
            <div class="col-md-3 col-sm-6">
                <div class="team-card">
                    <div class="team-img">
                        <a href="{{ route('guides.show', $guide->slug) }}">
                            <img src="{{ $guide->photo ? asset('storage/'.$guide->photo) : asset('annapurna/img/team/default-guide.jpg') }}"
                                 alt="{{ $guide->name }}"
                                 style="width:100%; height:280px; object-fit:cover; border-radius:8px 8px 0 0;">
                        </a>
                    </div>
                    <div class="team-info" style="padding:18px; background:#fff; border:1px solid #eee; border-top:none; border-radius:0 0 8px 8px;">
                        <h5 style="font-size:16px; font-weight:700; margin:0 0 4px;">
                            <a href="{{ route('guides.show', $guide->slug) }}" style="color:#1a1a2e;">{{ $guide->name }}</a>
                        </h5>
                        <p style="font-size:12px; color:#c8a96e; margin:0 0 8px;">
                            {{ $guide->experience_years }} yrs experience
                            @if($guide->rating > 0)
                            &nbsp;·&nbsp; {{ $guide->rating }} ★
                            @endif
                        </p>
                        @if($guide->specializations)
                        <div style="margin-bottom:8px;">
                            @foreach(array_slice($guide->specializations, 0, 2) as $spec)
                            <span style="font-size:11px; background:#f0f7ff; color:#3a6ea5; padding:2px 8px; border-radius:20px; margin-right:4px; display:inline-block;">{{ $spec }}</span>
                            @endforeach
                        </div>
                        @endif
                        <p style="font-size:13px; color:#666; margin:0;">{{ Str::limit($guide->short_bio, 80) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- All Guides --}}
<section class="team section-padding bg-lightnav">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-subtitle"><span>Meet the Team</span></div>
                <div class="section-title">All <span>Guides</span></div>
            </div>
        </div>

        @if($guides->isEmpty())
        <div class="row">
            <div class="col-md-12 text-center" style="padding:60px 0;">
                <i class="ti-user" style="font-size:48px; color:#ccc;"></i>
                <p style="color:#888; margin-top:16px;">No guides available at the moment.</p>
            </div>
        </div>
        @else
        <div class="row">
            @foreach($guides as $guide)
            <div class="col-md-4 col-sm-6" style="margin-bottom:28px;">
                <div style="background:#fff; border-radius:10px; overflow:hidden; box-shadow:0 2px 16px rgba(0,0,0,0.06); height:100%;">
                    <a href="{{ route('guides.show', $guide->slug) }}">
                        <img src="{{ $guide->photo ? asset('storage/'.$guide->photo) : asset('annapurna/img/team/default-guide.jpg') }}"
                             alt="{{ $guide->name }}"
                             style="width:100%; height:220px; object-fit:cover;">
                    </a>
                    <div style="padding:18px 20px 20px;">
                        <h5 style="font-size:16px; font-weight:700; margin:0 0 4px;">
                            <a href="{{ route('guides.show', $guide->slug) }}" style="color:#1a1a2e;">{{ $guide->name }}</a>
                        </h5>
                        <p style="font-size:12px; color:#c8a96e; margin:0 0 10px;">
                            {{ $guide->experience_years }} yrs experience
                            @if($guide->rating > 0) &nbsp;·&nbsp; {{ $guide->rating }} ★ @endif
                        </p>

                        @if($guide->languages)
                        <p style="font-size:12px; color:#888; margin:0 0 8px;">
                            <i class="ti-comments" style="margin-right:4px;"></i>
                            {{ implode(', ', $guide->languages) }}
                        </p>
                        @endif

                        @if($guide->specializations)
                        <div style="margin-bottom:10px;">
                            @foreach(array_slice($guide->specializations, 0, 3) as $spec)
                            <span style="font-size:11px; background:#f0f7ff; color:#3a6ea5; padding:2px 8px; border-radius:20px; margin:2px 2px 0 0; display:inline-block;">{{ $spec }}</span>
                            @endforeach
                        </div>
                        @endif

                        <p style="font-size:13px; color:#666; margin:0 0 14px; line-height:1.6;">{{ Str::limit($guide->short_bio, 100) }}</p>

                        <a href="{{ route('guides.show', $guide->slug) }}"
                           style="font-size:13px; font-weight:600; color:#c8a96e; text-decoration:none;">
                            View Profile <i class="ti-arrow-right" style="font-size:11px;"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                {{ $guides->links() }}
            </div>
        </div>
        @endif
    </div>
</section>

@endsection
