@extends('layouts.app')

@section('meta_title', $guide->name . ' — Guide — ' . \App\Helpers\Cms::siteName())
@section('meta_description', $guide->short_bio ?? 'Expert trekking guide in the Annapurna Region of Nepal.')

@section('content')

{{-- Banner --}}
<div class="banner-header section-padding valign bg-img bg-fixed back-position-center"
     data-overlay-dark="6"
     data-background="{{ asset('annapurna/img/slider/annapurna-region.png') }}">
    <div class="container">
        <div class="row">
            <div class="col-md-12 caption mt-90">
                <h6>Expert Guide</h6>
                <h1>{{ $guide->name }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('guides.index') }}">Guides</a></li>
                        <li class="breadcrumb-item active">{{ $guide->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

{{-- Main Profile --}}
<section class="section-padding">
    <div class="container">
        <div class="row">

            {{-- Left: Photo + Stats --}}
            <div class="col-md-4" style="margin-bottom:30px;">
                <div style="background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.08);">
                    <img src="{{ $guide->photo ? asset('storage/'.$guide->photo) : asset('annapurna/img/team/default-guide.jpg') }}"
                         alt="{{ $guide->name }}"
                         style="width:100%; height:340px; object-fit:cover;">

                    <div style="padding:24px;">
                        <h3 style="font-size:22px; font-weight:700; margin:0 0 4px;">{{ $guide->name }}</h3>

                        @if($guide->rating > 0)
                        <div style="margin-bottom:12px;">
                            @for($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= floor($guide->rating) ? 'ti-star' : 'ti-star-half-alt' }}"
                               style="color:#c8a96e; font-size:14px;"></i>
                            @endfor
                            <span style="font-size:13px; color:#888; margin-left:4px;">{{ $guide->rating }}/5</span>
                        </div>
                        @endif

                        {{-- Stats --}}
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
                            <div style="background:#f8f9fa; border-radius:8px; padding:12px; text-align:center;">
                                <div style="font-size:22px; font-weight:700; color:#6b2d0e;">{{ $guide->experience_years }}</div>
                                <div style="font-size:11px; color:#888; margin-top:2px;">Years Exp.</div>
                            </div>
                            <div style="background:#f8f9fa; border-radius:8px; padding:12px; text-align:center;">
                                <div style="font-size:22px; font-weight:700; color:#6b2d0e;">{{ $guide->total_treks ?? '—' }}</div>
                                <div style="font-size:11px; color:#888; margin-top:2px;">Treks Led</div>
                            </div>
                        </div>

                        {{-- Contact --}}
                        @if($guide->phone || $guide->email)
                        <div style="border-top:1px solid #eee; padding-top:14px;">
                            @if($guide->phone)
                            <p style="font-size:13px; margin:0 0 6px;">
                                <i class="ti-mobile" style="color:#c8a96e; margin-right:6px;"></i>
                                <a href="tel:{{ $guide->phone }}" style="color:#333;">{{ $guide->phone }}</a>
                            </p>
                            @endif
                            @if($guide->email)
                            <p style="font-size:13px; margin:0;">
                                <i class="ti-email" style="color:#c8a96e; margin-right:6px;"></i>
                                <a href="mailto:{{ $guide->email }}" style="color:#333;">{{ $guide->email }}</a>
                            </p>
                            @endif
                        </div>
                        @endif

                        {{-- Contact CTA --}}
                        <a href="{{ route('contact') }}?guide={{ $guide->name }}"
                           style="display:block; margin-top:16px; background:#6b2d0e; color:#fff; text-align:center; padding:12px; border-radius:6px; font-size:14px; font-weight:600; text-decoration:none;">
                            Book This Guide
                        </a>
                    </div>
                </div>
            </div>

            {{-- Right: Bio + Details --}}
            <div class="col-md-8">

                {{-- Short Bio --}}
                @if($guide->short_bio)
                <div style="background:#fdf6ee; border-left:4px solid #c8a96e; padding:16px 20px; border-radius:0 8px 8px 0; margin-bottom:24px;">
                    <p style="font-size:15px; font-style:italic; color:#555; margin:0; line-height:1.7;">{{ $guide->short_bio }}</p>
                </div>
                @endif

                {{-- Full Bio --}}
                @if($guide->bio)
                <div style="margin-bottom:28px;">
                    <h4 style="font-size:18px; font-weight:700; margin:0 0 12px; border-bottom:2px solid #eee; padding-bottom:8px;">About {{ $guide->name }}</h4>
                    <div style="font-size:14px; color:#555; line-height:1.8;">{!! nl2br(e($guide->bio)) !!}</div>
                </div>
                @endif

                <div class="row">
                    {{-- Specializations --}}
                    @if($guide->specializations && count($guide->specializations))
                    <div class="col-md-6" style="margin-bottom:20px;">
                        <h5 style="font-size:15px; font-weight:700; margin:0 0 10px;">
                            <i class="ti-map" style="color:#c8a96e; margin-right:6px;"></i> Specializations
                        </h5>
                        <div>
                            @foreach($guide->specializations as $spec)
                            <span style="font-size:12px; background:#f0f7ff; color:#3a6ea5; padding:4px 10px; border-radius:20px; margin:3px 3px 0 0; display:inline-block;">{{ $spec }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Languages --}}
                    @if($guide->languages && count($guide->languages))
                    <div class="col-md-6" style="margin-bottom:20px;">
                        <h5 style="font-size:15px; font-weight:700; margin:0 0 10px;">
                            <i class="ti-comments" style="color:#c8a96e; margin-right:6px;"></i> Languages
                        </h5>
                        <div>
                            @foreach($guide->languages as $lang)
                            <span style="font-size:12px; background:#f0fff4; color:#276749; padding:4px 10px; border-radius:20px; margin:3px 3px 0 0; display:inline-block;">{{ $lang }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Certifications --}}
                    @if($guide->certifications && count($guide->certifications))
                    <div class="col-md-12" style="margin-bottom:20px;">
                        <h5 style="font-size:15px; font-weight:700; margin:0 0 10px;">
                            <i class="ti-id-badge" style="color:#c8a96e; margin-right:6px;"></i> Certifications
                        </h5>
                        <div>
                            @foreach($guide->certifications as $cert)
                            <span style="font-size:12px; background:#fff8e1; color:#8a6d00; padding:4px 12px; border-radius:20px; margin:3px 3px 0 0; display:inline-block; border:1px solid #e6c86e;">
                                <i class="ti-check" style="font-size:10px; margin-right:3px;"></i>{{ $cert }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</section>

{{-- Related Guides --}}
@if($related->isNotEmpty())
<section class="section-padding" style="background:#f8f9fa;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-subtitle"><span>Meet More</span></div>
                <div class="section-title">Other <span>Guides</span></div>
            </div>
        </div>
        <div class="row">
            @foreach($related as $rel)
            <div class="col-md-4" style="margin-bottom:20px;">
                <div style="background:#fff; border-radius:10px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,0.07); display:flex; align-items:center; padding:16px;">
                    <img src="{{ $rel->photo ? asset('storage/'.$rel->photo) : asset('annapurna/img/team/default-guide.jpg') }}"
                         alt="{{ $rel->name }}"
                         style="width:64px; height:64px; border-radius:50%; object-fit:cover; margin-right:14px; flex-shrink:0;">
                    <div>
                        <h5 style="font-size:15px; font-weight:700; margin:0 0 3px;">
                            <a href="{{ route('guides.show', $rel->slug) }}" style="color:#1a1a2e;">{{ $rel->name }}</a>
                        </h5>
                        <p style="font-size:12px; color:#888; margin:0 0 6px;">{{ $rel->experience_years }} yrs exp.</p>
                        <a href="{{ route('guides.show', $rel->slug) }}"
                           style="font-size:12px; font-weight:600; color:#c8a96e; text-decoration:none;">
                            View Profile →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
