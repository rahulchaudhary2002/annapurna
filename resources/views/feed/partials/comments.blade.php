@forelse($comments as $comment)
    @include('feed.partials.comment-item', ['comment' => $comment, 'post' => $post])
@empty
    <div style="text-align:center;padding:20px;color:#aaa;font-size:13px;">
        No comments yet. Be the first to comment!
    </div>
@endforelse
