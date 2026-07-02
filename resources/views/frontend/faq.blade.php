@extends('layouts.app')

@section('meta_title', \App\Helpers\Cms::setting('faq_meta_title', 'FAQ - Annapurna Region'))
@section('meta_description', \App\Helpers\Cms::setting('faq_meta_description', 'Frequently asked questions about trekking, tours, and travel in the Annapurna Region of Nepal.'))

@section('content')

    <x-breadcrumb title="Frequently Asked Questions" subtitle="Annapurna Region" />

    <section class="tours2 section-padding">
        <div class="container">

            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>{{ \App\Helpers\Cms::setting('faq_subtitle', 'Get Answers') }}</span></div>
                    <div class="section-title">Frequently Asked <span>Questions</span></div>
                    @if(\App\Helpers\Cms::setting('faq_description'))
                    <p>{{ \App\Helpers\Cms::setting('faq_description') }}</p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-10 offset-md-1">

                    @if($faqs->count())
                    <ul class="accordion-box clearfix">
                        @foreach($faqs as $faq)
                        <li class="accordion block">
                            <div class="acc-btn">{{ $faq->question }}</div>
                            <div class="acc-content">
                                <div class="content">
                                    <div class="text">
                                        <p>{!! $faq->answer !!}</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <div class="text-center">
                        <p>No FAQs available at the moment. Please check back soon or <a href="{{ route('contact') }}">contact us</a> directly.</p>
                    </div>
                    @endif

                </div>
            </div>

            {{-- CTA --}}
            <div class="row justify-content-center mt-50">
                <div class="col-md-8 text-center">
                    <h4>Still have questions?</h4>
                    <p>We are happy to help you plan your Annapurna adventure. Get in touch with our team.</p>
                    <div class="butn-dark mt-20">
                        <a href="{{ route('contact') }}"><span>Contact Us <i class="ti-arrow-right"></i></span></a>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
