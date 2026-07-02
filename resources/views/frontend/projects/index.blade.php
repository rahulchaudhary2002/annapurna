@extends('layouts.app')

@section('meta_title', \App\Helpers\Cms::setting('projects_meta_title', 'Portfolio - ' . \App\Helpers\Cms::siteName()))
@section('meta_description', \App\Helpers\Cms::setting('projects_meta_description', ''))

@section('content')

@php
    $pageSubtitle = \App\Helpers\Cms::setting('projects_page_subtitle', 'Selected Work');
    $pageTitle = \App\Helpers\Cms::setting('projects_page_title', 'Projects That Turn Ideas Into Results');
    $pageDescription = \App\Helpers\Cms::setting('projects_page_description', '');
    $breadcrumbImage = \App\Helpers\Cms::setting('projects_breadcrumb_image');
@endphp

@include('partials.breadcrumb', [
    'title' => \App\Helpers\Cms::setting('projects_breadcrumb_title', 'Projects'),
    'bgImage' => $breadcrumbImage ? \App\Helpers\Cms::imageUrl($breadcrumbImage) : null,
])

<section class="project-section section-padding fix">
    <div class="container">
        <div class="section-title text-center mb-5">
            <span class="sub-title">{{ $pageSubtitle }}</span>
            <h2>{{ $pageTitle }}</h2>
            @if($pageDescription)
                <p class="mt-3">{{ $pageDescription }}</p>
            @endif
        </div>

        {{-- Filter Tabs --}}
        @if($categories->count())
        <div class="project-filter mb-5 text-center">
            <ul class="filter-list list-unstyled d-flex flex-wrap justify-content-center gap-2">
                <li>
                    <a href="{{ route('projects.index') }}" class="filter-btn {{ !request('category') ? 'active' : '' }}">All</a>
                </li>
                @foreach($categories as $cat)
                    <li>
                        <a href="{{ route('projects.index', ['category' => $cat->slug]) }}"
                           class="filter-btn {{ request('category') === $cat->slug ? 'active' : '' }}">
                            {{ $cat->name }} ({{ $cat->projects_count }})
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="row">
            @foreach($projects as $project)
            <div class="col-xl-4 col-lg-4 col-md-6 mb-4 wow fadeInUp" data-wow-delay=".2s">
                <div class="project-box-items">
                    <div class="project-image">
                        <a href="{{ route('projects.show', $project->slug) }}">
                            <img src="{{ \App\Helpers\Cms::imageUrl($project->image, asset('assets/img/placeholder.jpg')) }}"
                                 alt="{{ $project->title }}" class="img-fluid">
                        </a>
                        <div class="project-overlay">
                            <a href="{{ route('projects.show', $project->slug) }}" class="project-link">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="project-content">
                        @if($project->category)
                            <span class="category-label">{{ $project->category->name }}</span>
                        @endif
                        <h4><a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a></h4>
                        @if($project->client)
                            <p class="client mb-0"><i class="fas fa-user me-1"></i> {{ $project->client }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $projects->appends(request()->query())->links() }}
        </div>
    </div>
</section>

@endsection
