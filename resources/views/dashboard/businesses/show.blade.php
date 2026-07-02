@extends('layouts.dashboard')

@section('page_title', $business->name . ' Dashboard')

@section('content')

    {{-- Business Header --}}
    <div style="background: #fff; border-radius: 8px; padding: 24px; margin-bottom: 24px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 20px;">
        @if($business->logo)
            <img src="{{ asset('storage/' . $business->logo) }}" alt="{{ $business->name }}"
                 style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px; border: 1px solid #eee; flex-shrink: 0;">
        @else
            <div style="width: 70px; height: 70px; background: #c8a96e; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 26px; color: #fff; font-weight: 700; flex-shrink: 0;">
                {{ strtoupper(substr($business->name, 0, 1)) }}
            </div>
        @endif
        <div style="flex: 1;">
            <h2 style="font-size: 20px; font-weight: 700; margin: 0 0 4px;">{{ $business->name }}</h2>
            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <span style="background: #f0f0f0; padding: 3px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; text-transform: capitalize;">
                    {{ ucfirst(str_replace('_', ' ', $business->type)) }}
                </span>
                <span class="{{ $business->is_active ? 'badge-active' : 'badge-inactive' }}">
                    {{ $business->is_active ? 'Active' : 'Inactive' }}
                </span>
                <span class="badge-{{ $userRole }}">{{ ucfirst($userRole) }}</span>
            </div>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('businesses.show', $business->slug) }}" target="_blank" class="btn-dash-secondary btn-dash-sm">
                <i class="ti-eye"></i> View Listing
            </a>
            @if($business->user_id === auth()->id())
            <a href="{{ route('dashboard.businesses.edit', $business) }}" class="btn-dash-secondary btn-dash-sm">
                <i class="ti-pencil"></i> Edit
            </a>
            @endif
        </div>
    </div>

    {{-- Stats --}}
    <div class="dash-row mb-3">
        <div class="dash-col-4">
            <div class="dash-stat-card">
                <div class="stat-value">{{ $business->businessPosts->count() }}</div>
                <div class="stat-label">Posts</div>
            </div>
        </div>
        <div class="dash-stat-card dash-col-4" style="border-left-color: #3498db;">
            <div class="stat-value">{{ $business->members->count() }}</div>
            <div class="stat-label">Team Members</div>
        </div>
    </div>

    <div class="dash-row">
        {{-- Recent Posts --}}
        <div class="dash-col-6">
            <div class="dash-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h3 class="dash-card-title mb-0">Recent Posts</h3>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('dashboard.businesses.posts.create', $business) }}" class="btn-dash-primary btn-dash-sm">
                            <i class="ti-plus"></i> New Post
                        </a>
                        <a href="{{ route('dashboard.businesses.posts.index', $business) }}" class="btn-dash-secondary btn-dash-sm">All Posts</a>
                    </div>
                </div>

                @forelse($business->businessPosts as $post)
                <div style="padding: 12px 0; border-bottom: 1px solid #f0f0f0;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div style="flex: 1;">
                            <div style="font-weight: 500; font-size: 14px;">
                                {{ $post->title ?: Str::limit($post->content, 60, '...') }}
                            </div>
                            <div class="text-muted text-small">
                                {{ ucfirst($post->type) }} &bull; {{ $post->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <form method="POST" action="{{ route('dashboard.businesses.posts.destroy', [$business, $post]) }}"
                              onsubmit="return confirm('Delete this post?');"
                              style="margin-left: 12px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-dash-danger btn-dash-sm">Delete</button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="text-muted">No posts yet. <a href="{{ route('dashboard.businesses.posts.create', $business) }}" style="color: #c8a96e;">Create your first post</a>.</p>
                @endforelse
            </div>
        </div>

        {{-- Members --}}
        <div class="dash-col-6">
            <div class="dash-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h3 class="dash-card-title mb-0">Team Members</h3>
                    <a href="{{ route('dashboard.businesses.members.index', $business) }}" class="btn-dash-secondary btn-dash-sm">Manage</a>
                </div>

                @forelse($business->members as $member)
                <div style="padding: 10px 0; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; gap: 12px;">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: #c8a96e; display: flex; align-items: center; justify-content: center; font-size: 14px; color: #fff; font-weight: 700; flex-shrink: 0; overflow: hidden;">
                        @if($member->user?->avatar)
                            <img src="{{ asset('storage/' . $member->user->avatar) }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            {{ strtoupper(substr($member->user?->name ?? '?', 0, 1)) }}
                        @endif
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 500; font-size: 14px;">{{ $member->user?->name }}</div>
                        <div class="text-muted text-small">{{ $member->user?->email }}</div>
                    </div>
                    <span class="badge-{{ $member->role }}">{{ ucfirst($member->role) }}</span>
                </div>
                @empty
                <p class="text-muted">No team members yet.</p>
                @endforelse
            </div>
        </div>
    </div>

@endsection
