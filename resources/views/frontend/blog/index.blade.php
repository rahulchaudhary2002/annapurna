@extends('layouts.app')

@section('meta_title', \App\Helpers\Cms::setting('blog_meta_title', 'Blog - Annapurna Region'))
@section('meta_description', \App\Helpers\Cms::setting('blog_meta_description', 'Latest news, guides and travel articles from the Annapurna Region. Trekking tips, destination guides, and travel inspiration.'))

@section('content')

    <x-breadcrumb title="Blog" subtitle="Annapurna Region Travel Guides & News" />

    <section class="blog-section section-padding">
        <div class="container">

            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-subtitle"><span>{{ \App\Helpers\Cms::setting('blog_subtitle', 'Travel Insights') }}</span></div>
                    <div class="section-title">Latest <span>Articles</span></div>
                </div>
            </div>

            {{-- Blog Type Tabs --}}
            @php $activeType = request('type', ''); @endphp
            <div class="row mb-30">
                <div class="col-md-12 text-center">
                    <ul style="list-style:none;padding:0;display:inline-flex;gap:8px;flex-wrap:wrap;justify-content:center;">
                        @foreach(['' => 'All Posts', 'official' => 'Official', 'guest' => 'Guest Blogs', 'business' => 'Business Blogs'] as $type => $label)
                        <li>
                            <a href="{{ route('blog.index', $type ? ['type' => $type] : []) }}"
                               style="display:inline-block;padding:8px 22px;border-radius:30px;font-size:13px;font-weight:600;text-decoration:none;
                                      {{ $activeType === $type ? 'background:#c8a96e;color:#fff;' : 'background:#f4f4f4;color:#555;' }}">
                                {{ $label }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="row">
                @forelse($posts as $post)
                <div class="col-md-4 col-sm-6 mb-30">
                    <div class="item">
                        <a href="{{ route('blog.show', $post->slug) }}">
                            <div class="position-re o-hidden">
                                @if($post->featured_image)
                                    <img src="{{ \App\Helpers\Cms::imageUrl($post->featured_image) }}" alt="{{ $post->title }}">
                                @else
                                    <img src="{{ asset('annapurna/img/slider/annapurna-region.png') }}" alt="{{ $post->title }}">
                                @endif
                            </div>
                            @php
                                $typeLabel = match($post->blog_type ?? 'official') {
                                    'guest'    => 'Guest',
                                    'business' => 'Business',
                                    default    => 'Official',
                                };
                            @endphp
                            <span class="category">
                                @if($post->category)
                                    <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}">{{ $post->category->name }}</a>
                                @else
                                    <a href="{{ route('blog.index', ['type' => $post->blog_type ?? 'official']) }}">{{ $typeLabel }}</a>
                                @endif
                            </span>
                            <div class="con">
                                <h5><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h5>
                                @if($post->excerpt)
                                <p>{{ Str::limit($post->excerpt, 120) }}</p>
                                @endif
                                <div class="line"></div>
                                <div class="info">
                                    <span>
                                        <i class="ti-calendar"></i>
                                        {{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('M d, Y') : '' }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-md-12 text-center">
                    <p>No articles published yet. Check back soon!</p>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if(method_exists($posts, 'links') && $posts->hasPages())
            <div class="row">
                <div class="col-md-12 text-center mt-30">
                    <div class="blog-pagination-wrap">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
            @endif

        </div>
    </section>

@endsection
