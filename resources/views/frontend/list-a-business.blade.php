@extends('layouts.app')

@section('meta_title', 'List a Business – ' . \App\Helpers\Cms::siteName())
@section('meta_description', 'List your hotel, restaurant, travel agency, guide, or porter service on Annapurna Region and reach thousands of trekkers and travelers.')

@push('styles')
<style>
    .lab-benefits { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
    @media (max-width: 991px) { .lab-benefits { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 575px) { .lab-benefits { grid-template-columns: 1fr; } }
    .lab-benefit-card {
        background: #fff; border: 1px solid #e0ddd4; border-radius: 12px;
        padding: 30px 24px; text-align: center; transition: box-shadow .2s, transform .2s;
    }
    .lab-benefit-card:hover { box-shadow: 0 12px 30px rgba(15,36,84,.08); transform: translateY(-4px); }
    .lab-benefit-icon {
        width: 60px; height: 60px; border-radius: 50%; background: rgba(32,149,174,.1);
        color: #2095AE; display: flex; align-items: center; justify-content: center;
        font-size: 26px; margin: 0 auto 18px;
    }
    .lab-benefit-card h5 { font-size: 16px; font-weight: 700; color: #0f2454; margin-bottom: 8px; }
    .lab-benefit-card p { font-size: 13px; color: #6b7280; margin: 0; }

    .lab-steps { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; counter-reset: lab-step; }
    @media (max-width: 991px) { .lab-steps { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 575px) { .lab-steps { grid-template-columns: 1fr; } }
    .lab-step { position: relative; padding: 30px 20px 20px; text-align: center; }
    .lab-step-num {
        width: 44px; height: 44px; border-radius: 50%; background: #0f2454; color: #e4a853;
        display: flex; align-items: center; justify-content: center; font-weight: 700;
        font-family: 'Poppins', sans-serif; margin: 0 auto 16px;
    }
    .lab-step h5 { font-size: 15px; font-weight: 700; color: #0f2454; margin-bottom: 8px; }
    .lab-step p { font-size: 13px; color: #6b7280; margin: 0; }

    .lab-types { display: flex; flex-wrap: wrap; gap: 14px; justify-content: center; }
    .lab-type-chip {
        display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #e0ddd4;
        border-radius: 30px; padding: 10px 22px; font-size: 13px; font-weight: 600; color: #0f2454;
    }
    .lab-type-chip i { color: #2095AE; font-size: 16px; }

    .lab-final-cta {
        background: linear-gradient(135deg, #0f2454 0%, #1a3a6e 100%);
        border-radius: 16px; padding: 50px 40px; text-align: center;
    }
    .lab-final-cta h3 { color: #fff; font-size: 24px; font-weight: 700; margin-bottom: 10px; }
    .lab-final-cta h3 span { color: #e4a853; }
    .lab-final-cta p { color: rgba(255,255,255,.75); font-size: 14px; margin-bottom: 24px; }

    .btn-partner { display: inline-block; padding: 13px 32px; border-radius: 8px; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 600; text-decoration: none; transition: all .2s; }
    .btn-partner-primary { background: #2095AE; color: #fff; border: 2px solid #2095AE; }
    .btn-partner-primary:hover { background: #1288a2; border-color: #1288a2; color: #fff; }
</style>
@endpush

@section('content')

    {{-- Page Banner --}}
    <div class="banner-header section-padding back-position-center valign bg-img bg-fixed"
         data-overlay-dark="5" data-background="{{ asset('annapurna/img/slider/panaromic.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center caption mt-90">
                    <h6>Grow With Annapurna Region</h6>
                    <h1>List Your <span>Business</span></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">List a Business</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Intro --}}
    <section class="section-padding pb-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle">Get Discovered</div>
                    <div class="section-title">Reach Thousands of <span>Trekkers &amp; Travelers</span></div>
                    <p style="color:#6b7280;">
                        Whether you run a hotel, restaurant, travel agency, or offer guide and porter services,
                        listing on Annapurna Region puts your business in front of travelers actively planning
                        their trip to the Annapurna region.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Benefits --}}
    <section class="section-padding">
        <div class="container">
            <div class="lab-benefits">
                <div class="lab-benefit-card">
                    <div class="lab-benefit-icon"><i class="ti-check-box"></i></div>
                    <h5>Verified Listings</h5>
                    <p>Build trust with a verified badge once your business is reviewed and approved.</p>
                </div>
                <div class="lab-benefit-card">
                    <div class="lab-benefit-icon"><i class="ti-stats-up"></i></div>
                    <h5>Analytics Dashboard</h5>
                    <p>Track profile views, clicks, and engagement from your own business dashboard.</p>
                </div>
                <div class="lab-benefit-card">
                    <div class="lab-benefit-icon"><i class="ti-comment-alt"></i></div>
                    <h5>Direct Enquiries</h5>
                    <p>Receive bookings and enquiries straight from travelers browsing your profile.</p>
                </div>
                <div class="lab-benefit-card">
                    <div class="lab-benefit-icon"><i class="ti-star"></i></div>
                    <h5>Premium Visibility</h5>
                    <p>Feature your packages and posts to stand out across the site.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Business Types --}}
    <section class="section-padding pt-0">
        <div class="container">
            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle">Who Can List</div>
                    <div class="section-title">Every Kind of <span>Travel Business</span></div>
                </div>
            </div>
            <div class="lab-types">
                <div class="lab-type-chip"><i class="ti-home"></i> Hotels &amp; Lodges</div>
                <div class="lab-type-chip"><i class="ti-cup"></i> Restaurants &amp; Cafes</div>
                <div class="lab-type-chip"><i class="ti-briefcase"></i> Travel Agencies</div>
                <div class="lab-type-chip"><i class="ti-flag-alt"></i> Trekking Guides</div>
                <div class="lab-type-chip"><i class="ti-package"></i> Porter Services</div>
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <section class="section-padding bg-lightnav">
        <div class="container">
            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle">Simple Process</div>
                    <div class="section-title">How It <span>Works</span></div>
                </div>
            </div>
            <div class="lab-steps">
                <div class="lab-step">
                    <div class="lab-step-num">1</div>
                    <h5>Create an Account</h5>
                    <p>Sign up for a free account, or log in if you already have one.</p>
                </div>
                <div class="lab-step">
                    <div class="lab-step-num">2</div>
                    <h5>Add Your Business</h5>
                    <p>Fill in your business details, photos, contact info, and location.</p>
                </div>
                <div class="lab-step">
                    <div class="lab-step-num">3</div>
                    <h5>Get Verified</h5>
                    <p>Our team reviews your listing and marks it verified for extra trust.</p>
                </div>
                <div class="lab-step">
                    <div class="lab-step-num">4</div>
                    <h5>Start Growing</h5>
                    <p>Manage your profile, packages, and enquiries from your dashboard.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Final CTA --}}
    <section class="section-padding">
        <div class="container">
            <div class="lab-final-cta">
                <h3>Ready to Reach More <span>Travelers</span>?</h3>
                <p>It only takes a few minutes to create your free business listing.</p>
                <a href="{{ route('dashboard.businesses.create') }}" class="btn-partner btn-partner-primary">
                    @auth Add Your Business @else Get Started — It's Free @endauth
                </a>
            </div>
        </div>
    </section>

@endsection
