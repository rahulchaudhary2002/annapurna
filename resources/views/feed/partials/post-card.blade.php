@php
    $authUser = auth()->user();
    $isLiked  = $authUser ? $post->isLikedBy($authUser) : false;
    $isSaved  = $authUser ? $post->isSavedBy($authUser) : false;
    $isOwner  = $authUser && ($post->user_id === $authUser->id || ($post->business_id && $post->business && $post->business->user_id === $authUser->id));
    $postUrl  = route('feed.show', $post->id);

    $typeBadges = [
        'text'         => ['label' => 'Post',         'color' => '#666',    'bg' => '#f0f0f0'],
        'photo'        => ['label' => 'Photo',         'color' => '#fff',    'bg' => '#3498db'],
        'video'        => ['label' => 'Video',         'color' => '#fff',    'bg' => '#9b59b6'],
        'link'         => ['label' => 'Link',          'color' => '#fff',    'bg' => '#16a085'],
        'announcement' => ['label' => 'Announcement',  'color' => '#fff',    'bg' => '#e67e22'],
        'offer'        => ['label' => 'Offer',         'color' => '#fff',    'bg' => '#27ae60'],
    ];
    $badge = $typeBadges[$post->type] ?? $typeBadges['text'];
@endphp

<article class="feed-post-card" data-post-id="{{ $post->id }}" style="background:#fff;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.06);margin-bottom:20px;overflow:hidden;position:relative;">

    @if($post->is_sponsored)
        <div style="position:absolute;top:12px;right:12px;background:#c8a96e;color:#fff;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;text-transform:uppercase;letter-spacing:0.5px;">
            Sponsored
        </div>
    @endif

    {{-- ─── Card Header ───────────────────────────────────────────────────── --}}
    <div style="padding:16px 20px 12px;display:flex;align-items:flex-start;gap:12px;">
        <a href="{{ $post->author_url }}" style="text-decoration:none;flex-shrink:0;">
            <div style="width:44px;height:44px;border-radius:50%;background:#c8a96e;color:#fff;font-size:16px;font-weight:700;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                @if($post->author_avatar)
                    <img src="{{ $post->author_avatar }}" alt="{{ $post->author_name }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                    {{ strtoupper(substr($post->author_name, 0, 1)) }}
                @endif
            </div>
        </a>
        <div style="flex:1;min-width:0;">
            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                <a href="{{ $post->author_url }}" style="font-size:14px;font-weight:600;color:#1a1a2e;text-decoration:none;">
                    {{ $post->author_name }}
                </a>
                <span style="background:{{ $badge['bg'] }};color:{{ $badge['color'] }};font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;text-transform:uppercase;letter-spacing:0.4px;">
                    {{ $badge['label'] }}
                </span>
            </div>
            <div style="font-size:12px;color:#aaa;margin-top:2px;">
                {{ $post->created_at->diffForHumans() }}
            </div>
        </div>

        {{-- Owner actions --}}
        @if($isOwner)
            <div style="display:flex;gap:6px;flex-shrink:0;">
                <a href="{{ route('feed.edit', $post->id) }}" title="Edit"
                   style="width:30px;height:30px;border-radius:6px;background:#f8f8f8;border:1px solid #eee;display:flex;align-items:center;justify-content:center;color:#777;text-decoration:none;font-size:13px;">
                    <i class="ti-pencil"></i>
                </a>
                <form method="POST" action="{{ route('feed.destroy', $post->id) }}" style="margin:0;" onsubmit="return confirm('Delete this post?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" title="Delete"
                            style="width:30px;height:30px;border-radius:6px;background:#fff0f0;border:1px solid #ffd5d5;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#e74c3c;font-size:13px;">
                        <i class="ti-trash"></i>
                    </button>
                </form>
            </div>
        @endif
    </div>

    {{-- ─── Card Body ─────────────────────────────────────────────────────── --}}
    <div style="padding:0 20px 16px;">

        {{-- Title --}}
        @if($post->title)
            @if($post->type === 'offer')
                <div style="background:linear-gradient(135deg,#27ae60,#2ecc71);color:#fff;padding:12px 16px;border-radius:8px;margin-bottom:12px;">
                    <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;opacity:0.85;margin-bottom:4px;">
                        <i class="ti-tag"></i> Special Offer
                    </div>
                    <div style="font-size:16px;font-weight:700;">{{ $post->title }}</div>
                </div>
            @elseif($post->type === 'announcement')
                <div style="background:linear-gradient(135deg,#e67e22,#f39c12);color:#fff;padding:12px 16px;border-radius:8px;margin-bottom:12px;">
                    <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;opacity:0.85;margin-bottom:4px;">
                        <i class="ti-announcement"></i> Announcement
                    </div>
                    <div style="font-size:16px;font-weight:700;">{{ $post->title }}</div>
                </div>
            @else
                <h3 style="font-size:16px;font-weight:600;color:#1a1a2e;margin:0 0 8px;">{{ $post->title }}</h3>
            @endif
        @endif

        {{-- Content text --}}
        @if($post->content)
            @php $contentLen = strlen($post->content); @endphp
            @if($contentLen > 200)
                <p style="font-size:14px;color:#444;line-height:1.7;margin:0 0 12px;" class="post-content-preview">
                    {{ \Illuminate\Support\Str::limit($post->content, 200) }}
                    <a href="{{ $postUrl }}" style="color:#c8a96e;text-decoration:none;font-weight:500;"> Read more</a>
                </p>
            @else
                <p style="font-size:14px;color:#444;line-height:1.7;margin:0 0 12px;">{{ $post->content }}</p>
            @endif
        @endif

        {{-- ─── Media: Photo ────────────────────────────────────────────── --}}
        @if($post->type === 'photo' && !empty($post->media))
            @php $photos = $post->media; $photoCount = count($photos); @endphp
            @if($photoCount === 1)
                <div style="border-radius:8px;overflow:hidden;margin-bottom:12px;">
                    <a href="{{ $postUrl }}">
                        <img src="{{ asset('storage/' . $photos[0]) }}" alt="Photo" style="width:100%;max-height:400px;object-fit:cover;display:block;">
                    </a>
                </div>
            @elseif($photoCount === 2)
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:4px;border-radius:8px;overflow:hidden;margin-bottom:12px;">
                    @foreach($photos as $photo)
                        <a href="{{ $postUrl }}">
                            <img src="{{ asset('storage/' . $photo) }}" alt="Photo" style="width:100%;height:200px;object-fit:cover;display:block;">
                        </a>
                    @endforeach
                </div>
            @else
                <div style="display:grid;grid-template-columns:2fr 1fr;grid-template-rows:auto auto;gap:4px;border-radius:8px;overflow:hidden;margin-bottom:12px;">
                    <a href="{{ $postUrl }}" style="grid-row:1/3;">
                        <img src="{{ asset('storage/' . $photos[0]) }}" alt="Photo" style="width:100%;height:260px;object-fit:cover;display:block;">
                    </a>
                    <a href="{{ $postUrl }}">
                        <img src="{{ asset('storage/' . $photos[1]) }}" alt="Photo" style="width:100%;height:128px;object-fit:cover;display:block;">
                    </a>
                    <a href="{{ $postUrl }}" style="position:relative;display:block;">
                        <img src="{{ asset('storage/' . $photos[2]) }}" alt="Photo" style="width:100%;height:128px;object-fit:cover;display:block;">
                        @if($photoCount > 3)
                            <div style="position:absolute;inset:0;background:rgba(0,0,0,0.55);display:flex;align-items:center;justify-content:center;color:#fff;font-size:20px;font-weight:700;">
                                +{{ $photoCount - 3 }}
                            </div>
                        @endif
                    </a>
                </div>
            @endif
        @endif

        {{-- ─── Media: Video ─────────────────────────────────────────────── --}}
        @if($post->type === 'video' && $post->video_url)
            @php
                $isYouTube = str_contains($post->video_url, 'youtube.com') || str_contains($post->video_url, 'youtu.be');
                $youtubeId = null;
                if ($isYouTube) {
                    preg_match('/(?:v=|youtu\.be\/)([A-Za-z0-9_\-]{11})/', $post->video_url, $m);
                    $youtubeId = $m[1] ?? null;
                }
            @endphp
            <div style="border-radius:8px;overflow:hidden;margin-bottom:12px;aspect-ratio:16/9;background:#000;">
                @if($isYouTube && $youtubeId)
                    <iframe
                        src="https://www.youtube.com/embed/{{ $youtubeId }}"
                        style="width:100%;height:100%;border:none;"
                        allowfullscreen
                        loading="lazy"
                        title="{{ $post->title ?? 'Video' }}">
                    </iframe>
                @elseif(!$isYouTube)
                    <video controls style="width:100%;height:100%;object-fit:cover;">
                        <source src="{{ asset('storage/' . $post->video_url) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif
            </div>
        @endif

        {{-- ─── Media: Link Preview ──────────────────────────────────────── --}}
        @if($post->type === 'link' && $post->link_url)
            @php $domain = parse_url($post->link_url, PHP_URL_HOST); @endphp
            <a href="{{ $post->link_url }}" target="_blank" rel="noopener noreferrer"
               style="display:block;border:1px solid #e8e8e8;border-radius:8px;overflow:hidden;text-decoration:none;margin-bottom:12px;transition:box-shadow 0.2s;"
               onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='none'">
                @if($post->link_image)
                    <img src="{{ asset('storage/' . $post->link_image) }}" alt="Link preview" style="width:100%;height:180px;object-fit:cover;display:block;">
                @endif
                <div style="padding:12px 14px;">
                    @if($domain)
                        <div style="font-size:11px;color:#aaa;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;">{{ $domain }}</div>
                    @endif
                    @if($post->link_title)
                        <div style="font-size:14px;font-weight:600;color:#1a1a2e;margin-bottom:4px;">{{ $post->link_title }}</div>
                    @endif
                    @if($post->link_description)
                        <div style="font-size:13px;color:#666;">{{ \Illuminate\Support\Str::limit($post->link_description, 120) }}</div>
                    @endif
                </div>
            </a>
        @endif
    </div>

    {{-- ─── Engagement Bar ────────────────────────────────────────────────── --}}
    <div style="padding:10px 20px 14px;border-top:1px solid #f5f5f5;display:flex;align-items:center;gap:4px;flex-wrap:wrap;">

        {{-- Like --}}
        <button class="feed-like-btn {{ $isLiked ? 'liked' : '' }}"
                data-url="{{ route('feed.like', $post->id) }}"
                title="{{ $isLiked ? 'Unlike' : 'Like' }}"
                style="display:flex;align-items:center;gap:5px;padding:7px 12px;border-radius:8px;border:none;background:transparent;cursor:pointer;font-size:13px;color:{{ $isLiked ? '#e74c3c' : '#666' }};font-family:'Poppins',sans-serif;transition:background 0.2s;"
                onmouseover="this.style.background='#f8f8f8'" onmouseout="this.style.background='transparent'">
            <i class="{{ $isLiked ? 'ti-heart' : 'ti-heart' }}" style="font-size:14px;color:{{ $isLiked ? '#e74c3c' : '#999' }};"></i>
            <span class="feed-count">{{ $post->likes_count }}</span>
        </button>

        {{-- Comment --}}
        <button class="feed-comment-toggle"
                data-post-id="{{ $post->id }}"
                style="display:flex;align-items:center;gap:5px;padding:7px 12px;border-radius:8px;border:none;background:transparent;cursor:pointer;font-size:13px;color:#666;font-family:'Poppins',sans-serif;transition:background 0.2s;"
                onmouseover="this.style.background='#f8f8f8'" onmouseout="this.style.background='transparent'">
            <i class="ti-comment" style="font-size:14px;color:#999;"></i>
            <span class="feed-count">{{ $post->comments_count }}</span>
        </button>

        {{-- Share --}}
        <div style="position:relative;">
            <button class="feed-share-btn"
                    style="display:flex;align-items:center;gap:5px;padding:7px 12px;border-radius:8px;border:none;background:transparent;cursor:pointer;font-size:13px;color:#666;font-family:'Poppins',sans-serif;transition:background 0.2s;"
                    onmouseover="this.style.background='#f8f8f8'" onmouseout="this.style.background='transparent'">
                <i class="ti-share" style="font-size:14px;color:#999;"></i>
                <span>{{ $post->shares_count }}</span>
            </button>
            <div class="feed-share-dropdown" style="display:none;position:absolute;bottom:100%;left:0;background:#fff;border:1px solid #e8e8e8;border-radius:8px;box-shadow:0 4px 16px rgba(0,0,0,0.12);min-width:160px;z-index:100;overflow:hidden;">
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

        {{-- Save (auth only) --}}
        @auth
            <button class="feed-save-btn {{ $isSaved ? 'saved' : '' }}"
                    data-url="{{ route('feed.save', $post->id) }}"
                    title="{{ $isSaved ? 'Saved' : 'Save' }}"
                    style="margin-left:auto;display:flex;align-items:center;gap:5px;padding:7px 12px;border-radius:8px;border:none;background:transparent;cursor:pointer;font-size:13px;color:{{ $isSaved ? '#c8a96e' : '#666' }};font-family:'Poppins',sans-serif;transition:background 0.2s;"
                    onmouseover="this.style.background='#f8f8f8'" onmouseout="this.style.background='transparent'">
                <i class="{{ $isSaved ? 'ti-bookmark-alt' : 'ti-bookmark' }}" style="font-size:14px;color:{{ $isSaved ? '#c8a96e' : '#999' }};"></i>
            </button>
        @endauth
    </div>

    {{-- ─── Inline Comments Section ────────────────────────────────────────── --}}
    <div id="comments-{{ $post->id }}" class="comment-section" style="display:none;border-top:1px solid #f5f5f5;">
        @auth
            <div style="padding:14px 20px 10px;">
                <form class="feed-comment-form" data-post-id="{{ $post->id }}">
                    @csrf
                    <div style="display:flex;gap:10px;align-items:flex-start;">
                        <div style="width:32px;height:32px;border-radius:50%;background:#c8a96e;color:#fff;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="" style="width:100%;height:100%;object-fit:cover;">
                            @else
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            @endif
                        </div>
                        <div style="flex:1;">
                            <textarea name="content" rows="2" placeholder="Write a comment..." required
                                style="width:100%;padding:8px 12px;border:1px solid #e0e0e0;border-radius:8px;font-size:13px;font-family:'Poppins',sans-serif;resize:none;outline:none;transition:border-color 0.2s;"
                                onfocus="this.style.borderColor='#c8a96e'" onblur="this.style.borderColor='#e0e0e0'"></textarea>
                            <div style="text-align:right;margin-top:6px;">
                                <button type="submit"
                                    style="background:#c8a96e;color:#fff;border:none;padding:7px 18px;border-radius:6px;font-size:13px;font-family:'Poppins',sans-serif;cursor:pointer;font-weight:500;">
                                    Post Comment
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @endauth
        <div class="comments-list" style="padding:0 20px 14px;">
            {{-- Comments loaded via AJAX --}}
        </div>
    </div>

</article>

<style>
.feed-like-btn.liked i { color: #e74c3c !important; }
.feed-save-btn.saved i { color: #c8a96e !important; }
@keyframes feedBtnPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}
.feed-btn-pulse i { animation: feedBtnPulse 0.3s ease; }
</style>
