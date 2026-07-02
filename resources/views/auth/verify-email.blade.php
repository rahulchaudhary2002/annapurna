@extends('layouts.app')

@section('meta_title', 'Verify Your Email - ' . \App\Helpers\Cms::siteName())

@push('styles')
<style>
    .auth-section { padding: 80px 0; background: #f9f7f4; }
    .auth-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        padding: 40px 36px;
        max-width: 500px;
        margin: 0 auto;
        text-align: center;
    }
    .auth-card .icon-wrap {
        width: 72px;
        height: 72px;
        background: #fef3e2;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        font-size: 28px;
        color: #c8a96e;
    }
    .auth-card h2 { font-size: 22px; font-weight: 700; color: #1a1a2e; margin-bottom: 12px; }
    .auth-card p { color: #666; font-size: 14px; line-height: 1.7; margin-bottom: 28px; }
    .auth-card .btn-submit {
        background: #c8a96e;
        color: #fff;
        border: none;
        padding: 12px 32px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
        font-family: 'Poppins', sans-serif;
    }
    .auth-card .btn-submit:hover { background: #b8924a; }
    .logout-link { display: block; margin-top: 20px; font-size: 13px; color: #888; }
    .logout-link a { color: #c8a96e; text-decoration: none; }
    .logout-link a:hover { text-decoration: underline; }
</style>
@endpush

@section('content')

    <div class="banner-header section-padding back-position-center valign bg-img bg-fixed"
         data-overlay-dark="5"
         data-background="{{ asset('annapurna/img/slider/pokhara-valley-tour.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-12 caption mt-90">
                    <h6>Almost there</h6>
                    <h1>Verify <span>Email</span></h1>
                </div>
            </div>
        </div>
    </div>

    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="auth-card">
                        <div class="icon-wrap">
                            <i class="ti-email"></i>
                        </div>

                        <h2>Check your inbox</h2>
                        <p>Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just sent to <strong>{{ auth()->user()->email }}</strong>.</p>

                        @if(session('success'))
                        <div style="padding: 12px 16px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; margin-bottom: 20px; font-size: 13px; color: #155724;">
                            {{ session('success') }}
                        </div>
                        @endif

                        <p style="color: #888; font-size: 13px;">Didn't receive the email? Check your spam folder or click below to resend.</p>

                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn-submit">Resend Verification Email</button>
                        </form>

                        <div class="logout-link">
                            Wrong account? <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
                            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">@csrf</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
