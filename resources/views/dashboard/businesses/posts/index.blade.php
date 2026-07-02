@extends('layouts.dashboard')

@section('page_title', $business->name . ' - Posts')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-3">
        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="{{ route('dashboard.businesses.dashboard', $business) }}" class="btn-dash-secondary btn-dash-sm">
                <i class="ti-arrow-left"></i> Back
            </a>
            <div>
                <h2 style="font-size: 18px; color: #1a1a2e; margin: 0;">Posts — {{ $business->name }}</h2>
            </div>
        </div>
        <a href="{{ route('dashboard.businesses.posts.create', $business) }}" class="btn-dash-primary">
            <i class="ti-plus"></i> New Post
        </a>
    </div>

    <div class="dash-card">
        @if($posts->count() > 0)
        <table class="dash-table">
            <thead>
                <tr>
                    <th>Title / Content</th>
                    <th>Type</th>
                    <th>Views</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td>
                        <div style="font-weight: 500; font-size: 14px;">
                            {{ $post->title ?: Str::limit(strip_tags($post->content ?? ''), 60, '...') }}
                        </div>
                        @if($post->title && $post->content)
                        <div class="text-muted text-small">{{ Str::limit(strip_tags($post->content), 60, '...') }}</div>
                        @endif
                    </td>
                    <td>
                        <span style="background: #f0f0f0; padding: 3px 10px; border-radius: 20px; font-size: 12px; text-transform: capitalize;">
                            {{ $post->type }}
                        </span>
                    </td>
                    <td class="text-muted text-small">{{ number_format($post->views) }}</td>
                    <td>
                        <span class="{{ $post->is_published ? 'badge-active' : 'badge-inactive' }}">
                            {{ $post->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td class="text-muted text-small">{{ $post->created_at->format('M j, Y') }}</td>
                    <td>
                        <form method="POST" action="{{ route('dashboard.businesses.posts.destroy', [$business, $post]) }}"
                              onsubmit="return confirm('Delete this post?');"
                              style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-dash-danger btn-dash-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($posts->hasPages())
        <div style="margin-top: 20px;">
            {{ $posts->links() }}
        </div>
        @endif

        @else
        <div style="text-align: center; padding: 48px 0; color: #888;">
            <i class="ti-write" style="font-size: 48px; opacity: 0.3; display: block; margin-bottom: 16px;"></i>
            <h4 style="font-size: 16px; color: #555;">No posts yet</h4>
            <p style="font-size: 14px;">Share updates, photos, and announcements with your customers.</p>
            <a href="{{ route('dashboard.businesses.posts.create', $business) }}" class="btn-dash-primary">
                <i class="ti-plus"></i> Create First Post
            </a>
        </div>
        @endif
    </div>

@endsection
