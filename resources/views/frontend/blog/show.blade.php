@extends('layouts.app')

@section('meta_title', ($post->meta_title ?: $post->title) . ' - Annapurna Region')
@section('meta_description', $post->meta_description ?: Str::limit($post->excerpt, 160))
@section('og_title', $post->meta_title ?: $post->title)

@section('content')

    {{-- Header Banner --}}
    <div class="banner-header section-padding back-position-center valign bg-img bg-fixed"
         data-overlay-dark="5"
         data-background="{{ $post->featured_image ? \App\Helpers\Cms::imageUrl($post->featured_image) : asset('annapurna/img/slider/pokhara-valley-tour.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-9 text-left caption mt-90">
                    <h6>
                        @if($post->category)
                        <a href="{{ route('blog.index') }}">{{ is_string($post->category) ? $post->category : ($post->category->name ?? 'Blog') }}</a> /
                        @endif
                        {{ Str::limit($post->title, 60) }}
                    </h6>
                    <h1>{{ $post->title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>
                            <li class="breadcrumb-item active">{{ Str::limit($post->title, 40) }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Blog Post Content --}}
    <section class="section-padding">
        <div class="container">
            <div class="row">

                {{-- Main Content --}}
                <div class="col-md-8">
                    <div class="blog-post">

                        {{-- Post Meta --}}
                        <div class="blog-post-meta mb-30">
                            @if($post->category)
                            <span class="category-badge">
                                <i class="ti-tag"></i>
                                {{ is_string($post->category) ? $post->category : ($post->category->name ?? 'Blog') }}
                            </span>
                            @endif
                            @if($post->published_at)
                            <span class="date ml-15">
                                <i class="ti-calendar"></i>
                                {{ \Carbon\Carbon::parse($post->published_at)->format('F d, Y') }}
                            </span>
                            @endif
                        </div>

                        {{-- Featured Image --}}
                        @if($post->featured_image)
                        <div class="blog-post-img mb-30">
                            <img src="{{ \App\Helpers\Cms::imageUrl($post->featured_image) }}" alt="{{ $post->title }}" class="img-fluid">
                        </div>
                        @endif

                        {{-- Post Content --}}
                        <div class="blog-post-content">
                            {!! $post->content !!}
                        </div>

                        {{-- Tags / Social Share --}}
                        <div class="blog-post-footer mt-30 pt-20" style="border-top: 1px solid #eee;">
                            <div class="row align-items-center">
                                <div class="col-md-9">
                                    <span>Share: </span>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-primary ml-5">
                                        <i class="ti-facebook"></i> Facebook
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-info ml-5">
                                        <i class="ti-twitter"></i> Twitter
                                    </a>
                                    <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-success ml-5">
                                        <i class="ti-comment"></i> WhatsApp
                                    </a>
                                </div>
                                <div class="col-md-3 text-right">
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="document.getElementById('report-modal').style.display='flex'">
                                        <i class="ti-flag"></i> Report
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Report Modal --}}
                        <div id="report-modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center;">
                            <div style="background:#fff;padding:30px;border-radius:8px;width:90%;max-width:480px;">
                                <h5 class="mb-20">Report this post</h5>
                                <form method="POST" action="{{ route('posts.report', $post->slug) }}">
                                    @csrf
                                    <div class="form-group mb-15">
                                        <label>Reason</label>
                                        <select name="reason" class="form-control" required>
                                            <option value="">-- Select a reason --</option>
                                            <option value="spam">Spam</option>
                                            <option value="inappropriate">Inappropriate content</option>
                                            <option value="misleading">Misleading information</option>
                                            <option value="copyright">Copyright violation</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-15">
                                        <label>Details <small class="text-muted">(optional)</small></label>
                                        <textarea name="details" class="form-control" rows="3" maxlength="500"></textarea>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary"
                                            onclick="document.getElementById('report-modal').style.display='none'">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Submit Report</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="col-md-4">
                    <div class="sidebar">

                        {{-- Related Posts --}}
                        @if(isset($relatedPosts) && $relatedPosts->isNotEmpty())
                        <div class="widget clearfix">
                            <h4 class="widget-title">Related Articles</h4>
                            @foreach($relatedPosts as $related)
                            <div class="media mb-20">
                                <div class="mr-10">
                                    @if($related->featured_image)
                                    <a href="{{ route('blog.show', $related->slug) }}">
                                        <img src="{{ \App\Helpers\Cms::imageUrl($related->featured_image) }}" alt="{{ $related->title }}" style="width:80px; height:60px; object-fit:cover;">
                                    </a>
                                    @endif
                                </div>
                                <div class="media-body">
                                    <h6><a href="{{ route('blog.show', $related->slug) }}">{{ Str::limit($related->title, 60) }}</a></h6>
                                    @if($related->published_at)
                                    <small><i class="ti-calendar"></i> {{ \Carbon\Carbon::parse($related->published_at)->format('M d, Y') }}</small>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        {{-- Contact Widget --}}
                        @php $contact = \App\Helpers\Cms::contactInfo(); @endphp
                        <div class="widget clearfix" style="background:#d1d1ff; padding: 20px; border-radius: 8px;">
                            <h4>Plan Your Trip</h4>
                            <p>Ready to explore the Annapurna Region? Contact us to start planning your adventure.</p>
                            @if($contact['phone'])
                            <div class="mb-10">
                                <i class="flaticon-phone-call"></i>
                                <a href="tel:{{ $contact['phone'] }}">{{ $contact['phone'] }}</a>
                            </div>
                            @endif
                            <div class="butn-dark mt-20">
                                <a href="{{ route('contact') }}"><span>Contact Us <i class="ti-arrow-right"></i></span></a>
                            </div>
                        </div>

                        {{-- Trek Routes Widget --}}
                        <div class="widget clearfix usful-links mt-30">
                            <h4 class="widget-title">Popular Treks</h4>
                            <ul>
                                <li><a href="{{ route('trek-routes.index') }}"><i class="ti-arrow-right"></i> Annapurna Circuit Trek</a></li>
                                <li><a href="{{ route('trek-routes.index') }}"><i class="ti-arrow-right"></i> Annapurna Base Camp Trek</a></li>
                                <li><a href="{{ route('trek-routes.index') }}"><i class="ti-arrow-right"></i> Poon Hill Trek</a></li>
                                <li><a href="{{ route('trek-routes.index') }}"><i class="ti-arrow-right"></i> Mardi Himal Trek</a></li>
                            </ul>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Related Posts Section --}}
    @if(isset($relatedPosts) && $relatedPosts->isNotEmpty())
    <section class="blog-section section-padding bg-lightnav pt-0">
        <div class="container">
            <div class="row justify-content-center mb-30">
                <div class="col-md-8 text-center">
                    <div class="section-title">Related <span>Articles</span></div>
                </div>
            </div>
            <div class="row">
                @foreach($relatedPosts->take(3) as $related)
                <div class="col-md-4 col-sm-6 mb-30">
                    <div class="item">
                        <a href="{{ route('blog.show', $related->slug) }}">
                            <div class="position-re o-hidden">
                                @if($related->featured_image)
                                    <img src="{{ \App\Helpers\Cms::imageUrl($related->featured_image) }}" alt="{{ $related->title }}">
                                @else
                                    <img src="{{ asset('annapurna/img/slider/annapurna-region.png') }}" alt="{{ $related->title }}">
                                @endif
                            </div>
                            @if($related->category)
                            <span class="category">
                                <a href="#">{{ is_string($related->category) ? $related->category : ($related->category->name ?? 'Blog') }}</a>
                            </span>
                            @endif
                            <div class="con">
                                <h5><a href="{{ route('blog.show', $related->slug) }}">{{ $related->title }}</a></h5>
                                @if($related->excerpt)<p>{{ Str::limit($related->excerpt, 100) }}</p>@endif
                                <div class="line"></div>
                                <div class="info">
                                    <span>
                                        <i class="ti-calendar"></i>
                                        {{ $related->published_at ? \Carbon\Carbon::parse($related->published_at)->format('M d, Y') : '' }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

@endsection
