@extends('ggf.layouts.app')

@section('title', 'Upcoming Programs | ' . \App\Helpers\Cms::setting('ggf_site_name', 'Guru Goraksanatha Foundation'))
@section('meta_description', 'Upcoming programs and events by Guru Goraksanatha Foundation - Education, Health, Community Development.')

@section('header')
    <header class="header-image ken-burn-center" data-parallax="true" data-natural-height="500" data-natural-width="1920" data-bleed="0" data-image-src="{{ asset('ggf/media/hd-41.png') }}" data-offset="0">
        <div class="container">
            <h1>Upcoming Programs</h1>
            <h2>Featured Events</h2>
            <ol class="breadcrumb">
                <li><a href="{{ route('ggf.home') }}">Home</a></li>
                <li>Upcoming Programs</li>
            </ol>
        </div>
    </header>
@endsection

@section('content')
<section class="section-base section-color">
    <div class="container">
        @if($categories->count() && $postsByCategory)
            <div class="tab-box" data-tab-anima="fade-in">
                <ul class="tab-nav">
                    @foreach($categories as $category)
                        <li class="{{ $loop->first ? 'active' : '' }}">
                            <a href="#">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>

                @foreach($categories as $category)
                    <div class="panel {{ $loop->first ? 'active' : '' }}">
                        <div class="grid-list" data-columns="2" data-columns-lg="1">
                            <div class="grid-box">
                                @forelse($postsByCategory[$category->id] ?? [] as $post)
                                    <div class="grid-item">
                                        <div class="cnt-box cnt-box-side boxed">
                                            @if($post->featured_image)
                                                <a href="#" class="img-box">
                                                    <img src="{{ \App\Helpers\Cms::imageUrl($post->featured_image) }}" alt="{{ $post->title }}" />
                                                </a>
                                            @else
                                                <a href="#" class="img-box">
                                                    <img src="{{ asset('ggf/media/image-14.jpg') }}" alt="{{ $post->title }}" />
                                                </a>
                                            @endif
                                            <div class="caption">
                                                <h2>{{ $post->title }}</h2>
                                                @if($post->category)
                                                    <div class="extra-field">{{ $post->category->name }}</div>
                                                @endif
                                                <p>{{ $post->excerpt }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="grid-item">
                                        <div class="cnt-box cnt-box-side boxed">
                                            <a href="#" class="img-box"><img src="{{ asset('ggf/media/image-14.jpg') }}" alt="" /></a>
                                            <div class="caption">
                                                <h2>Programs Coming Soon</h2>
                                                <div class="extra-field">{{ $category->name }}</div>
                                                <p>New programs in this category will be announced soon. Check back for updates.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Fallback with static tabs --}}
            <div class="tab-box" data-tab-anima="fade-in">
                <ul class="tab-nav">
                    <li class="active"><a href="#">Education Programs</a></li>
                    <li><a href="#">Health &amp; Medical Camps</a></li>
                    <li><a href="#">Community Development</a></li>
                    <li><a href="#">Environmental Initiatives</a></li>
                </ul>

                @php
                    $staticPrograms = [
                        'Education Programs' => [
                            ['title' => 'Scholarships for Students', 'location' => 'Nepal', 'desc' => 'Providing financial aid and scholarships to underprivileged students to continue their education.'],
                            ['title' => 'School Supplies Distribution', 'location' => 'Local Schools', 'desc' => 'Distributing books, stationery, and learning materials to children in rural and underserved communities.'],
                            ['title' => 'Adult Literacy Programs', 'location' => 'Community Centers', 'desc' => 'Offering literacy classes for adults to empower them with reading, writing, and basic education skills.'],
                            ['title' => 'Vocational Training', 'location' => 'Youth Development', 'desc' => 'Providing skill-based training and workshops to help youth gain employable skills and self-reliance.'],
                        ],
                        'Health & Medical Camps' => [
                            ['title' => 'Free Health Checkups', 'location' => 'Local Clinics', 'desc' => 'Organizing free medical checkups for communities with limited access to healthcare services.'],
                            ['title' => 'Vaccination Drives', 'location' => 'Rural Areas', 'desc' => 'Conducting vaccination camps to protect children and adults from preventable diseases.'],
                        ],
                        'Community Development' => [
                            ['title' => 'Women Empowerment Programs', 'location' => 'Nepal Communities', 'desc' => 'Supporting women through skill training, leadership workshops, and small business guidance.'],
                            ['title' => 'Youth Leadership Workshops', 'location' => 'Rural & Urban Areas', 'desc' => 'Engaging youth in community development through training, mentorship, and social initiatives.'],
                        ],
                        'Environmental Initiatives' => [
                            ['title' => 'Tree Plantation Drives', 'location' => 'Local Communities', 'desc' => 'Organizing tree planting events to improve the environment and promote sustainability.'],
                            ['title' => 'Clean-up Campaigns', 'location' => 'Rivers & Public Areas', 'desc' => 'Conducting clean-up activities to maintain public spaces and preserve natural resources.'],
                        ],
                    ];
                    $programImages = ['image-14.jpg', 'image-3.jpg', 'image-9.jpg', 'image-8.jpg'];
                @endphp

                @foreach($staticPrograms as $tabName => $items)
                    <div class="panel {{ $loop->first ? 'active' : '' }}">
                        <div class="grid-list" data-columns="2" data-columns-lg="1">
                            <div class="grid-box">
                                @foreach($items as $i => $item)
                                    <div class="grid-item">
                                        <div class="cnt-box cnt-box-side boxed">
                                            <a href="#" class="img-box">
                                                <img src="{{ asset('ggf/media/' . $programImages[$i % 4]) }}" alt="{{ $item['title'] }}" />
                                            </a>
                                            <div class="caption">
                                                <h2>{{ $item['title'] }}</h2>
                                                <div class="extra-field">{{ $item['location'] }}</div>
                                                <p>{{ $item['desc'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('ggf/themekit/scripts/pagination.min.js') }}" defer></script>
@endpush
