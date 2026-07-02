@extends('layouts.app')

@section('meta_title', $member->name . ' - ' . \App\Helpers\Cms::siteName())

@section('content')

@include('partials.breadcrumb', [
    'title' => $member->name,
    'parent' => ['title' => 'Team', 'url' => route('team.index')]
])

<section class="team-details-section section-padding fix">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="team-details-sidebar">
                    @if($member->image)
                        <img src="{{ \App\Helpers\Cms::imageUrl($member->image) }}" alt="{{ $member->name }}" class="img-fluid rounded mb-4">
                    @endif

                    <div class="member-info-card p-4 rounded bg-light">
                        <h4>{{ $member->name }}</h4>
                        <p class="text-primary mb-1">{{ $member->position }}</p>
                        @if($member->department)
                            <span class="badge bg-secondary mb-3">{{ $member->department }}</span>
                        @endif
                        <ul class="list-unstyled">
                            @if($member->email)
                                <li class="mb-2"><i class="fas fa-envelope me-2 text-primary"></i><a href="mailto:{{ $member->email }}">{{ $member->email }}</a></li>
                            @endif
                            @if($member->phone)
                                <li class="mb-2"><i class="fas fa-phone me-2 text-primary"></i><a href="tel:{{ $member->phone }}">{{ $member->phone }}</a></li>
                            @endif
                        </ul>
                        <div class="social-links mt-3 d-flex gap-2">
                            @if($member->facebook)<a href="{{ $member->facebook }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fab fa-facebook-f"></i></a>@endif
                            @if($member->twitter)<a href="{{ $member->twitter }}" target="_blank" class="btn btn-sm btn-outline-info"><i class="fab fa-twitter"></i></a>@endif
                            @if($member->linkedin)<a href="{{ $member->linkedin }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fab fa-linkedin-in"></i></a>@endif
                            @if($member->instagram)<a href="{{ $member->instagram }}" target="_blank" class="btn btn-sm btn-outline-danger"><i class="fab fa-instagram"></i></a>@endif
                            @if($member->github)<a href="{{ $member->github }}" target="_blank" class="btn btn-sm btn-outline-dark"><i class="fab fa-github"></i></a>@endif
                        </div>
                    </div>

                    @if($member->skills && count($member->skills))
                    <div class="skills-widget mt-4 p-4 rounded bg-light">
                        <h5>Skills</h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($member->skills as $skill)
                                <span class="badge bg-primary-light text-primary border border-primary">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-8">
                <div class="team-details-content">
                    <h2>{{ $member->name }}</h2>
                    <p class="lead text-primary">{{ $member->position }}</p>

                    @if($member->full_bio)
                        <div class="bio-content">{!! $member->full_bio !!}</div>
                    @elseif($member->bio)
                        <p>{{ $member->bio }}</p>
                    @endif

                    @if($member->experience && count($member->experience))
                    <div class="experience-section mt-5">
                        <h4>Experience</h4>
                        <div class="experience-timeline">
                            @foreach($member->experience as $exp)
                            <div class="experience-item mb-4">
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-1">{{ $exp['position'] ?? '' }}</h5>
                                    @if($exp['period'] ?? null)
                                        <span class="text-muted">{{ $exp['period'] }}</span>
                                    @endif
                                </div>
                                <p class="text-primary mb-1">{{ $exp['company'] ?? '' }}</p>
                                @if($exp['description'] ?? null)
                                    <p class="text-muted">{{ $exp['description'] }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Other Members --}}
        @if($otherMembers->count())
        <div class="mt-5 pt-5 border-top">
            <h3 class="mb-4">Other Team Members</h3>
            <div class="row">
                @foreach($otherMembers as $other)
                <div class="col-md-3 text-center mb-4">
                    @if($other->image)
                        <img src="{{ \App\Helpers\Cms::imageUrl($other->image) }}" alt="{{ $other->name }}" class="rounded-circle mb-2" width="80" height="80">
                    @endif
                    <h6><a href="{{ route('team.show', $other->slug) }}">{{ $other->name }}</a></h6>
                    <small class="text-muted">{{ $other->position }}</small>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

@endsection
