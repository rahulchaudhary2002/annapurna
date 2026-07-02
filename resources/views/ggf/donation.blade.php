@extends('ggf.layouts.app')

@section('title', \App\Helpers\Cms::setting('ggf_donation_page_title', 'Donation') . ' | ' . \App\Helpers\Cms::setting('ggf_site_name', 'Guru Goraksanatha Foundation'))
@section('meta_description', \App\Helpers\Cms::setting('ggf_donation_meta_description', 'Support the sacred mission of Guru Goraksanatha Foundation through your generous donation.'))

@section('header')
    <header class="header-image ken-burn-center" data-parallax="true" data-natural-height="500" data-natural-width="1920" data-bleed="0" data-image-src="{{ asset('ggf/media/' . \App\Helpers\Cms::setting('ggf_donation_header_image', 'hd-41.png')) }}" data-offset="0">
        <div class="container">
            <h1>{{ \App\Helpers\Cms::setting('ggf_donation_header_title', 'Donations') }}</h1>
            <h2>{{ \App\Helpers\Cms::setting('ggf_donation_header_subtitle', 'Every contribution strengthens') }}</h2>
            <ol class="breadcrumb">
                <li><a href="{{ route('ggf.home') }}">Home</a></li>
                <li>Donation</li>
            </ol>
        </div>
    </header>
@endsection

@section('content')
@php use App\Helpers\Cms; @endphp
<section class="section-base section-color">
    <div class="container">
        <div class="row">

            {{-- LEFT SIDE --}}
            <div class="col-lg-7">
                <h3>{{ Cms::setting('ggf_donation_page_title', 'Donation') }}</h3>
                <p><b>Support the Sacred Mission of Guru Goraksanatha Foundation</b></p>
                <p>{{ Cms::setting('ggf_donation_intro', 'Guru Goraksanatha Foundation is dedicated to preserving and promoting the ancient Goraksanatha tradition, uplifting spiritual heritage, and contributing to religious, cultural, social, and humanitarian development.') }}</p>
                <p>{{ Cms::setting('ggf_donation_support_text', 'Your generous support helps us continue this noble mission and serve thousands of devotees and visitors every year.') }}</p>

                <h4>{{ Cms::setting('ggf_donation_why_title', 'Why Your Donation Matters') }}</h4>

                @foreach(range(1, 5) as $s)
                    @php
                        $sTitle = Cms::setting("ggf_donation_section{$s}_title", '');
                        $sItems = array_filter(array_map('trim', explode("\n", Cms::setting("ggf_donation_section{$s}_items", ''))));
                    @endphp
                    @if($sTitle)
                        <h5>{{ $sTitle }}</h5>
                    @endif
                    @if($sItems)
                        <ul>
                            @foreach($sItems as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @endif
                @endforeach

                <h4>{{ Cms::setting('ggf_donation_helps_title', 'How Your Support Helps') }}</h4>
                @php $helpsItems = array_filter(array_map('trim', explode("\n", Cms::setting('ggf_donation_helps_items', '')))); @endphp
                @if($helpsItems)
                    <ul>
                        @foreach($helpsItems as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                @endif

                <p><b>{{ Cms::setting('ggf_donation_sewa_text', 'Each rupee you give becomes a part of sewa.') }}</b></p>

                <h4>{{ Cms::setting('ggf_donation_contribution_title', 'Make a Contribution') }}</h4>
                @php $contribItems = array_filter(array_map('trim', explode("\n", Cms::setting('ggf_donation_contribution_items', '')))); @endphp
                @if($contribItems)
                    <ul>
                        @foreach($contribItems as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                @endif
                <p>{{ Cms::setting('ggf_donation_transparency_text', 'All donations are utilized with full transparency and accountability.') }}</p>

                <h4>{{ Cms::setting('ggf_donation_gratitude_title', 'Gratitude') }}</h4>
                <p>{{ Cms::setting('ggf_donation_gratitude', 'Your generosity is not only a financial contribution—it is a spiritual offering. May Guru Goraksanatha bless you and your family with health, peace, and prosperity.') }}</p>
            </div>

            {{-- RIGHT SIDEBAR --}}
            <div class="col-lg-5">
                <hr class="space visible-sm" />

                <div class="fixed-area" data-offset="80">
                    {{-- QR Code --}}
                    <div class="menu-inner boxed-area qr-wrapper">
                        <h4 class="qr-title">{{ Cms::setting('ggf_donation_qr_title', 'Scan to Donate') }}</h4>
                        @php $qrCode = Cms::setting('ggf_donation_qr_code'); @endphp
                        @if($qrCode)
                            <img src="{{ Cms::imageUrl($qrCode) }}" alt="Donation QR Code" class="qr-image">
                        @else
                            <img src="{{ asset('ggf/media/qr-code.jpg') }}" alt="Donation QR Code" class="qr-image">
                        @endif
                        <p class="qr-text">{{ Cms::setting('ggf_site_name', 'Guru Goraksanatha Foundation') }}</p>
                    </div>
                </div>

                <hr class="space-sm" />

                {{-- Bank Details --}}
                <div class="menu-inner menu-inner-vertical boxed-area">
                    <h4 class="text-center">{{ Cms::setting('ggf_donation_bank_title', 'Bank Details') }}</h4>
                    <ul class="text-list text-list-bold">
                        <li><b>Foundation:</b><p>{{ Cms::setting('ggf_bank_foundation', 'Guru Goraksanatha Foundation') }}</p></li>
                        <li><b>Bank Name:</b><p>{{ Cms::setting('ggf_bank_name', 'Rastriya Banijya Bank Limited') }}</p></li>
                        <li><b>Account Number:</b><p>{{ Cms::setting('ggf_bank_account', '1130100004700001') }}</p></li>
                        <li><b>Branch:</b><p>{{ Cms::setting('ggf_bank_branch', 'Kathmandu') }}</p></li>
                    </ul>
                </div>

                <hr class="space-sm" />

                {{-- Donation Form --}}
                <div class="boxed-area light" style="padding: 25px; background:#fff; border-radius:10px;">
                    <h4 class="text-center">{{ Cms::setting('ggf_donation_form_title', 'Upload Donation Slip') }}</h4>

                    @if(session('donation_success'))
                        <div class="alert alert-success">{{ session('donation_success') }}</div>
                    @endif

                    <form action="{{ route('ggf.donation.submit') }}" method="POST" enctype="multipart/form-data" class="form-box">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <p>{{ Cms::setting('ggf_donation_form_name_label', 'Your Name') }}</p>
                                <input id="name" name="name" type="text" class="input-text" value="{{ old('name') }}" required>
                                @error('name')<div class="alert alert-warning" style="margin-top:5px;">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-lg-12">
                                <p>{{ Cms::setting('ggf_donation_form_phone_label', 'Phone') }}</p>
                                <input id="phone" name="phone" type="text" class="input-text" value="{{ old('phone') }}" required>
                                @error('phone')<div class="alert alert-warning" style="margin-top:5px;">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-lg-12">
                                <p>{{ Cms::setting('ggf_donation_form_amount_label', 'Amount Donated') }}</p>
                                <input id="amount" name="amount" type="number" class="input-text" value="{{ old('amount') }}" required>
                                @error('amount')<div class="alert alert-warning" style="margin-top:5px;">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-lg-12">
                                <p>{{ Cms::setting('ggf_donation_form_screenshot_label', 'Upload Screenshot (Image / PDF)') }}</p>
                                <input id="screenshot" name="screenshot" type="file" class="input-text" accept="image/*,application/pdf" required>
                                @error('screenshot')<div class="alert alert-warning" style="margin-top:5px;">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <button class="btn btn-xs btn-primary btn-block" type="submit" style="margin-top:10px;">
                            {{ Cms::setting('ggf_donation_form_submit_label', 'Submit Donation') }}
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</section>
@endsection
