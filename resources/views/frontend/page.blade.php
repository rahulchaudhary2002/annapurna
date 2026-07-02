@extends('layouts.app')

@section('meta_title', ($page->meta_title ?: $page->title) . ' - ' . \App\Helpers\Cms::siteName())
@section('meta_description', $page->meta_description)

@section('content')

@include('partials.breadcrumb', [
    'title' => $page->title,
    'bgImage' => $page->featured_image ? \App\Helpers\Cms::imageUrl($page->featured_image) : null
])

{{-- Page Builder Sections --}}
@if($page->sections && count($page->sections))
    @foreach($page->sections as $section)
        @if($section['visible'] ?? true)
            @includeIf('partials.sections.' . ($section['type'] ?? 'text_block'), ['section' => $section])
        @endif
    @endforeach
@endif

{{-- Main content (if no sections or has both) --}}
@if($page->content)
<section class="page-content-section section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-content">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Template-specific content --}}
@switch($page->template)
    @case('about')
        @if(isset($counters) && $counters->count())
            <section class="counter-section section-padding pt-0">
                <div class="container">
                    <div class="row g-4">
                        @foreach($counters as $counter)
                            <div class="col-xl-3 col-lg-3 col-md-6">
                                <div class="counter-box-items text-center">
                                    @if($counter->icon)
                                        <div class="icon mb-3"><i class="{{ $counter->icon }}"></i></div>
                                    @endif
                                    <h2>{{ $counter->value }}</h2>
                                    <p>{{ $counter->label }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if(isset($teamMembers) && $teamMembers->count())
            <section class="team-section section-padding pt-0">
                <div class="container">
                    <div class="section-title text-center mb-5">
                        <span class="sub-title">{{ \App\Helpers\Cms::setting('about_team_subtitle', 'Our Team') }}</span>
                        <h2>{{ \App\Helpers\Cms::setting('about_team_title', 'The People Behind Idea Gen') }}</h2>
                    </div>
                    <div class="row">
                        @foreach($teamMembers->take(4) as $member)
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="team-box-items text-center">
                                    @if($member->image)
                                        <div class="team-image">
                                            <img src="{{ \App\Helpers\Cms::imageUrl($member->image) }}" alt="{{ $member->name }}" class="img-fluid">
                                        </div>
                                    @endif
                                    <div class="team-content mt-3">
                                        <h4><a href="{{ route('team.show', $member->slug) }}">{{ $member->name }}</a></h4>
                                        <p>{{ $member->position }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        @break
    @case('pricing')
        @if(isset($plans))
            @include('frontend.pricing-inline', ['plans' => $plans])
        @endif
        @break
    @case('team')
        @if(isset($teamMembers))
            @include('frontend.team-inline', ['teamMembers' => $teamMembers])
        @endif
        @break
@endswitch

@endsection
