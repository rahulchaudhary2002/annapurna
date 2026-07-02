@extends('layouts.dashboard')

@section('page_title', 'My Feed Posts')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h2 style="font-size:20px;font-weight:700;color:#1a1a2e;margin:0 0 4px;">My Feed Posts</h2>
            <p class="text-muted">Manage the posts you've shared with the community.</p>
        </div>
        <a href="{{ route('feed.create') }}" class="btn-dash-primary">
            <i class="ti-plus"></i> New Post
        </a>
    </div>

    <div class="dash-card">
        @if($posts->count() > 0)
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Post</th>
                        <th>Type</th>
                        <th>Posted As</th>
                        <th>Stats</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td style="max-width:280px;">
                                <a href="{{ route('feed.show', $post->id) }}" target="_blank"
                                   style="font-size:13px;font-weight:500;color:#1a1a2e;text-decoration:none;">
                                    @if($post->title)
                                        {{ \Illuminate\Support\Str::limit($post->title, 60) }}
                                    @else
                                        {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 60) ?: 'Post #' . $post->id }}
                                    @endif
                                </a>
                                @if($post->is_sponsored)
                                    <span class="badge-owner" style="display:inline-block;margin-left:4px;font-size:10px;">Sponsored</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $typeColors = [
                                        'text'         => '#666',
                                        'photo'        => '#3498db',
                                        'video'        => '#9b59b6',
                                        'link'         => '#16a085',
                                        'announcement' => '#e67e22',
                                        'offer'        => '#27ae60',
                                    ];
                                @endphp
                                <span style="background:{{ $typeColors[$post->type] ?? '#666' }};color:#fff;padding:2px 8px;border-radius:10px;font-size:11px;font-weight:600;text-transform:uppercase;">
                                    {{ ucfirst($post->type) }}
                                </span>
                            </td>
                            <td style="font-size:13px;color:#555;">
                                @if($post->business)
                                    <i class="ti-briefcase" style="color:#c8a96e;margin-right:4px;"></i>
                                    {{ $post->business->name }}
                                @else
                                    <i class="ti-user" style="color:#888;margin-right:4px;"></i>
                                    Personal
                                @endif
                            </td>
                            <td>
                                <div style="font-size:12px;color:#666;white-space:nowrap;">
                                    <i class="ti-eye"></i> {{ number_format($post->views_count) }}
                                    &bull; <i class="ti-heart"></i> {{ number_format($post->likes_count) }}
                                    &bull; <i class="ti-comment"></i> {{ number_format($post->comments_count) }}
                                </div>
                            </td>
                            <td style="font-size:12px;color:#888;white-space:nowrap;">
                                {{ $post->created_at->format('M j, Y') }}
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('feed.show', $post->id) }}" target="_blank"
                                       class="btn-dash-secondary btn-dash-sm" title="View">
                                        <i class="ti-eye"></i>
                                    </a>
                                    <a href="{{ route('feed.edit', $post->id) }}"
                                       class="btn-dash-secondary btn-dash-sm" title="Edit">
                                        <i class="ti-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('dashboard.feed.destroy', $post->id) }}"
                                          style="margin:0;" onsubmit="return confirm('Delete this post?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-dash-danger btn-dash-sm" title="Delete">
                                            <i class="ti-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top:20px;">
                {{ $posts->links() }}
            </div>
        @else
            <div style="text-align:center;padding:50px 20px;color:#888;">
                <i class="ti-layout-list-post" style="font-size:40px;color:#ddd;display:block;margin-bottom:14px;"></i>
                <h3 style="font-size:16px;color:#555;margin-bottom:8px;">No posts yet</h3>
                <p style="font-size:14px;margin-bottom:20px;">Share stories, offers, or updates with the community.</p>
                <a href="{{ route('feed.create') }}" class="btn-dash-primary">Create Your First Post</a>
            </div>
        @endif
    </div>
@endsection
