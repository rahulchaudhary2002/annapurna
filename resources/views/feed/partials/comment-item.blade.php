@php $authUser = auth()->user(); @endphp

<div class="comment-item" id="comment-{{ $comment->id }}" style="display:flex;gap:10px;margin-bottom:14px;">
    <div style="width:32px;height:32px;border-radius:50%;background:#c8a96e;color:#fff;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;">
        @if($comment->author && $comment->author->avatar)
            <img src="{{ asset('storage/' . $comment->author->avatar) }}" alt="" style="width:100%;height:100%;object-fit:cover;">
        @else
            {{ strtoupper(substr($comment->author ? $comment->author->name : 'U', 0, 1)) }}
        @endif
    </div>
    <div style="flex:1;">
        <div style="background:#f8f8f8;border-radius:8px;padding:10px 14px;">
            <div style="font-size:13px;font-weight:600;color:#1a1a2e;margin-bottom:3px;">
                {{ $comment->author ? $comment->author->name : 'Deleted User' }}
            </div>
            <div style="font-size:13px;color:#444;line-height:1.6;">{{ $comment->content }}</div>
        </div>
        <div style="display:flex;align-items:center;gap:12px;margin-top:5px;padding:0 4px;">
            <span style="font-size:11px;color:#aaa;">{{ $comment->created_at->diffForHumans() }}</span>
            @auth
                <button class="reply-toggle-btn" style="font-size:12px;color:#c8a96e;background:none;border:none;cursor:pointer;padding:0;font-family:'Poppins',sans-serif;">
                    Reply
                </button>
            @endauth
            @if($authUser && ($comment->user_id === $authUser->id || ($post->user_id === $authUser->id)))
                <button class="comment-delete-btn"
                        data-url="{{ route('feed.comments.destroy', [$post->id, $comment->id]) }}"
                        style="font-size:12px;color:#e74c3c;background:none;border:none;cursor:pointer;padding:0;font-family:'Poppins',sans-serif;">
                    Delete
                </button>
            @endif
        </div>

        {{-- Reply form (hidden by default) --}}
        @auth
            <div class="reply-form" style="display:none;margin-top:10px;">
                <form class="feed-comment-form" data-post-id="{{ $post->id }}">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <div style="display:flex;gap:8px;align-items:flex-start;">
                        <textarea name="content" rows="2" placeholder="Write a reply..." required
                            style="flex:1;padding:8px 12px;border:1px solid #e0e0e0;border-radius:8px;font-size:12px;font-family:'Poppins',sans-serif;resize:none;outline:none;"
                            onfocus="this.style.borderColor='#c8a96e'" onblur="this.style.borderColor='#e0e0e0'"></textarea>
                        <button type="submit"
                            style="background:#c8a96e;color:#fff;border:none;padding:8px 14px;border-radius:6px;font-size:12px;cursor:pointer;white-space:nowrap;">
                            Reply
                        </button>
                    </div>
                </form>
            </div>
        @endauth

        {{-- Nested replies --}}
        @if($comment->replies && $comment->replies->count() > 0)
            <div style="margin-top:10px;margin-left:10px;padding-left:14px;border-left:2px solid #f0f0f0;">
                @foreach($comment->replies as $reply)
                    <div class="comment-item" id="comment-{{ $reply->id }}" style="display:flex;gap:8px;margin-bottom:10px;">
                        <div style="width:26px;height:26px;border-radius:50%;background:#c8a96e;color:#fff;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;">
                            @if($reply->author && $reply->author->avatar)
                                <img src="{{ asset('storage/' . $reply->author->avatar) }}" alt="" style="width:100%;height:100%;object-fit:cover;">
                            @else
                                {{ strtoupper(substr($reply->author ? $reply->author->name : 'U', 0, 1)) }}
                            @endif
                        </div>
                        <div style="flex:1;">
                            <div style="background:#f8f8f8;border-radius:8px;padding:8px 12px;">
                                <div style="font-size:12px;font-weight:600;color:#1a1a2e;margin-bottom:2px;">
                                    {{ $reply->author ? $reply->author->name : 'Deleted User' }}
                                </div>
                                <div style="font-size:12px;color:#444;line-height:1.6;">{{ $reply->content }}</div>
                            </div>
                            <div style="display:flex;align-items:center;gap:10px;margin-top:4px;padding:0 4px;">
                                <span style="font-size:11px;color:#aaa;">{{ $reply->created_at->diffForHumans() }}</span>
                                @if($authUser && ($reply->user_id === $authUser->id || ($post->user_id === $authUser->id)))
                                    <button class="comment-delete-btn"
                                            data-url="{{ route('feed.comments.destroy', [$post->id, $reply->id]) }}"
                                            style="font-size:11px;color:#e74c3c;background:none;border:none;cursor:pointer;padding:0;font-family:'Poppins',sans-serif;">
                                        Delete
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
