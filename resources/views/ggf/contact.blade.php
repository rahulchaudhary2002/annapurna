@extends('ggf.layouts.app')

@section('title', 'Contact Us | ' . \App\Helpers\Cms::setting('ggf_site_name', 'Guru Goraksanatha Foundation'))
@section('meta_description', 'Contact Guru Goraksanatha Foundation - Address, email, phone, and contact form.')

@section('content')
<section class="section-map section-map-right">
    <div class="google-map">
        <iframe
            src="{{ \App\Helpers\Cms::setting('ggf_map_embed', 'https://www.google.com/maps?q=28.0044263,83.4093251&z=15&output=embed') }}"
            width="100%"
            height="100%"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
    <div class="container">
        <div class="title">
            <h2>Our contacts</h2>
            <p>Information</p>
        </div>
        <ul class="text-list text-list-line">
            <li><b>Address</b><hr /><p>{{ \App\Helpers\Cms::setting('ggf_contact_address', 'Tripureshwor, Kathmandu | Gorkha, Nepal') }}</p></li>
            <li><b>Web</b><hr /><p>{{ \App\Helpers\Cms::setting('ggf_contact_web', 'www.ggf.org.np') }}</p></li>
            <li><b>Email</b><hr /><p>{{ \App\Helpers\Cms::setting('ggf_contact_email', 'gurugoraksanathafoundation@gmail.com') }}</p></li>
            <li><b>Phone</b><hr /><p>{{ \App\Helpers\Cms::setting('ggf_contact_phone', '+977-9851362653') }}</p></li>
        </ul>
        <hr class="space-sm" />
        <div class="icon-links icon-social icon-links-grid social-colors">
            @if(\App\Helpers\Cms::setting('ggf_social_facebook'))
                <a href="{{ \App\Helpers\Cms::setting('ggf_social_facebook') }}" class="facebook"><i class="icon-facebook"></i></a>
            @endif
            @if(\App\Helpers\Cms::setting('ggf_social_youtube'))
                <a href="{{ \App\Helpers\Cms::setting('ggf_social_youtube') }}" class="youtube"><i class="icon-youtube"></i></a>
            @endif
        </div>
    </div>
</section>

<section class="section-base">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="title">
                    <h2>Contact us here</h2>
                    <p>Write us</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success" style="background:#d4edda;padding:15px;border-radius:5px;margin-bottom:20px;color:#155724;">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('ggf.contact.submit') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <p>Name</p>
                            <input name="name" placeholder="" type="text" class="input-text" required value="{{ old('name') }}">
                            @error('name')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
                        </div>
                        <div class="col-lg-6">
                            <p>Email</p>
                            <input name="email" placeholder="" type="email" class="input-text" required value="{{ old('email') }}">
                            @error('email')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <p>Message</p>
                    <textarea name="message" class="input-textarea" placeholder="" required>{{ old('message') }}</textarea>
                    @error('message')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
                    <button class="btn btn-xs" type="submit">Send message</button>
                </form>
            </div>
            <div class="col-lg-6">
                <hr class="space visible-md" />
                <div class="title">
                    <h2>When are we open?</h2>
                    <p>Information</p>
                </div>
                <p>{{ \App\Helpers\Cms::setting('ggf_about_short', 'Guru Goraksanatha Foundation is a non-profit spiritual and cultural organization dedicated to preserving and promoting the divine legacy of Guru Goraksanatha, the Nath tradition, and the sacred heritage of Devbhumi Gorkha, Nepal.') }}</p>
                <table class="table table-border table-time">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Morning</th>
                            <th>Afternoon</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Sunday – Friday</td><td>8am – 12pm</td><td>5pm – 9pm</td></tr>
                        <tr><td>Saturday</td><td>Closed</td><td>5pm – 9pm</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
