@extends('ggf.layouts.app')

@section('title', \App\Helpers\Cms::setting('ggf_services_page_title', 'Services') . ' | ' . \App\Helpers\Cms::setting('ggf_site_name', 'Guru Goraksanatha Foundation'))
@section('meta_description', \App\Helpers\Cms::setting('ggf_services_meta_description', 'Our community programs and services - Education, Health, Welfare, and Cultural Preservation.'))

@section('header')
    <header class="header-image ken-burn-center" data-parallax="true" data-natural-height="500" data-natural-width="1920" data-bleed="0" data-image-src="{{ asset('ggf/media/' . \App\Helpers\Cms::setting('ggf_services_header_image', 'hd-4.jpg')) }}" data-offset="0">
        <div class="container">
            <h1>{{ \App\Helpers\Cms::setting('ggf_services_header_title', 'Services') }}</h1>
            <h2>{{ \App\Helpers\Cms::setting('ggf_services_header_subtitle', 'Services') }}</h2>
            <ol class="breadcrumb">
                <li><a href="{{ route('ggf.home') }}">Home</a></li>
                <li>Services</li>
            </ol>
        </div>
    </header>
@endsection

@section('content')
@php use App\Helpers\Cms; @endphp
<section class="section-base section-color">
    <div class="container">
        <div class="row">

            {{-- LEFT SIDEBAR --}}
            <div class="col-lg-4">
                <div class="fixed-area" data-offset="80">
                    <div class="menu-inner menu-inner-vertical boxed-area">
                        <ul>
                            @forelse($services as $service)
                                <li class="{{ $loop->first ? 'active' : '' }}">
                                    <a href="{{ route('ggf.services.show', $service->slug) }}">{{ $service->title }}</a>
                                </li>
                            @empty
                                <li class="active"><a href="#">Community Welfare Programs</a></li>
                                <li><a href="#">Education Support</a></li>
                                <li><a href="#">Health &amp; Medical Camps</a></li>
                                <li><a href="#">Women Empowerment</a></li>
                                <li><a href="#">Youth Development</a></li>
                                <li><a href="#">Skill Training</a></li>
                                <li><a href="#">Cultural Preservation</a></li>
                            @endforelse
                        </ul>
                    </div>

                    <hr class="space-sm" />

                    <div class="boxed-area light">
                        <ul class="text-list text-list-bold">
                            <li><b>Address:</b><p>{{ Cms::setting('ggf_contact_address', 'Kathmandu, Nepal') }}</p></li>
                            <li><b>Email:</b><p>{{ Cms::setting('ggf_contact_email', 'gurugoraksanathafoundation@gmail.com') }}</p></li>
                            <li><b>Phone:</b><p>{{ Cms::setting('ggf_contact_phone', '+977-9851362653') }}</p></li>
                            <li><b>Office Hours</b><p>{{ Cms::setting('ggf_contact_hours', '10 AM – 5 PM, Sun–Fri') }}</p></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- RIGHT CONTENT --}}
            <div class="col-lg-8">
                <hr class="space visible-md" />
                <h3>{{ Cms::setting('ggf_services_section_title', 'Our Services') }}</h3>
                <p>{{ Cms::setting('ggf_services_description', 'Guru Goraksanatha Foundation is committed to uplifting communities through meaningful social work, empowerment, and development programs. Our services are designed to support children, youth, women, senior citizens, and marginalized groups by providing education, health care, training, and emergency support.') }}</p>

                <hr class="space" />
                <h3>{{ Cms::setting('ggf_services_how_title', 'How We Work') }}</h3>
                <hr class="space-sm" />

                <div class="box-steps">
                    <div class="step-item">
                        <span>1</span>
                        <div class="content">
                            <h3>{{ Cms::setting('ggf_services_step1_title', 'Community Outreach') }}</h3>
                            <div><p>{{ Cms::setting('ggf_services_step1_text', 'Our team visits communities, identifies real needs, and listens to the voices of people who require support. This helps us design meaningful and practical programs.') }}</p></div>
                        </div>
                    </div>
                    <div class="step-item">
                        <span>2</span>
                        <div class="content">
                            <h3>{{ Cms::setting('ggf_services_step2_title', 'Program Planning') }}</h3>
                            <div><p>{{ Cms::setting('ggf_services_step2_text', 'After identifying challenges, we create structured plans for education support, health camps, skill training, relief distribution, and welfare activities.') }}</p></div>
                        </div>
                    </div>
                    <div class="step-item">
                        <span>3</span>
                        <div class="content">
                            <h3>{{ Cms::setting('ggf_services_step3_title', 'Program Execution') }}</h3>
                            <div><p>{{ Cms::setting('ggf_services_step3_text', 'Each project is executed through volunteers, social workers, trainers, doctors, and local community leaders to ensure maximum impact.') }}</p></div>
                        </div>
                    </div>
                </div>

                <hr class="space" />
                <h3>{{ Cms::setting('ggf_services_impact_title', 'Impact Overview') }}</h3>
                <hr class="space-sm" />

                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-7">
                        @php
                            $p1Val = (int) Cms::setting('ggf_services_progress1_value', '70');
                            $p2Val = (int) Cms::setting('ggf_services_progress2_value', '95');
                            $p3Val = (int) Cms::setting('ggf_services_progress3_value', '85');
                        @endphp
                        <div class="progress-bar">
                            <h4>{{ Cms::setting('ggf_services_progress1_label', 'Communities Reached') }}</h4>
                            <div>
                                <div data-progress="{{ $p1Val }}">
                                    <span class="counter" data-to="{{ $p1Val }}" data-speed="2000" data-unit="%">{{ $p1Val }}%</span>
                                </div>
                            </div>
                        </div>

                        <hr class="space-sm" />

                        <div class="progress-bar">
                            <h4>{{ Cms::setting('ggf_services_progress2_label', 'Program Success Rate') }}</h4>
                            <div>
                                <div data-progress="{{ $p2Val }}">
                                    <span class="counter" data-to="{{ $p2Val }}" data-speed="2000" data-unit="%">{{ $p2Val }}%</span>
                                </div>
                            </div>
                        </div>

                        <hr class="space-sm" />

                        <div class="progress-bar">
                            <h4>{{ Cms::setting('ggf_services_progress3_label', 'Beneficiaries Supported') }}</h4>
                            <div>
                                <div data-progress="{{ $p3Val }}">
                                    <span class="counter" data-to="{{ $p3Val }}" data-speed="2000" data-unit="%">{{ $p3Val }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-5 no-margin-md align-right align-left-sm">
                        <hr class="space visible-xs" />
                        @php
                            $circleVal   = (int) Cms::setting('ggf_services_circle_value', '60');
                            $circleCount = (int) Cms::setting('ggf_services_circle_counter', '35');
                        @endphp
                        <div class="progress-circle" data-color="#03bfcb" data-thickness="5" data-progress="{{ $circleVal }}" data-size="185" data-size-sm="185" data-linecap="round" data-options="emptyFill:#004767">
                            <div class="content">
                                <h4>{{ Cms::setting('ggf_services_circle_label', 'Community Engagement') }}</h4>
                                <div class="counter" data-to="{{ $circleCount }}" data-speed="2000" data-unit="%">{{ $circleCount }}%</div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="space" />
                <h3>{{ Cms::setting('ggf_services_provide_title', 'What We Provide') }}</h3>
                <p>{{ Cms::setting('ggf_services_provide_text', 'Through our initiatives, we ensure that individuals and communities receive meaningful support in the form of education materials, medical checkups, emergency relief, trainings, and long-term development opportunities.') }}</p>

                <hr class="space-sm" />

                <div class="grid-list" data-columns="3" data-columns-lg="2">
                    <div class="grid-box">
                        @foreach(range(1, 6) as $i)
                            <div class="grid-item">
                                <div class="icon-box icon-box-left">
                                    <i class="{{ Cms::setting("ggf_services_provide_item{$i}_icon", 'im-pen') }}"></i>
                                    <div class="caption">
                                        <h3>{{ Cms::setting("ggf_services_provide_item{$i}_title", '') }}</h3>
                                        <p>{{ Cms::setting("ggf_services_provide_item{$i}_text", '') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>{{-- END RIGHT SIDE --}}

        </div>
    </div>
</section>
@endsection
