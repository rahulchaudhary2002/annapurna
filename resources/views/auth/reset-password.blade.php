@extends('layouts.app')

@section('meta_title', 'Reset Password - ' . \App\Helpers\Cms::siteName())

@push('styles')
<style>
    .auth-section { padding: 80px 0; background: #f9f7f4; }
    .auth-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        padding: 40px 36px;
        max-width: 440px;
        margin: 0 auto;
    }
    .auth-card h2 { font-size: 24px; font-weight: 700; color: #1a1a2e; margin-bottom: 6px; }
    .auth-card p.subtitle { color: #888; margin-bottom: 28px; font-size: 14px; }
    .auth-card .form-group { margin-bottom: 18px; }
    .auth-card .form-group label { display: block; font-size: 13px; font-weight: 600; color: #444; margin-bottom: 6px; }
    .auth-card .form-group input {
        width: 100%;
        padding: 11px 14px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        color: #333;
        font-family: 'Poppins', sans-serif;
        transition: border-color 0.2s;
    }
    .auth-card .form-group input:focus { outline: none; border-color: #c8a96e; }
    .auth-card .form-group input.is-invalid { border-color: #e74c3c; }
    .invalid-feedback { color: #e74c3c; font-size: 12px; margin-top: 4px; display: block; }
    .auth-card .btn-submit {
        width: 100%;
        background: #c8a96e;
        color: #fff;
        border: none;
        padding: 12px;
        border-radius: 5px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 8px;
        transition: background 0.2s;
        font-family: 'Poppins', sans-serif;
    }
    .auth-card .btn-submit:hover { background: #b8924a; }
</style>
@endpush

@section('content')

    <div class="banner-header section-padding back-position-center valign bg-img bg-fixed"
         data-overlay-dark="5"
         data-background="{{ asset('annapurna/img/slider/pokhara-valley-tour.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-12 caption mt-90">
                    <h6>Set a new password</h6>
                    <h1>Reset <span>Password</span></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Reset Password</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="auth-card">
                        <h2>Set New Password</h2>
                        <p class="subtitle">Choose a new password for your account.</p>

                        @if($errors->any())
                        <div style="padding: 12px 16px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; margin-bottom: 20px; font-size: 13px; color: #721c24;">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email"
                                       value="{{ old('email', $email ?? '') }}"
                                       placeholder="your@email.com"
                                       class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                                       required>
                                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" id="password" name="password"
                                       placeholder="Minimum 8 characters"
                                       class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                                       required>
                                @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm New Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       placeholder="Repeat new password"
                                       required>
                            </div>

                            <button type="submit" class="btn-submit">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
