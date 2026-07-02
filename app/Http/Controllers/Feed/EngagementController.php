<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessFollow;
use App\Models\FeedPost;
use App\Models\FeedPostLike;
use App\Models\FeedPostSave;
use App\Models\FeedPostShare;
use App\Models\FeedPostView;
use App\Models\PostEngagement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EngagementController extends Controller
{
    public function toggleLike(FeedPost $post): JsonResponse
    {
        $user = auth()->user();

        $existing = FeedPostLike::where('feed_post_id', $post->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $post->decrement('likes_count');
            $liked  = false;
            $action = 'unlike';
        } else {
            FeedPostLike::create(['feed_post_id' => $post->id, 'user_id' => $user->id]);
            $post->increment('likes_count');
            $liked  = true;
            $action = 'like';
        }

        PostEngagement::insert([
            'post_id'    => $post->id,
            'post_type'  => 'feed_post',
            'action'     => $action,
            'user_id'    => $user->id,
            'ip_address' => request()->ip(),
            'created_at' => Carbon::now(),
        ]);

        return response()->json([
            'liked' => $liked,
            'count' => $post->fresh()->likes_count,
        ]);
    }

    public function toggleSave(FeedPost $post): JsonResponse
    {
        $user = auth()->user();

        $existing = FeedPostSave::where('feed_post_id', $post->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $post->decrement('saves_count');
            $saved  = false;
            $action = 'unsave';
        } else {
            FeedPostSave::create(['feed_post_id' => $post->id, 'user_id' => $user->id]);
            $post->increment('saves_count');
            $saved  = true;
            $action = 'save';
        }

        PostEngagement::insert([
            'post_id'    => $post->id,
            'post_type'  => 'feed_post',
            'action'     => $action,
            'user_id'    => $user->id,
            'ip_address' => request()->ip(),
            'created_at' => Carbon::now(),
        ]);

        return response()->json([
            'saved' => $saved,
            'count' => $post->fresh()->saves_count,
        ]);
    }

    public function trackShare(Request $request, FeedPost $post): JsonResponse
    {
        $platform = $request->input('platform');

        FeedPostShare::create([
            'feed_post_id' => $post->id,
            'user_id'      => auth()->id(),
            'platform'     => $platform,
        ]);

        $post->increment('shares_count');

        PostEngagement::insert([
            'post_id'    => $post->id,
            'post_type'  => 'feed_post',
            'action'     => 'share',
            'user_id'    => auth()->id(),
            'ip_address' => $request->ip(),
            'created_at' => Carbon::now(),
        ]);

        return response()->json([
            'shared' => true,
            'count'  => $post->fresh()->shares_count,
        ]);
    }

    public function trackView(Request $request, FeedPost $post): JsonResponse
    {
        $userId = auth()->id();
        $ip     = $request->ip();

        $recentView = FeedPostView::where('feed_post_id', $post->id)
            ->where(function ($q) use ($userId, $ip) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('ip_address', $ip);
                }
            })
            ->where('created_at', '>=', now()->subHour())
            ->first();

        if (! $recentView) {
            FeedPostView::create([
                'feed_post_id' => $post->id,
                'user_id'      => $userId,
                'ip_address'   => $ip,
            ]);
            $post->increment('views_count');
        }

        return response()->json([
            'tracked' => true,
            'count'   => $post->fresh()->views_count,
        ]);
    }

    public function toggleFollow(Business $business): JsonResponse
    {
        $user = auth()->user();

        $existing = BusinessFollow::where('user_id', $user->id)
            ->where('business_id', $business->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $following = false;
        } else {
            BusinessFollow::create([
                'user_id'     => $user->id,
                'business_id' => $business->id,
            ]);
            $following = true;
        }

        return response()->json([
            'following' => $following,
            'count'     => $business->fresh()->followers()->count(),
        ]);
    }
}
