@extends('layouts.app')

@section('meta_title', 'My Account - ' . \App\Helpers\Cms::siteName())
@section('meta_description', 'Create a free account to manage your business listing on ' . \App\Helpers\Cms::siteName())

@push('styles')
<style>
.auth-page {
    padding: 60px 0 80px;
    background: #fff;
    min-height: 70vh;
}
.auth-page-heading { margin-bottom: 36px; }
.auth-page-heading .breadcrumb-wrap { font-size: 0.82rem; color: #888; margin-bottom: 10px; }
.auth-page-heading .breadcrumb-wrap a { color: #888; text-decoration: none; }
.auth-page-heading .breadcrumb-wrap a:hover { color: #333; }
.auth-page-heading h1 { font-size: 2rem; font-weight: 700; color: #2c1a0e; margin: 0; font-family: 'Poppins', sans-serif; }
.auth-col-card { background: #fff; border: 1px solid #e8e2da; border-radius: 12px; padding: 36px 32px 40px; height: 100%; }
.auth-col-card h2 { font-size: 1.35rem; font-weight: 700; color: #2c1a0e; margin-bottom: 28px; font-family: 'Poppins', sans-serif; }
.auth-field { margin-bottom: 18px; }
.auth-field label { display: block; font-size: 0.82rem; color: #333; margin-bottom: 6px; }
.auth-field label span.req { color: #a00; }
.auth-field input {
    width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 4px;
    font-size: 0.9rem; font-family: 'Poppins', sans-serif; color: #333; background: #fff; transition: border-color 0.2s, box-shadow 0.2s;
}
.auth-field input:focus { outline: none; border-color: #8b4513; box-shadow: 0 0 0 2px rgba(139,69,19,0.1); }
.auth-field input.is-invalid { border-color: #c00; }
.auth-field .field-error { color: #c00; font-size: 0.78rem; margin-top: 3px; display: block; }
.pw-wrap { position: relative; }
.pw-wrap input { padding-right: 40px; }
.pw-toggle { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #999; padding: 0; font-size: 0.95rem; }
.pw-toggle:hover { color: #555; }
.auth-check-row { display: flex; align-items: center; gap: 8px; margin-bottom: 18px; font-size: 0.85rem; color: #444; }
.auth-check-row input[type="checkbox"] { width: 15px; height: 15px; accent-color: #8b4513; cursor: pointer; flex-shrink: 0; }
.btn-auth { display: inline-block; background: #6b2d0e; color: #fff; border: none; padding: 10px 28px; border-radius: 4px; font-size: 0.9rem; font-weight: 600; cursor: pointer; font-family: 'Poppins', sans-serif; text-decoration: none; transition: background 0.2s; }
.btn-auth:hover { background: #8b3a14; color: #fff; }
.auth-lost-pw { display: block; margin-top: 14px; font-size: 0.83rem; color: #8b4513; text-decoration: none; }
.auth-lost-pw:hover { text-decoration: underline; }
.auth-hint { font-size: 0.83rem; color: #666; margin: 8px 0 16px; line-height: 1.5; }
.auth-alert { padding: 10px 14px; border-radius: 5px; margin-bottom: 16px; font-size: 0.83rem; }
.auth-alert-danger  { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
.auth-alert-success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
@media (min-width: 768px) {
    .auth-cols-wrap { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; align-items: start; }
}
@media (max-width: 767px) {
    .auth-col-card { margin-bottom: 20px; padding: 28px 20px 32px; }
}
</style>
@endpush

@section('content')

{{-- Header Banner --}}
<div class="banner-header section-padding back-position-center valign bg-img bg-fixed"
     data-overlay-dark="5"
     data-background="{{ asset('annapurna/img/slider/pokhara-valley-tour.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-md-12 caption mt-90">
                <h6>Welcome</h6>
                <h1>My <span>Account</span></h1>
            </div>
        </div>
    </div>
</div>

<div class="auth-page">
    <div class="container">

        <div class="auth-page-heading">
            <div class="breadcrumb-wrap">
                <a href="{{ route('home') }}">Home</a> &nbsp;/&nbsp; My Account
            </div>
            <h1>My Account</h1>
        </div>

        <div class="auth-cols-wrap">

            {{-- ── LOGIN ── --}}
            <div class="auth-col-card">
                <h2>Login</h2>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="auth-field">
                        <label>Username or email address <span class="req">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="auth-field">
                        <label>Password <span class="req">*</span></label>
                        <div class="pw-wrap">
                            <input type="password" id="login-pw" name="password" required>
                            <button type="button" class="pw-toggle" onclick="togglePw('login-pw',this)" tabindex="-1">
                                <i class="ti-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="auth-check-row">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember" style="margin:0;cursor:pointer;">Remember me</label>
                    </div>

                    <button type="submit" class="btn-auth">Log in</button>
                    <a href="{{ route('password.request') }}" class="auth-lost-pw">Lost your password?</a>
                </form>
            </div>

            {{-- ── REGISTER ── --}}
            <div class="auth-col-card">
                <h2>Register</h2>

                @if($errors->any())
                <div class="auth-alert auth-alert-danger">
                    <ul style="margin:0;padding-left:18px;">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="auth-field">
                        <label>Email address <span class="req">*</span></label>
                        <input type="email" name="email"
                               value="{{ old('email') }}"
                               class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                               required autofocus>
                        @error('email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="auth-field">
                        <label>Full Name <span class="req">*</span></label>
                        <input type="text" name="name"
                               value="{{ old('name') }}"
                               class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                               required>
                        @error('name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="auth-field">
                        <label>Password <span class="req">*</span></label>
                        <div class="pw-wrap">
                            <input type="password" id="reg-pw" name="password"
                                   class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                                   required>
                            <button type="button" class="pw-toggle" onclick="togglePw('reg-pw',this)" tabindex="-1">
                                <i class="ti-eye"></i>
                            </button>
                        </div>
                        @error('password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="auth-field">
                        <label>Confirm Password <span class="req">*</span></label>
                        <input type="password" name="password_confirmation" required>
                    </div>

                    <div class="auth-field">
                        <label>Phone Number <small style="color:#aaa;font-weight:400;">(optional)</small></label>
                        <input type="text" name="phone"
                               value="{{ old('phone') }}"
                               placeholder="+977 98XXXXXXXX"
                               class="{{ $errors->has('phone') ? 'is-invalid' : '' }}">
                        @error('phone')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="auth-field">
                        <label>Country <small style="color:#aaa;font-weight:400;">(optional)</small></label>
                        <input type="text" name="country"
                               value="{{ old('country') }}"
                               placeholder="e.g. Nepal"
                               class="{{ $errors->has('country') ? 'is-invalid' : '' }}">
                        @error('country')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <p class="auth-hint">A link to set a new password will be sent to your email address.</p>

                    <button type="submit" class="btn-auth">Register</button>
                </form>
            </div>

        </div>{{-- /.auth-cols-wrap --}}
    </div>
</div>

@push('scripts')
<script>
function togglePw(id, btn) {
    const input = document.getElementById(id);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'ti-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'ti-eye';
    }
}
</script>
@endpush

@endsection
