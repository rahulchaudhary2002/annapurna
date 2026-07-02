@extends('layouts.app')

@section('meta_title', ($project->meta_title ?: $project->title) . ' - ' . \App\Helpers\Cms::siteName())
@section('meta_description', $project->meta_description ?: $project->excerpt)

@section('content')

@include('partials.breadcrumb', [
    'title' => $project->title,
    'bgImage' => $project->featured_image ? \App\Helpers\Cms::imageUrl($project->featured_image) : null,
    'parent' => ['title' => 'Portfolio', 'url' => route('projects.index')]
])

<section class="project-details-section section-padding fix">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @if($project->featured_image)
                    <img src="{{ \App\Helpers\Cms::imageUrl($project->featured_image) }}" alt="{{ $project->title }}" class="img-fluid rounded mb-4">
                @endif

                <h2>{{ $project->title }}</h2>

                @if($project->excerpt)
                    <p class="lead">{{ $project->excerpt }}</p>
                @endif

                <div class="project-content">
                    {!! $project->content !!}
                </div>

                @if($project->highlights && count($project->highlights))
                    <div class="project-highlights mt-4">
                        <h4>Project Highlights</h4>
                        <ul class="highlights-list">
                            @foreach($project->highlights as $h)
                                <li><i class="fas fa-check-circle text-success me-2"></i>{{ $h['text'] ?? $h }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($project->gallery && count($project->gallery))
                    <div class="project-gallery mt-5">
                        <h4>Project Gallery</h4>
                        <div class="row g-3">
                            @foreach($project->gallery as $img)
                            <div class="col-md-4">
                                <a href="{{ \App\Helpers\Cms::imageUrl($img['image'] ?? $img) }}" class="magnific-image">
                                    <img src="{{ \App\Helpers\Cms::imageUrl($img['image'] ?? $img) }}" alt="{{ $project->title }}" class="img-fluid rounded">
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Prev/Next --}}
                <div class="project-nav row mt-5 pt-4 border-top">
                    @if($prevProject)
                    <div class="col-6">
                        <a href="{{ route('projects.show', $prevProject->slug) }}">
                            <small class="d-block text-muted"><i class="fas fa-arrow-left me-1"></i>Previous Project</small>
                            <span>{{ Str::limit($prevProject->title, 50) }}</span>
                        </a>
                    </div>
                    @endif
                    @if($nextProject)
                    <div class="col-6 text-end">
                        <a href="{{ route('projects.show', $nextProject->slug) }}">
                            <small class="d-block text-muted">Next Project <i class="fas fa-arrow-right ms-1"></i></small>
                            <span>{{ Str::limit($nextProject->title, 50) }}</span>
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="project-info-widget p-4 rounded bg-light mb-4">
                    <h4 class="widget-title">Project Details</h4>
                    <ul class="project-info-list list-unstyled">
                        @if($project->client)
                            <li><strong>Client:</strong> {{ $project->client }}</li>
                        @endif
                        @if($project->category)
                            <li><strong>Category:</strong> {{ $project->category->name }}</li>
                        @endif
                        @if($project->location)
                            <li><strong>Location:</strong> {{ $project->location }}</li>
                        @endif
                        @if($project->year)
                            <li><strong>Year:</strong> {{ $project->year }}</li>
                        @endif
                        @if($project->duration)
                            <li><strong>Duration:</strong> {{ $project->duration }}</li>
                        @endif
                        @if($project->website)
                            <li><strong>Website:</strong> <a href="{{ $project->website }}" target="_blank">{{ $project->website }}</a></li>
                        @endif
                    </ul>
                    @if($project->tags->count())
                        <div class="mt-3">
                            <strong>Tags:</strong>
                            <div class="d-flex flex-wrap gap-1 mt-2">
                                @foreach($project->tags as $tag)
                                    <span class="badge bg-secondary">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                @if($relatedProjects->count())
                <div class="widget">
                    <h4 class="widget-title">Related Projects</h4>
                    @foreach($relatedProjects as $rp)
                    <div class="d-flex gap-3 mb-3">
                        @if($rp->image)
                            <img src="{{ \App\Helpers\Cms::imageUrl($rp->image) }}" alt="{{ $rp->title }}" width="70" height="70" class="rounded flex-shrink-0">
                        @endif
                        <div>
                            <a href="{{ route('projects.show', $rp->slug) }}"><strong>{{ Str::limit($rp->title, 40) }}</strong></a>
                            @if($rp->category)<small class="d-block text-muted">{{ $rp->category->name }}</small>@endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
