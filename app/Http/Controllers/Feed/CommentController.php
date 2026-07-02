<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Models\FeedPost;
use App\Models\FeedPostComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(FeedPost $post): JsonResponse
    {
        $comments = $post->comments()
            ->with(['author', 'replies' => function ($q) {
                $q->where('is_published', true)->with('author');
            }])
            ->whereNull('parent_id')
            ->orderBy('created_at', 'asc')
            ->get();

        $html = view('feed.partials.comments', compact('comments', 'post'))->render();

        return response()->json(['html' => $html, 'count' => $post->comments_count]);
    }

    public function store(Request $request, FeedPost $post): JsonResponse
    {
        $validated = $request->validate([
            'content'   => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:feed_post_comments,id',
        ]);

        $comment = FeedPostComment::create([
            'feed_post_id' => $post->id,
            'user_id'      => auth()->id(),
            'parent_id'    => $validated['parent_id'] ?? null,
            'content'      => $validated['content'],
            'is_published' => true,
        ]);

        $post->increment('comments_count');

        $comment->load('author');

        $html = view('feed.partials.comment-item', compact('comment', 'post'))->render();

        return response()->json([
            'html'  => $html,
            'count' => $post->fresh()->comments_count,
        ]);
    }

    public function destroy(FeedPost $post, FeedPostComment $comment): JsonResponse
    {
        $user = auth()->user();

        $isCommentOwner = $comment->user_id === $user->id;
        $isPostOwner = $post->user_id === $user->id;

        if (!$isCommentOwner && !$isPostOwner) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment->delete();
        $post->decrement('comments_count');

        return response()->json([
            'deleted' => true,
            'count'   => $post->fresh()->comments_count,
        ]);
    }
}
