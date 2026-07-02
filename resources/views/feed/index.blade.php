@extends('layouts.app')

@section('meta_title', 'Community Feed - ' . \App\Helpers\Cms::siteName())
@section('meta_description', 'Discover travel stories, offers, and announcements from the Annapurna community.')

@push('styles')
<style>
    .feed-page-wrapper {
        background: #f4f6f9;
        min-height: 100vh;
        padding: 40px 0 60px;
    }

    .feed-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 28px;
        align-items: start;
    }

    @media (max-width: 991px) {
        .feed-layout {
            grid-template-columns: 1fr;
        }
        .feed-sidebar {
            order: -1;
        }
    }

    /* Create Post Area */
    .feed-create-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        padding: 20px;
        margin-bottom: 20px;
    }

    .feed-create-trigger {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .feed-create-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #c8a96e;
        color: #fff;
        font-size: 16px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
    }

    .feed-create-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .feed-create-btn {
        flex: 1;
        background: #f4f6f9;
        border: 1px solid #e0e0e0;
        border-radius: 24px;
        padding: 12px 20px;
        text-align: left;
        color: #888;
        cursor: pointer;
        font-size: 14px;
        font-family: 'Poppins', sans-serif;
        transition: all 0.2s;
    }

    .feed-create-btn:hover {
        background: #eef0f3;
        border-color: #c8a96e;
        color: #555;
    }

    .feed-create-actions {
        display: flex;
        gap: 8px;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px solid #f0f0f0;
    }

    .feed-type-shortcut {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border-radius: 8px;
        border: none;
        background: transparent;
        font-size: 13px;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        color: #555;
        transition: background 0.2s;
        text-decoration: none;
    }

    .feed-type-shortcut:hover {
        background: #f0f0f0;
        color: #333;
        text-decoration: none;
    }

    /* Sidebar Cards */
    .feed-sidebar-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        padding: 20px;
        margin-bottom: 20px;
    }

    .feed-sidebar-card h3 {
        font-size: 15px;
        font-weight: 600;
        color: #1a1a2e;
        margin: 0 0 16px;
        padding-bottom: 12px;
        border-bottom: 2px solid #c8a96e;
    }

    .trending-post-item {
        display: flex;
        gap: 10px;
        padding: 10px 0;
        border-bottom: 1px solid #f5f5f5;
        text-decoration: none;
        color: inherit;
    }

    .trending-post-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .trending-post-item:hover {
        color: #c8a96e;
        text-decoration: none;
    }

    .trending-post-num {
        font-size: 20px;
        font-weight: 800;
        color: #e0ddd8;
        line-height: 1;
        min-width: 24px;
    }

    .trending-post-info {
        flex: 1;
    }

    .trending-post-title {
        font-size: 13px;
        font-weight: 500;
        color: #333;
        line-height: 1.4;
        margin-bottom: 4px;
    }

    .trending-post-meta {
        font-size: 11px;
        color: #888;
    }

    /* Business follow items */
    .follow-business-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f5f5f5;
    }

    .follow-business-item:last-child {
        border-bottom: none;
    }

    .follow-business-avatar {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #1a1a2e;
        object-fit: cover;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #c8a96e;
        font-size: 14px;
        font-weight: 700;
        flex-shrink: 0;
        overflow: hidden;
    }

    .follow-business-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .follow-business-info {
        flex: 1;
        min-width: 0;
    }

    .follow-business-name {
        font-size: 13px;
        font-weight: 600;
        color: #1a1a2e;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .follow-business-type {
        font-size: 11px;
        color: #888;
        text-transform: capitalize;
    }

    .btn-follow {
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        border: 2px solid #c8a96e;
        background: #c8a96e;
        color: #fff;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .btn-follow.following {
        background: transparent;
        color: #c8a96e;
    }

    .btn-follow:hover {
        background: #b8924a;
        border-color: #b8924a;
        color: #fff;
    }

    /* Feed header */
    .feed-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .feed-header h1 {
        font-size: 22px;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }

    .feed-header p {
        font-size: 13px;
        color: #888;
        margin: 2px 0 0;
    }

    /* Empty state */
    .feed-empty {
        text-align: center;
        padding: 60px 20px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .feed-empty-icon {
        font-size: 48px;
        color: #ddd;
        margin-bottom: 16px;
    }

    .feed-empty h3 {
        font-size: 18px;
        color: #555;
        margin-bottom: 8px;
    }

    .feed-empty p {
        color: #888;
        font-size: 14px;
    }

    /* Stats mini */
    .feed-stats-mini {
        display: flex;
        gap: 16px;
    }

    .feed-stat-item {
        text-align: center;
    }

    .feed-stat-value {
        font-size: 22px;
        font-weight: 700;
        color: #c8a96e;
    }

    .feed-stat-label {
        font-size: 11px;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>
@endpush

@section('content')
    {{-- Page breadcrumb --}}
    @include('partials.breadcrumb', ['title' => 'Community Feed', 'items' => [['label' => 'Feed']]])

    <div class="feed-page-wrapper">
        <div class="container">
            <div class="feed-layout">

                {{-- ─── Left: Feed Posts ────────────────────────────────────── --}}
                <div class="feed-main">

                    @if(session('success'))
                        <div style="background:#d4edda;color:#155724;border:1px solid #c3e6cb;padding:12px 18px;border-radius:8px;margin-bottom:20px;font-size:14px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Create Post Card (auth only) --}}
                    @auth
                        <div class="feed-create-card">
                            <div class="feed-create-trigger">
                                <div class="feed-create-avatar">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                                    @else
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    @endif
                                </div>
                                <a href="{{ route('feed.create') }}" class="feed-create-btn">
                                    What's happening in the Annapurna region?
                                </a>
                            </div>
                            <div class="feed-create-actions">
                                <a href="{{ route('feed.create') }}?type=photo" class="feed-type-shortcut">
                                    <i class="ti-image" style="color:#3498db;"></i> Photo
                                </a>
                                <a href="{{ route('feed.create') }}?type=video" class="feed-type-shortcut">
                                    <i class="ti-video-camera" style="color:#9b59b6;"></i> Video
                                </a>
                                <a href="{{ route('feed.create') }}?type=announcement" class="feed-type-shortcut">
                                    <i class="ti-announcement" style="color:#e67e22;"></i> Announce
                                </a>
                                <a href="{{ route('feed.create') }}?type=offer" class="feed-type-shortcut">
                                    <i class="ti-tag" style="color:#27ae60;"></i> Offer
                                </a>
                            </div>
                        </div>
                    @endauth

                    {{-- Posts List --}}
                    @if($posts->count() > 0)
                        @foreach($posts as $post)
                            @include('feed.partials.post-card', ['post' => $post])
                        @endforeach

                        <div style="margin-top: 24px; text-align: center;">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <div class="feed-empty">
                            <div class="feed-empty-icon"><i class="ti-layout-list-post"></i></div>
                            <h3>No posts yet</h3>
                            <p>Be the first to share something with the community!</p>
                            @auth
                                <a href="{{ route('feed.create') }}" class="btn btn-primary" style="margin-top:16px;background:#c8a96e;border-color:#c8a96e;">
                                    Create Your First Post
                                </a>
                            @endauth
                        </div>
                    @endif

                </div>

                {{-- ─── Right: Sidebar ──────────────────────────────────────── --}}
                <aside class="feed-sidebar">

                    {{-- Auth user stats --}}
                    @auth
                        <div class="feed-sidebar-card">
                            <h3>Your Activity</h3>
                            <div class="feed-stats-mini">
                                <div class="feed-stat-item">
                                    <div class="feed-stat-value">{{ $likedCount }}</div>
                                    <div class="feed-stat-label">Liked</div>
                                </div>
                                <div class="feed-stat-item">
                                    <div class="feed-stat-value">{{ $savedCount }}</div>
                                    <div class="feed-stat-label">Saved</div>
                                </div>
                                <div class="feed-stat-item">
                                    <div class="feed-stat-value">{{ auth()->user()->feedPosts()->count() }}</div>
                                    <div class="feed-stat-label">Posts</div>
                                </div>
                            </div>
                            <div style="margin-top:14px;padding-top:14px;border-top:1px solid #f0f0f0;">
                                <a href="{{ route('dashboard.feed.index') }}" style="font-size:13px;color:#c8a96e;text-decoration:none;">
                                    Manage My Posts &rarr;
                                </a>
                            </div>
                        </div>
                    @endauth

                    {{-- Trending This Week --}}
                    @if($trendingPosts->count() > 0)
                        <div class="feed-sidebar-card">
                            <h3>Trending This Week</h3>
                            @foreach($trendingPosts as $i => $tp)
                                <a href="{{ route('feed.show', $tp->id) }}" class="trending-post-item">
                                    <div class="trending-post-num">{{ $i + 1 }}</div>
                                    <div class="trending-post-info">
                                        <div class="trending-post-title">
                                            {{ $tp->title ?: \Illuminate\Support\Str::limit(strip_tags($tp->content), 60) }}
                                        </div>
                                        <div class="trending-post-meta">
                                            <i class="ti-heart"></i> {{ $tp->likes_count }}
                                            &bull; <i class="ti-comment"></i> {{ $tp->comments_count }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif

                    {{-- Follow Businesses --}}
                    @if($featuredBusinesses->count() > 0)
                        <div class="feed-sidebar-card">
                            <h3>Follow Businesses</h3>
                            @foreach($featuredBusinesses as $biz)
                                <div class="follow-business-item">
                                    <div class="follow-business-avatar">
                                        @if($biz->cover_photo)
                                            <img src="{{ asset('storage/' . $biz->cover_photo) }}" alt="{{ $biz->name }}">
                                        @else
                                            {{ strtoupper(substr($biz->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div class="follow-business-info">
                                        <div class="follow-business-name">{{ $biz->name }}</div>
                                        <div class="follow-business-type">{{ str_replace('_', ' ', $biz->type) }}</div>
                                    </div>
                                    @auth
                                        <button class="btn-follow follow-business-btn {{ auth()->user()->followedBusinesses()->where('business_id', $biz->id)->exists() ? 'following' : '' }}"
                                                data-business-id="{{ $biz->id }}"
                                                data-follow-url="{{ route('business.follow', $biz->id) }}">
                                            {{ auth()->user()->followedBusinesses()->where('business_id', $biz->id)->exists() ? 'Following' : 'Follow' }}
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}" class="btn-follow">Follow</a>
                                    @endauth
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Share Feed --}}
                    <div class="feed-sidebar-card">
                        <h3>Share This Feed</h3>
                        <p style="font-size:13px;color:#888;margin:0 0 14px;">Help others discover the Annapurna community!</p>
                        <div style="display:flex;gap:8px;flex-wrap:wrap;">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('feed.index')) }}"
                               target="_blank" rel="noopener"
                               style="background:#3b5998;color:#fff;padding:7px 14px;border-radius:6px;font-size:12px;text-decoration:none;">
                                <i class="ti-facebook"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('feed.index')) }}&text={{ urlencode('Discover the Annapurna community feed!') }}"
                               target="_blank" rel="noopener"
                               style="background:#1da1f2;color:#fff;padding:7px 14px;border-radius:6px;font-size:12px;text-decoration:none;">
                                <i class="ti-twitter-alt"></i> Twitter
                            </a>
                        </div>
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

    // ─── Like Buttons ──────────────────────────────────────────────────────
    document.querySelectorAll('.feed-like-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (!{{ auth()->check() ? 'true' : 'false' }}) {
                window.location.href = '{{ route('login') }}';
                return;
            }
            const url = btn.dataset.url;
            const countEl = btn.querySelector('.feed-count');
            btn.disabled = true;

            fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.liked) {
                    btn.classList.add('liked');
                } else {
                    btn.classList.remove('liked');
                }
                if (countEl) countEl.textContent = data.count;
                // Brief animation
                btn.classList.add('feed-btn-pulse');
                setTimeout(() => btn.classList.remove('feed-btn-pulse'), 300);
            })
            .finally(() => { btn.disabled = false; });
        });
    });

    // ─── Save Buttons ──────────────────────────────────────────────────────
    document.querySelectorAll('.feed-save-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (!{{ auth()->check() ? 'true' : 'false' }}) {
                window.location.href = '{{ route('login') }}';
                return;
            }
            const url = btn.dataset.url;
            btn.disabled = true;

            fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.saved) {
                    btn.classList.add('saved');
                    btn.title = 'Saved';
                } else {
                    btn.classList.remove('saved');
                    btn.title = 'Save';
                }
            })
            .finally(() => { btn.disabled = false; });
        });
    });

    // ─── Comment Toggle ────────────────────────────────────────────────────
    document.querySelectorAll('.feed-comment-toggle').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const postId = btn.dataset.postId;
            const section = document.getElementById('comments-' + postId);
            if (!section) return;

            if (section.style.display === 'none' || section.style.display === '') {
                section.style.display = 'block';
                if (!section.dataset.loaded) {
                    loadComments(postId, section);
                }
            } else {
                section.style.display = 'none';
            }
        });
    });

    function loadComments(postId, section) {
        const url = '/feed/' + postId + '/comments';
        section.innerHTML = '<div style="text-align:center;padding:20px;color:#aaa;font-size:13px;"><i class="ti-reload"></i> Loading...</div>';
        fetch(url, { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(data => {
            section.innerHTML = data.html;
            section.dataset.loaded = '1';
            attachCommentForms(section, postId);
        });
    }

    // ─── Comment Submit (inline) ───────────────────────────────────────────
    document.querySelectorAll('.feed-comment-form').forEach(function(form) {
        setupCommentForm(form);
    });

    function attachCommentForms(container, postId) {
        container.querySelectorAll('.feed-comment-form').forEach(function(form) {
            setupCommentForm(form);
        });
        // Reply toggles
        container.querySelectorAll('.reply-toggle-btn').forEach(function(btn) {
            setupReplyToggle(btn);
        });
        // Delete buttons
        container.querySelectorAll('.comment-delete-btn').forEach(function(btn) {
            setupCommentDelete(btn);
        });
    }

    function setupCommentForm(form) {
        if (form.dataset.bound) return;
        form.dataset.bound = '1';
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const postId = form.dataset.postId;
            const url = '/feed/' + postId + '/comments';
            const content = form.querySelector('textarea').value.trim();
            const parentId = form.querySelector('input[name="parent_id"]') ? form.querySelector('input[name="parent_id"]').value : '';
            if (!content) return;

            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;

            fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' },
                body: JSON.stringify({ content: content, parent_id: parentId || null })
            })
            .then(r => r.json())
            .then(data => {
                if (data.html) {
                    const list = form.closest('.comment-section') ?
                        form.closest('.comment-section').querySelector('.comments-list') :
                        document.querySelector('#comments-' + postId + ' .comments-list');
                    if (list) {
                        list.insertAdjacentHTML('afterbegin', data.html);
                    }
                    form.querySelector('textarea').value = '';
                    // Update count
                    const countEl = document.querySelector('.feed-comment-toggle[data-post-id="' + postId + '"] .feed-count');
                    if (countEl) countEl.textContent = data.count;
                }
            })
            .finally(() => { submitBtn.disabled = false; });
        });
    }

    function setupReplyToggle(btn) {
        if (btn.dataset.bound) return;
        btn.dataset.bound = '1';
        btn.addEventListener('click', function() {
            const replyForm = btn.nextElementSibling;
            if (replyForm && replyForm.classList.contains('reply-form')) {
                replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
            }
        });
    }

    function setupCommentDelete(btn) {
        if (btn.dataset.bound) return;
        btn.dataset.bound = '1';
        btn.addEventListener('click', function() {
            if (!confirm('Delete this comment?')) return;
            const url = btn.dataset.url;
            fetch(url, {
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
    }

    // ─── Follow Business Buttons ───────────────────────────────────────────
    document.querySelectorAll('.follow-business-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const url = btn.dataset.followUrl;
            btn.disabled = true;
            fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.following) {
                    btn.classList.add('following');
                    btn.textContent = 'Following';
                } else {
                    btn.classList.remove('following');
                    btn.textContent = 'Follow';
                }
            })
            .finally(() => { btn.disabled = false; });
        });
    });

    // ─── View Tracking (IntersectionObserver) ─────────────────────────────
    if ('IntersectionObserver' in window) {
        const viewedKey = 'feed_viewed';
        let viewedSet = new Set(JSON.parse(localStorage.getItem(viewedKey) || '[]'));

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const postId = entry.target.dataset.postId;
                    if (postId && !viewedSet.has(postId)) {
                        viewedSet.add(postId);
                        localStorage.setItem(viewedKey, JSON.stringify([...viewedSet]));
                        fetch('/feed/' + postId + '/view', {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
                        });
                        observer.unobserve(entry.target);
                    }
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('.feed-post-card[data-post-id]').forEach(function(el) {
            observer.observe(el);
        });
    }

    // ─── Share Dropdown ────────────────────────────────────────────────────
    document.querySelectorAll('.feed-share-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = btn.nextElementSibling;
            if (!dropdown) return;
            document.querySelectorAll('.feed-share-dropdown').forEach(function(d) {
                if (d !== dropdown) d.style.display = 'none';
            });
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });
    });

    document.querySelectorAll('.share-option').forEach(function(opt) {
        opt.addEventListener('click', function() {
            const platform = opt.dataset.platform;
            const url = opt.dataset.shareUrl;
            const trackUrl = opt.dataset.trackUrl;
            const postUrl = opt.dataset.postUrl;

            if (platform === 'copy') {
                navigator.clipboard.writeText(postUrl).then(function() {
                    opt.textContent = 'Copied!';
                    setTimeout(() => { opt.textContent = 'Copy Link'; }, 2000);
                });
            } else if (platform === 'whatsapp') {
                window.open('https://wa.me/?text=' + encodeURIComponent(postUrl), '_blank');
            } else if (platform === 'facebook') {
                window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(postUrl), '_blank');
            } else if (platform === 'twitter') {
                window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(postUrl), '_blank');
            }

            // Track share
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

    // Close dropdowns on outside click
    document.addEventListener('click', function() {
        document.querySelectorAll('.feed-share-dropdown').forEach(function(d) {
            d.style.display = 'none';
        });
    });

})();
</script>
@endpush
