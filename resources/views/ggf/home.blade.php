@extends('ggf.layouts.app')

@section('title', \App\Helpers\Cms::setting('ggf_site_name', 'Guru Goraksanatha Foundation'))
@section('meta_description', \App\Helpers\Cms::setting('ggf_meta_description', 'Guru Goraksanatha Foundation - A non-profit spiritual and cultural organization'))

@section('content')

{{-- Hero Slider --}}
<section class="section-base section-color">
    <div class="container">
        @if($sliders->count())
            <ul class="slider arrows-inner-right" data-options="arrows:true,nav:false">
                @foreach($sliders as $slider)
                    <li>
                        <a href="{{ $slider->button1_url ?: '#' }}" class="media-box media-box-reveal">
                            <img alt="{{ $slider->title }}" src="{{ \App\Helpers\Cms::imageUrl($slider->image, asset('ggf/media/gorkha-wide-large.jpg')) }}">
                            <div class="caption">
                                <h2>{{ $slider->title }}</h2>
                                @if($slider->description)
                                    <p>{{ $slider->description }}</p>
                                @endif
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <ul class="slider arrows-inner-right" data-options="arrows:true,nav:false">
                <li>
                    <a href="{{ route('ggf.about') }}" class="media-box media-box-reveal">
                        <img alt="Gorkha" src="{{ asset('ggf/media/gorkha-wide-large.jpg') }}">
                        <div class="caption">
                            <h2>Gorkha</h2>
                            <p>Gorkha is one of Nepal's most historically significant and culturally rich regions.</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('ggf.page', 'about-guru-goraksanatha') }}" class="media-box media-box-reveal">
                        <img alt="Guru Goraksanatha" src="{{ asset('ggf/media/guru-gorakh-slider.jpg') }}">
                        <div class="caption">
                            <h2>Guru Goraksanatha</h2>
                            <p>One of the greatest yogic masters and Siddha saints of the Nath Sampradaya.</p>
                        </div>
                    </a>
                </li>
            </ul>
        @endif
        <hr class="space" />
    </div>
</section>

{{-- About Cards Grid --}}
<section class="section-base section-overflow-top">
    <div class="container">
        <div class="grid-list" data-columns="3" data-columns-md="2" data-columns-sm="1" data-anima="fade-bottom" data-time="1000">
            <div class="grid-box">
                <div class="grid-item">
                    <div class="cnt-box cnt-box-info boxed">
                        <a href="{{ route('ggf.page', 'about-guru-goraksanatha') }}" class="img-box">
                            <img src="{{ asset('ggf/media/abt-guru-goraksanatha.jpg') }}" alt="About Guru Goraksanatha" />
                        </a>
                        <div class="caption">
                            <h2>About Guru Goraksanatha</h2>
                            <p>{{ \App\Helpers\Cms::setting('ggf_card_guru_text', 'Guru Goraksanatha (also known as Guru Gorakhnath Baba) is one of the greatest yogic masters and Siddha saints of the Nath Sampradaya, a sacred Shaiva–yogic tradition rooted in Sanatan Dharma.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="grid-item">
                    <div class="cnt-box cnt-box-info boxed">
                        <a href="{{ route('ggf.page', 'about-naraharinath') }}" class="img-box">
                            <img src="{{ asset('ggf/media/yogi-narharinath.jpg') }}" alt="Naraharinath" />
                        </a>
                        <div class="caption">
                            <h2>Who is Naraharinath?</h2>
                            <p>{{ \App\Helpers\Cms::setting('ggf_card_naraharinath_text', 'Balbir Singh Thapa, born on Falgun 17, Bikram Sambat 1971 (1915 CE) in Kalikot to father Shri Lalit Singh Thapa and mother Smt. Gauradevi, was later initiated into the Nath tradition and became Yogi Naraharinath.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="grid-item">
                    <div class="cnt-box cnt-box-info boxed">
                        <a href="{{ route('ggf.page', 'about-gorkha') }}" class="img-box">
                            <img src="{{ asset('ggf/media/abt-gorkha.jpg') }}" alt="About Gorkha" />
                        </a>
                        <div class="caption">
                            <h2>About Gorkha</h2>
                            <p>{{ \App\Helpers\Cms::setting('ggf_card_gorkha_text', 'Gorkha is one of Nepal\'s most historically significant and culturally rich regions. Located in the western hills of Nepal, Gorkha is revered as the birthplace of modern Nepal and a sacred land deeply rooted in ..') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Who We Are --}}
        <div class="row row-fit-lg" data-anima="fade-bottom" data-time="1000">
            <div class="col-lg-6">
                <ul class="slider" data-options="arrows:true,nav:false">
                    <li>
                        <a class="img-box img-box-caption btn-video lightbox"
                            href="https://www.youtube.com/watch?v=SIW_pd50L1M"
                            data-lightbox-anima="fade-top">
                            <img src="{{ asset('ggf/media/image-3.jpg') }}" alt="Our Journey">
                            <span>Our Journey</span>
                        </a>
                    </li>
                    <li>
                        <a class="img-box img-box-caption lightbox" href="{{ asset('ggf/media/image-16.jpg') }}"
                            data-lightbox-anima="fade-top">
                            <img src="{{ asset('ggf/media/image-16.jpg') }}" alt="Community Service">
                            <span>Community Service</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-6">
                <div class="title">
                    <h2>{{ \App\Helpers\Cms::setting('ggf_about_title', 'Who We Are') }}</h2>
                    <p>{{ \App\Helpers\Cms::setting('ggf_about_subtitle', 'About the Foundation') }}</p>
                </div>
                <p>{{ \App\Helpers\Cms::setting('ggf_about_description', 'Guru Goraksanatha Foundation is a non-profit spiritual and cultural organization dedicated to preserving and promoting the divine legacy of Guru Goraksanatha, the Nath tradition, and the sacred heritage of Devbhumi Gorkha, Nepal.') }}</p>
                <p>{{ \App\Helpers\Cms::setting('ggf_about_description2', 'Our mission is rooted in the belief that the teachings of Guru Goraksanatha—yoga, discipline, devotion, self-realization, and service—are timeless sources of spiritual strength and global harmony.') }}</p>
            </div>
        </div>
    </div>
</section>

{{-- Services / Programs Overview --}}
<section class="section-base section-color">
    <div class="container">
        <div class="grid-list" data-columns="4" data-columns-md="2" data-columns-sm="1">
            <div class="grid-box">
                @forelse($services as $service)
                    <div class="grid-item">
                        <div class="cnt-box cnt-box-top-icon boxed">
                            @if($service->icon)
                                <i class="{{ $service->icon }}"></i>
                            @else
                                <i class="im-medal"></i>
                            @endif
                            <div class="caption">
                                <h2>{{ $service->title }}</h2>
                                <p>{{ $service->excerpt }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="grid-item">
                        <div class="cnt-box cnt-box-top-icon boxed">
                            <i class="im-monitor-phone"></i>
                            <div class="caption">
                                <h2>Education &amp; Awareness</h2>
                                <p>Promoting traditional knowledge, modern education, and holistic learning for all.</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid-item">
                        <div class="cnt-box cnt-box-top-icon boxed">
                            <i class="im-bar-chart2"></i>
                            <div class="caption">
                                <h2>Community Welfare</h2>
                                <p>Health camps, food relief, youth development, and empowerment programs.</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid-item">
                        <div class="cnt-box cnt-box-top-icon boxed">
                            <i class="im-medal"></i>
                            <div class="caption">
                                <h2>Cultural Preservation</h2>
                                <p>Preserving the teachings of Guru Gorakhnath, Nath traditions, and Nepali heritage.</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid-item">
                        <div class="cnt-box cnt-box-top-icon boxed">
                            <i class="im-business-man"></i>
                            <div class="caption">
                                <h2>Humanitarian Support</h2>
                                <p>Extending help to children, elderly, and vulnerable communities across Nepal.</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- Parallax Call to Action --}}
<section class="section-image light align-center ken-burn-center" data-parallax="scroll" data-image-src="{{ asset('ggf/media/hd-41.png') }}">
    <div class="container" data-anima="fade-bottom" data-time="1000">
        <a href="https://www.youtube.com/watch?v=SIW_pd50L1M" class="btn-video lightbox" data-lightbox-anima="fade-top"></a>
        <hr class="space" />
        <h2 class="width-650">{{ \App\Helpers\Cms::setting('ggf_cta_title', 'Join us to create a compassionate and resilient community') }}</h2>
        <hr class="space" />
        <p class="lead">{{ \App\Helpers\Cms::setting('ggf_cta_description', 'We are committed to honoring Guru Goraksanath\'s divine legacy by transforming Gorkha into a global spiritual destination. We invite devotees, scholars, institutions, and well-wishers from Nepal, India, and worldwide to join hands in this sacred mission.') }}</p>
        <hr class="space" />
    </div>
</section>

{{-- Current Major Projects --}}
<section class="section-base">
    <div class="container">
        <div class="row" data-anima="fade-bottom" data-time="1000">
            <div class="col-lg-6">
                <div class="title">
                    <h2>{{ \App\Helpers\Cms::setting('ggf_projects_title', 'Current Major Projects') }}</h2>
                    <p>{{ \App\Helpers\Cms::setting('ggf_projects_subtitle', 'What We Do') }}</p>
                </div>
            </div>
            <div class="col-lg-6 align-right align-left-md">
                <hr class="space-sm hidden-md" />
                <a href="{{ route('ggf.programs') }}" class="btn-text active">All programs</a>
            </div>
        </div>
        <hr class="space" />
        <div class="grid-list" data-columns="3" data-columns-md="2" data-columns-sm="1" data-anima="fade-bottom" data-time="1000">
            <div class="grid-box">
                @forelse($projects as $project)
                    <div class="grid-item">
                        <div class="cnt-box cnt-box-info boxed">
                            @if($project->client)
                                <div class="extra-field">{{ $project->client }}</div>
                            @endif
                            @if($project->featured_image)
                                <a href="#" class="img-box">
                                    <img src="{{ \App\Helpers\Cms::imageUrl($project->featured_image) }}" alt="{{ $project->title }}" />
                                </a>
                            @endif
                            <div class="caption">
                                <h2>{{ $project->title }}</h2>
                                @if($project->highlights && count($project->highlights))
                                    <div class="cnt-info">
                                        @foreach($project->highlights as $info)
                                            @if(isset($info['label'], $info['value']))
                                                <div><span>{{ $info['label'] }}</span><span>{{ $info['value'] }}</span></div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                                <p>{!! $project->excerpt !!}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="grid-item">
                        <div class="cnt-box cnt-box-info boxed">
                            <a href="#" class="img-box"><img src="{{ asset('ggf/media/gorkha-1975.png') }}" alt="Gorakshadham Gorkha" /></a>
                            <div class="caption">
                                <h2>Gorakshadham Gorkha</h2>
                                <div class="cnt-info">
                                    <div><span>Focus</span><span>Temple Complex</span></div>
                                    <div><span>Centers</span><span>Gurukul &amp; Yoga</span></div>
                                    <div><span>Facilities</span><span>Cultural Museums</span></div>
                                </div>
                                <p>Goraksadham Gorkha is the heart of our efforts—a multi-phase spiritual and cultural development project.</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid-item">
                        <div class="cnt-box cnt-box-info boxed">
                            <a href="#" class="img-box"><img src="{{ asset('ggf/media/gorkha-2025.png') }}" alt="Documentary Film" /></a>
                            <div class="caption">
                                <h2>Documentary Film</h2>
                                <div class="cnt-info">
                                    <div><span>Focus</span><span>Historic Connection</span></div>
                                    <div><span>Promote</span><span>Cultural Tourism</span></div>
                                    <div><span>Gorkha</span><span>Heritage Destination</span></div>
                                </div>
                                <p>"Goraksadham Gorkha – The Sacred Seat of Guru Goraksanatha" — A full-length international documentary.</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid-item">
                        <div class="cnt-box cnt-box-info boxed">
                            <div class="extra-field">On Going</div>
                            <a href="#" class="img-box"><img src="{{ asset('ggf/media/gorakh.png') }}" alt="Religious Programs" /></a>
                            <div class="caption">
                                <h2>Religious &amp; Social Programs</h2>
                                <div class="cnt-info">
                                    <div><span>Focus</span><span>Heritage preservation</span></div>
                                    <div><span>Coordinate</span><span>Nepal–India religious</span></div>
                                    <div><span>Area</span><span>Temple Support</span></div>
                                </div>
                                <p>Organizing spiritual events, Yagyas, and festivals, Rohth Management Program.</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- Testimonials --}}
@if($testimonials->count())
<section class="section-base section-color">
    <div class="container">
        <div class="row" data-anima="fade-bottom" data-time="1000">
            <div class="col-lg-12">
                <div class="title">
                    <h2>What our community says</h2>
                    <p>Voices from the field</p>
                </div>
                <hr class="space-xs" />
                <ul class="slider controls-top-right" data-options="type:carousel,arrows:false,nav:true,perView:3,perViewMd:2,perViewXs:1,gap:30,controls:out">
                    @foreach($testimonials as $testimonial)
                        <li>
                            <div class="cnt-box cnt-box-testimonials-bubble">
                                <p>"{{ $testimonial->content }}"</p>
                                <div class="thumb-bar">
                                    @if($testimonial->image)
                                        <img src="{{ \App\Helpers\Cms::imageUrl($testimonial->image) }}" alt="{{ $testimonial->name }}" />
                                    @else
                                        <img src="{{ asset('ggf/media/user-1.jpg') }}" alt="{{ $testimonial->name }}" />
                                    @endif
                                    <p>
                                        <span>{{ $testimonial->name }}</span>
                                        <span>{{ $testimonial->position }}{{ $testimonial->company ? ", {$testimonial->company}" : '' }}</span>
                                    </p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Why Partner With Us --}}
<section class="section-base">
    <div class="container">
        <div class="row align-items-center" data-anima="fade-bottom" data-time="1000">
            <div class="col-lg-6">
                <div class="title">
                    <h2>{{ \App\Helpers\Cms::setting('ggf_why_title', 'Why partner with us') }}</h2>
                    <p>{{ \App\Helpers\Cms::setting('ggf_why_subtitle', 'Trusted, transparent, impact-driven') }}</p>
                </div>
                <p>{{ \App\Helpers\Cms::setting('ggf_why_description', 'We operate with community-rooted approaches, transparent finances, and measurable outcomes. Projects are designed with local partners and monitored for real results.') }}</p>
                <hr class="space-sm" />
                <ul class="accordion-list">
                    <li>
                        <a href="#">Community-First Approach</a>
                        <div class="content">
                            <p>Every project is co-created with local leaders to ensure relevance, ownership, and sustainable outcomes for communities.</p>
                        </div>
                    </li>
                    <li>
                        <a href="#">Financial Transparency</a>
                        <div class="content">
                            <p>Regular reports and clear budgets shared with partners and donors. We ensure funds reach those who need them most.</p>
                        </div>
                    </li>
                    <li>
                        <a href="#">Professional Local Team</a>
                        <div class="content">
                            <p>A dedicated team with field experience, project management skills, and deep local knowledge.</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('ggf/media/gorkha-1975.png') }}" alt="Partners and community" />
            </div>
        </div>
    </div>
</section>

{{-- Impact Counters + Team --}}
<section class="section-base section-color section-overflow-top">
    <div class="container">
        @if($counters->count())
            <table class="table table-grid table-border align-left boxed-area table-6-md">
                <tbody>
                    <tr>
                        @foreach($counters as $counter)
                            <td>
                                <div class="counter counter-horizontal counter-icon">
                                    @if($counter->icon)<i class="{{ $counter->icon }} text-md"></i>@else<i class="im-globe text-md"></i>@endif
                                    <div>
                                        <h3>{{ $counter->label }}</h3>
                                        <div class="value">
                                            <span class="text-md" data-to="{{ $counter->numeric_value }}" data-speed="5000">{{ $counter->numeric_value }}</span>
                                            <span>{{ $counter->suffix }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        @else
            <table class="table table-grid table-border align-left boxed-area table-6-md">
                <tbody>
                    <tr>
                        <td><div class="counter counter-horizontal counter-icon"><i class="im-globe text-md"></i><div><h3>Communities</h3><div class="value"><span class="text-md" data-to="120" data-speed="5000">120</span><span>+</span></div></div></div></td>
                        <td><div class="counter counter-horizontal counter-icon"><i class="im-business-man text-md"></i><div><h3>Children Supported</h3><div class="value"><span class="text-md" data-to="4500" data-speed="5000">4,500</span><span>+</span></div></div></div></td>
                        <td><div class="counter counter-horizontal counter-icon"><i class="im-charger text-md"></i><div><h3>Projects</h3><div class="value"><span class="text-md" data-to="320" data-speed="5000">320</span><span>+</span></div></div></div></td>
                        <td><div class="counter counter-horizontal counter-icon"><i class="im-support text-md"></i><div><h3>Volunteers</h3><div class="value"><span class="text-md" data-to="850" data-speed="5000">850</span><span>+</span></div></div></div></td>
                    </tr>
                </tbody>
            </table>
        @endif

        <div class="row" data-anima="fade-bottom" data-time="1000">
            <div class="col-lg-3">
                <div class="title">
                    <h2>The big family</h2>
                    <p>Our team</p>
                </div>
                <p>{{ \App\Helpers\Cms::setting('ggf_team_description', 'The Guru Goraksanatha Foundation is led by a dedicated team of spiritual leaders, social volunteers, cultural researchers, and community mobilizers.') }}</p>
                <a href="{{ route('ggf.team') }}" class="btn-text active">Meet all members</a>
            </div>
            <div class="col-lg-9">
                <div class="grid-list" data-columns="3" data-columns-sm="2" data-columns-xs="1">
                    <div class="grid-box">
                        @foreach($teamMembers as $member)
                            <div class="grid-item">
                                <div class="cnt-box cnt-box-team">
                                    @if($member->image)
                                        <img src="{{ \App\Helpers\Cms::imageUrl($member->image) }}" alt="{{ $member->name }}" />
                                    @else
                                        <img src="{{ asset('ggf/media/user-1.jpg') }}" alt="{{ $member->name }}" />
                                    @endif
                                    <div class="caption">
                                        <h2>{{ $member->name }}</h2>
                                        <span>{{ $member->position }}</span>
                                        @if($member->facebook || $member->twitter || $member->instagram)
                                            <span class="icon-links">
                                                @if($member->facebook)<a href="{{ $member->facebook }}" target="_blank"><i class="icon-facebook"></i></a>@endif
                                                @if($member->twitter)<a href="{{ $member->twitter }}" target="_blank"><i class="icon-twitter"></i></a>@endif
                                                @if($member->instagram)<a href="{{ $member->instagram }}" target="_blank"><i class="icon-instagram"></i></a>@endif
                                            </span>
                                        @endif
                                        @if($member->bio)<p>{{ $member->bio }}</p>@endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="{{ asset('ggf/themekit/scripts/pagination.min.js') }}" defer></script>
@endpush
