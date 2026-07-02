@extends('layouts.app')

@section('meta_title', ($post->title ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 60)) . ' - ' . \App\Helpers\Cms::siteName())
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($post->content), 160))

@push('styles')
<style>
    .feed-show-page {
        background: #f4f6f9;
        min-height: 100vh;
        padding: 40px 0 60px;
    }
    .feed-show-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 28px;
        align-items: start;
    }
    @media (max-width: 991px) {
        .feed-show-layout { grid-template-columns: 1fr; }
    }
    .post-full-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    .post-full-media img {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
        display: block;
    }
    .post-full-body { padding: 24px; }
    .post-full-header { display: flex; align-items: center; gap: 14px; margin-bottom: 20px; }
    .post-full-author-avatar {
        width: 52px; height: 52px; border-radius: 50%; background: #c8a96e;
        color: #fff; font-size: 18px; font-weight: 700; display: flex;
        align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;
    }
    .post-full-author-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .post-full-meta { flex: 1; }
    .post-full-author-name { font-size: 16px; font-weight: 600; color: #1a1a2e; text-decoration: none; }
    .post-full-author-name:hover { color: #c8a96e; }
    .post-full-time { font-size: 13px; color: #aaa; margin-top: 2px; }
    .post-full-title { font-size: 22px; font-weight: 700; color: #1a1a2e; margin: 0 0 16px; line-height: 1.4; }
    .post-full-content { font-size: 15px; color: #444; line-height: 1.8; margin: 0 0 20px; white-space: pre-line; }

    /* Engagement bar */
    .engagement-bar {
        display: flex; gap: 8px; flex-wrap: wrap; padding: 16px 0;
        border-top: 1px solid #f5f5f5; border-bottom: 1px solid #f5f5f5; margin-bottom: 24px;
    }
    .eng-btn {
        display: flex; align-items: center; gap: 6px; padding: 9px 16px;
        border-radius: 8px; border: none; background: #f8f8f8; cursor: pointer;
        font-size: 14px; color: #555; font-family: 'Poppins', sans-serif;
        transition: all 0.2s;
    }
    .eng-btn:hover { background: #f0f0f0; color: #333; }
    .eng-btn.liked { color: #e74c3c; background: #fff0f0; }
    .eng-btn.saved { color: #c8a96e; background: #fdf8f0; }

    /* Comments */
    .comments-section { margin-top: 24px; }
    .comments-section h3 { font-size: 16px; font-weight: 600; color: #1a1a2e; margin: 0 0 20px; }
    .comment-input-area { display: flex; gap: 12px; align-items: flex-start; margin-bottom: 24px; }
    .comment-input-avatar {
        width: 40px; height: 40px; border-radius: 50%; background: #c8a96e;
        color: #fff; font-size: 14px; font-weight: 700; display: flex;
        align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden;
    }
    .comment-input-avatar img { width: 100%; height: 100%; object-fit: cover; }

    /* Stats sidebar */
    .post-stats-card {
        background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        padding: 20px; margin-bottom: 20px;
    }
    .post-stats-card h4 { font-size: 14px; font-weight: 600; color: #1a1a2e; margin: 0 0 14px; padding-bottom: 10px; border-bottom: 2px solid #c8a96e; }
    .stat-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f5f5f5; font-size: 13px; }
    .stat-row:last-child { border-bottom: none; }
    .stat-row-label { color: #888; }
    .stat-row-value { font-weight: 600; color: #1a1a2e; }
</style>
@endpush

@section('content')
    @include('partials.breadcrumb', ['title' => 'Post', 'items' => [
        ['label' => 'Feed', 'url' => route('feed.index')],
        ['label' => 'Post']
    ]])

    <div class="feed-show-page">
        <div class="container">
            <div class="feed-show-layout">

                {{-- ─── Main Post ──────────────────────────────────────────── --}}
                <div class="feed-show-main">
                    <div class="post-full-card">

                        {{-- Photo Media --}}
                        @if($post->type === 'photo' && !empty($post->media))
                            <div class="post-full-media">
                                @foreach($post->media as $photo)
                                    <img src="{{ asset('storage/' . $photo) }}" alt="Photo">
                                @endforeach
                            </div>
                        @endif

                        {{-- Video --}}
                        @if($post->type === 'video' && $post->video_url)
                            @php
                                $isYouTube = str_contains($post->video_url, 'youtube.com') || str_contains($post->video_url, 'youtu.be');
                                $youtubeId = null;
                                if ($isYouTube) {
                                    preg_match('/(?:v=|youtu\.be\/)([A-Za-z0-9_\-]{11})/', $post->video_url, $m);
                                    $youtubeId = $m[1] ?? null;
                                }
                            @endphp
                            <div style="aspect-ratio:16/9;background:#000;">
                                @if($isYouTube && $youtubeId)
                                    <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}" style="width:100%;height:100%;border:none;" allowfullscreen></iframe>
                                @elseif(!$isYouTube)
                                    <video controls style="width:100%;height:100%;object-fit:cover;">
                                        <source src="{{ asset('storage/' . $post->video_url) }}" type="video/mp4">
                                    </video>
                                @endif
                            </div>
                        @endif

                        <div class="post-full-body">
                            {{-- Post header --}}
                            <div class="post-full-header">
                                <a href="{{ $post->author_url }}" class="post-full-author-avatar">
                                    @if($post->author_avatar)
                                        <img src="{{ $post->author_avatar }}" alt="{{ $post->author_name }}">
                                    @else
                                        {{ strtoupper(substr($post->author_name, 0, 1)) }}
                                    @endif
                                </a>
                                <div class="post-full-meta">
                                    <a href="{{ $post->author_url }}" class="post-full-author-name">{{ $post->author_name }}</a>
                                    <div class="post-full-time">{{ $post->created_at->format('F j, Y \a\t g:i A') }}</div>
                                </div>
                                @if($post->is_sponsored)
                                    <span style="background:#c8a96e;color:#fff;font-size:10px;font-weight:700;padding:3px 10px;border-radius:20px;">Sponsored</span>
                                @endif
                            </div>

                            {{-- Title --}}
                            @if($post->title)
                                @if($post->type === 'offer')
                                    <div style="background:linear-gradient(135deg,#27ae60,#2ecc71);color:#fff;padding:16px 20px;border-radius:10px;margin-bottom:16px;">
                                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;opacity:0.85;margin-bottom:6px;"><i class="ti-tag"></i> Special Offer</div>
                                        <div style="font-size:20px;font-weight:700;">{{ $post->title }}</div>
                                    </div>
                                @elseif($post->type === 'announcement')
                                    <div style="background:linear-gradient(135deg,#e67e22,#f39c12);color:#fff;padding:16px 20px;border-radius:10px;margin-bottom:16px;">
                                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;opacity:0.85;margin-bottom:6px;"><i class="ti-announcement"></i> Announcement</div>
                                        <div style="font-size:20px;font-weight:700;">{{ $post->title }}</div>
                                    </div>
                                @else
                                    <h1 class="post-full-title">{{ $post->title }}</h1>
                                @endif
                            @endif

                            {{-- Content --}}
                            @if($post->content)
                                <div class="post-full-content">{{ $post->content }}</div>
                            @endif

                            {{-- Link preview --}}
                            @if($post->type === 'link' && $post->link_url)
                                @php $domain = parse_url($post->link_url, PHP_URL_HOST); @endphp
                                <a href="{{ $post->link_url }}" target="_blank" rel="noopener noreferrer"
                                   style="display:block;border:1px solid #e8e8e8;border-radius:8px;overflow:hidden;text-decoration:none;margin-bottom:20px;">
                                    @if($post->link_image)
                                        <img src="{{ asset('storage/' . $post->link_image) }}" alt="" style="width:100%;height:220px;object-fit:cover;display:block;">
                                    @endif
                                    <div style="padding:14px 18px;">
                                        @if($domain)<div style="font-size:11px;color:#aaa;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;">{{ $domain }}</div>@endif
                                        @if($post->link_title)<div style="font-size:15px;font-weight:600;color:#1a1a2e;margin-bottom:5px;">{{ $post->link_title }}</div>@endif
                                        @if($post->link_description)<div style="font-size:13px;color:#666;">{{ $post->link_description }}</div>@endif
                                    </div>
                                </a>
                            @endif

                            {{-- Engagement bar --}}
                            <div class="engagement-bar">
                                <button class="eng-btn feed-like-btn {{ $isLiked ? 'liked' : '' }}"
                                        data-url="{{ route('feed.like', $post->id) }}">
                                    <i class="ti-heart"></i>
                                    <span class="feed-count">{{ $post->likes_count }}</span> Likes
                                </button>

                                <button class="eng-btn"
                                        onclick="document.getElementById('comment-input').focus()">
                                    <i class="ti-comment"></i> {{ $post->comments_count }} Comments
                                </button>

                                <div style="position:relative;">
                                    <button class="eng-btn feed-share-btn">
                                        <i class="ti-share"></i> {{ $post->shares_count }} Share
                                    </button>
                                    <div class="feed-share-dropdown" style="display:none;position:absolute;bottom:100%;left:0;background:#fff;border:1px solid #e8e8e8;border-radius:8px;box-shadow:0 4px 16px rgba(0,0,0,0.12);min-width:160px;z-index:100;overflow:hidden;">
                                        @php $postUrl = route('feed.show', $post->id); @endphp
                                        <div class="share-option" data-platform="copy" data-post-url="{{ $postUrl }}" data-track-url="{{ route('feed.share', $post->id) }}"
                                             style="padding:10px 16px;cursor:pointer;font-size:13px;color:#333;display:flex;align-items:center;gap:8px;"
                                             onmouseover="this.style.background='#f8f8f8'" onmouseout="this.style.background='transparent'">
                                            <i class="ti-link"></i> Copy Link
                                        </div>
                                        <div class="share-option" data-platform="whatsapp" data-post-url="{{ $postUrl }}" data-track-url="{{ route('feed.share', $post->id) }}"
                                             style="padding:10px 16px;cursor:pointer;font-size:13px;color:#25d366;display:flex;align-items:center;gap:8px;"
                                             onmouseover="this.style.background='#f8f8f8'" onmouseout="this.style.background='transparent'">
                                            <i class="ti-mobile"></i> WhatsApp
                                        </div>
                                        <div class="share-option" data-platform="facebook" data-post-url="{{ $postUrl }}" data-track-url="{{ route('feed.share', $post->id) }}"
                                             style="padding:10px 16px;cursor:pointer;font-size:13px;color:#3b5998;display:flex;align-items:center;gap:8px;"
                                             onmouseover="this.style.background='#f8f8f8'" onmouseout="this.style.background='transparent'">
                                            <i class="ti-facebook"></i> Facebook
                                        </div>
                                        <div class="share-option" data-platform="twitter" data-post-url="{{ $postUrl }}" data-track-url="{{ route('feed.share', $post->id) }}"
                                             style="padding:10px 16px;cursor:pointer;font-size:13px;color:#1da1f2;display:flex;align-items:center;gap:8px;"
                                             onmouseover="this.style.background='#f8f8f8'" onmouseout="this.style.background='transparent'">
                                            <i class="ti-twitter-alt"></i> Twitter
                                        </div>
                                    </div>
                                </div>

                                @auth
                                    <button class="eng-btn feed-save-btn {{ $isSaved ? 'saved' : '' }}" style="margin-left:auto;"
                                            data-url="{{ route('feed.save', $post->id) }}">
                                        <i class="{{ $isSaved ? 'ti-bookmark-alt' : 'ti-bookmark' }}"></i>
                                        {{ $isSaved ? 'Saved' : 'Save' }}
                                    </button>
                                @endauth
                            </div>

                            {{-- ─── Comments Section ─────────────────────────────────── --}}
                            <div class="comments-section">
                                <h3>Comments ({{ $post->comments_count }})</h3>

                                @auth
                                    <div class="comment-input-area">
                                        <div class="comment-input-avatar">
                                            @if(auth()->user()->avatar)
                                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="">
                                            @else
                                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                            @endif
                                        </div>
                                        <div style="flex:1;">
                                            <form class="feed-comment-form" data-post-id="{{ $post->id }}">
                                                @csrf
                                                <textarea id="comment-input" name="content" rows="3" placeholder="Share your thoughts..."
                                                    style="width:100%;padding:12px 14px;border:1px solid #e0e0e0;border-radius:8px;font-size:14px;font-family:'Poppins',sans-serif;resize:none;outline:none;line-height:1.6;"
                                                    onfocus="this.style.borderColor='#c8a96e'" onblur="this.style.borderColor='#e0e0e0'"></textarea>
                                                <div style="text-align:right;margin-top:8px;">
                                                    <button type="submit"
                                                        style="background:#c8a96e;color:#fff;border:none;padding:9px 22px;border-radius:6px;font-size:14px;font-family:'Poppins',sans-serif;cursor:pointer;font-weight:500;">
                                                        Post Comment
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <div style="background:#f8f8f8;border-radius:8px;padding:16px;text-align:center;margin-bottom:20px;">
                                        <p style="color:#888;font-size:14px;margin:0 0 10px;">
                                            <a href="{{ route('login') }}" style="color:#c8a96e;">Log in</a> to leave a comment.
                                        </p>
                                    </div>
                                @endauth

                                {{-- Comments list --}}
                                <div class="comments-list" id="comments-list-{{ $post->id }}">
                                    @forelse($comments as $comment)
                                        @include('feed.partials.comment-item', ['comment' => $comment, 'post' => $post])
                                    @empty
                                        <div style="text-align:center;padding:30px;color:#aaa;font-size:14px;">
                                            No comments yet. Be the first to comment!
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ─── Sidebar ──────────────────────────────────────────────── --}}
                <aside class="feed-show-sidebar">
                    <div class="post-stats-card">
                        <h4>Post Stats</h4>
                        <div class="stat-row">
                            <span class="stat-row-label"><i class="ti-eye"></i> Views</span>
                            <span class="stat-row-value">{{ number_format($post->views_count) }}</span>
                        </div>
                        <div class="stat-row">
                            <span class="stat-row-label"><i class="ti-heart"></i> Likes</span>
                            <span class="stat-row-value">{{ number_format($post->likes_count) }}</span>
                        </div>
                        <div class="stat-row">
                            <span class="stat-row-label"><i class="ti-comment"></i> Comments</span>
                            <span class="stat-row-value">{{ number_format($post->comments_count) }}</span>
                        </div>
                        <div class="stat-row">
                            <span class="stat-row-label"><i class="ti-share"></i> Shares</span>
                            <span class="stat-row-value">{{ number_format($post->shares_count) }}</span>
                        </div>
                        <div class="stat-row">
                            <span class="stat-row-label"><i class="ti-bookmark"></i> Saves</span>
                            <span class="stat-row-value">{{ number_format($post->saves_count) }}</span>
                        </div>
                    </div>

                    @if($post->business)
                        <div class="post-stats-card">
                            <h4>About the Author</h4>
                            <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
                                <div style="width:48px;height:48px;border-radius:8px;background:#1a1a2e;overflow:hidden;flex-shrink:0;">
                                    @if($post->business->cover_photo)
                                        <img src="{{ asset('storage/' . $post->business->cover_photo) }}" alt="" style="width:100%;height:100%;object-fit:cover;">
                                    @else
                                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#c8a96e;font-size:18px;font-weight:700;">
                                            {{ strtoupper(substr($post->business->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div style="font-size:14px;font-weight:600;color:#1a1a2e;">{{ $post->business->name }}</div>
                                    <div style="font-size:12px;color:#888;">{{ ucfirst(str_replace('_', ' ', $post->business->type)) }}</div>
                                </div>
                            </div>
                            @if($post->business->short_description)
                                <p style="font-size:13px;color:#666;margin:0 0 14px;line-height:1.6;">{{ \Illuminate\Support\Str::limit($post->business->short_description, 120) }}</p>
                            @endif
                            <a href="{{ route('businesses.show', $post->business->slug) }}" style="display:block;text-align:center;background:#c8a96e;color:#fff;padding:9px;border-radius:6px;text-decoration:none;font-size:13px;font-weight:500;">
                                View Business Profile
                            </a>
                        </div>
                    @endif

                    <div class="post-stats-card">
                        <h4>Back to Feed</h4>
                        <a href="{{ route('feed.index') }}" style="display:block;text-align:center;background:#1a1a2e;color:#fff;padding:10px;border-radius:6px;text-decoration:none;font-size:13px;font-weight:500;">
                            <i class="ti-layout-list-post"></i> Community Feed
                        </a>
                    </div>
                </aside>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
(function() {
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    // Track view
    const postId = {{ $post->id }};
    const viewedKey = 'feed_viewed';
    let viewedSet = new Set(JSON.parse(localStorage.getItem(viewedKey) || '[]'));
    if (!viewedSet.has(String(postId))) {
        viewedSet.add(String(postId));
        localStorage.setItem(viewedKey, JSON.stringify([...viewedSet]));
        fetch('/feed/' + postId + '/view', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
        });
    }

    // Like
    const likeBtn = document.querySelector('.feed-like-btn');
    if (likeBtn) {
        likeBtn.addEventListener('click', function() {
            @if(!auth()->check())
            window.location.href = '{{ route('login') }}';
            return;
            @endif
            likeBtn.disabled = true;
            fetch(likeBtn.dataset.url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                const countEl = likeBtn.querySelector('.feed-count');
                if (data.liked) {
                    likeBtn.classList.add('liked');
                } else {
                    likeBtn.classList.remove('liked');
                }
                if (countEl) countEl.textContent = data.count;
            })
            .finally(() => { likeBtn.disabled = false; });
        });
    }

    // Save
    const saveBtn = document.querySelector('.feed-save-btn');
    if (saveBtn) {
        saveBtn.addEventListener('click', function() {
            saveBtn.disabled = true;
            fetch(saveBtn.dataset.url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.saved) {
                    saveBtn.classList.add('saved');
                    saveBtn.innerHTML = '<i class="ti-bookmark-alt"></i> Saved';
                } else {
                    saveBtn.classList.remove('saved');
                    saveBtn.innerHTML = '<i class="ti-bookmark"></i> Save';
                }
            })
            .finally(() => { saveBtn.disabled = false; });
        });
    }

    // Share dropdown
    const shareBtn = document.querySelector('.feed-share-btn');
    if (shareBtn) {
        shareBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = shareBtn.nextElementSibling;
            if (dropdown) dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });
    }

    document.querySelectorAll('.share-option').forEach(function(opt) {
        opt.addEventListener('click', function() {
            const platform = opt.dataset.platform;
            const postUrl = opt.dataset.postUrl;
            const trackUrl = opt.dataset.trackUrl;

            if (platform === 'copy') {
                navigator.clipboard.writeText(postUrl).then(function() {
                    opt.textContent = 'Copied!';
                    setTimeout(() => { opt.innerHTML = '<i class="ti-link"></i> Copy Link'; }, 2000);
                });
            } else if (platform === 'whatsapp') {
                window.open('https://wa.me/?text=' + encodeURIComponent(postUrl), '_blank');
            } else if (platform === 'facebook') {
                window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(postUrl), '_blank');
            } else if (platform === 'twitter') {
                window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(postUrl), '_blank');
            }

            if (trackUrl) {
                fetch(trackUrl, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' },
                    body: JSON.stringify({ platform: platform })
                });
            }
            opt.closest('.feed-share-dropdown').style.display = 'none';
        });
    });

    document.addEventListener('click', function() {
        document.querySelectorAll('.feed-share-dropdown').forEach(function(d) {
            d.style.display = 'none';
        });
    });

    // Comment form on show page
    const commentForm = document.querySelector('.feed-comment-form');
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const postId = commentForm.dataset.postId;
            const content = commentForm.querySelector('textarea').value.trim();
            if (!content) return;

            const submitBtn = commentForm.querySelector('button[type="submit"]');
            submitBtn.disabled = true;

            fetch('/feed/' + postId + '/comments', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' },
                body: JSON.stringify({ content: content })
            })
            .then(r => r.json())
            .then(data => {
                if (data.html) {
                    const list = document.getElementById('comments-list-' + postId);
                    if (list) {
                        list.insertAdjacentHTML('afterbegin', data.html);
                        // Remove empty state message if present
                        const empty = list.querySelector('div[style*="text-align:center"]');
                        if (empty) empty.remove();
                    }
                    commentForm.querySelector('textarea').value = '';
                }
            })
            .finally(() => { submitBtn.disabled = false; });
        });
    }

    // Delete comment buttons
    document.querySelectorAll('.comment-delete-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (!confirm('Delete this comment?')) return;
            fetch(btn.dataset.url, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.deleted) {
                    const item = btn.closest('.comment-item');
                    if (item) item.remove();
                }
            });
        });
    });

    // Reply toggles
    document.querySelectorAll('.reply-toggle-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const replyForm = btn.parentElement.nextElementSibling;
            if (replyForm && replyForm.classList.contains('reply-form')) {
                replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
            }
        });
    });
})();
</script>
@endpush
