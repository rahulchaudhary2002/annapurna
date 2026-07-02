<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\FeedPost;
use Illuminate\Support\Facades\Storage;

class UserFeedController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get the user's own posts and business posts they manage
        $businessIds = $user->ownedBusinesses()->pluck('id')->toArray();

        $posts = FeedPost::where(function ($q) use ($user, $businessIds) {
            $q->where('user_id', $user->id);
            if (!empty($businessIds)) {
                $q->orWhereIn('business_id', $businessIds);
            }
        })
        ->with('business')
        ->orderByDesc('created_at')
        ->paginate(15);

        return view('dashboard.feed.index', compact('posts', 'user'));
    }

    public function destroy(FeedPost $post)
    {
        $user = auth()->user();

        $isAuthor = $post->user_id === $user->id;
        $isBusinessOwner = $post->business_id &&
            Business::where('id', $post->business_id)->where('user_id', $user->id)->exists();

        if (!$isAuthor && !$isBusinessOwner) {
            abort(403);
        }

        // Delete media files
        if ($post->media) {
            foreach ($post->media as $path) {
                Storage::disk('public')->delete($path);
            }
        }
        if ($post->link_image) {
            Storage::disk('public')->delete($post->link_image);
        }
        if ($post->video_url && !str_starts_with($post->video_url, 'http')) {
            Storage::disk('public')->delete($post->video_url);
        }

        $post->delete();

        return redirect()->route('dashboard.feed.index')->with('success', 'Post deleted successfully.');
    }
}
