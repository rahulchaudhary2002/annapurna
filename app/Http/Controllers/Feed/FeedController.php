<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\FeedPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user) {
            $followedIds = $user->followedBusinesses()->pluck('business_id')->toArray();
            $followedIdsStr = empty($followedIds) ? '0' : implode(',', $followedIds);

            $posts = FeedPost::published()
                ->select('feed_posts.*')
                ->selectRaw('
                    (feed_posts.likes_count * 3 + feed_posts.comments_count * 2 + feed_posts.saves_count * 2 + feed_posts.views_count * 0.01
                    + CASE WHEN feed_posts.business_id IN (' . $followedIdsStr . ') THEN 20 ELSE 0 END
                    + CASE WHEN feed_posts.created_at > ? THEN 10 ELSE 0 END
                    + CASE WHEN feed_posts.is_sponsored = 1 AND (feed_posts.sponsored_until IS NULL OR feed_posts.sponsored_until > ?) THEN 50 ELSE 0 END
                    ) as feed_score
                ', [now()->subDay(), now()])
                ->with(['author', 'business'])
                ->orderByDesc('feed_score')
                ->orderByDesc('created_at')
                ->paginate(12);
        } else {
            $posts = FeedPost::published()
                ->selectRaw('feed_posts.*, (likes_count * 3 + comments_count * 2 + views_count * 0.01) as feed_score')
                ->with(['author', 'business'])
                ->orderByDesc('feed_score')
                ->orderByDesc('created_at')
                ->paginate(12);
        }

        // Sidebar data
        $trendingPosts = FeedPost::trending()->limit(5)->get();
        $featuredBusinesses = Business::active()->featured()->limit(5)->get();

        $likedCount = $user ? $user->likedPosts()->count() : 0;
        $savedCount = $user ? $user->savedPosts()->count() : 0;

        return view('feed.index', compact('posts', 'user', 'trendingPosts', 'featuredBusinesses', 'likedCount', 'savedCount'));
    }

    public function show(FeedPost $post)
    {
        if (!$post->is_published) {
            abort(404);
        }

        $comments = $post->comments()
            ->with(['author', 'replies.author'])
            ->whereNull('parent_id')
            ->orderBy('created_at', 'asc')
            ->get();

        $user = auth()->user();

        $isLiked = $user ? $post->isLikedBy($user) : false;
        $isSaved = $user ? $post->isSavedBy($user) : false;

        return view('feed.show', compact('post', 'comments', 'user', 'isLiked', 'isSaved'));
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        $businessId = $request->get('business_id');
        $selectedBusiness = null;

        if ($businessId) {
            $selectedBusiness = Business::find($businessId);
            if ($selectedBusiness) {
                $isOwner = $selectedBusiness->user_id === $user->id;
                $isManager = $user->businessMemberships()
                    ->where('business_id', $businessId)
                    ->whereIn('role', ['owner', 'manager'])
                    ->exists();

                if (!$isOwner && !$isManager) {
                    abort(403, 'You are not authorized to post for this business.');
                }
            }
        }

        $userBusinesses = $user->businessMemberships()
            ->with('business')
            ->whereIn('role', ['owner', 'manager'])
            ->get()
            ->pluck('business');

        $ownedBusinesses = $user->ownedBusinesses()->get();

        $postableBusinesses = $ownedBusinesses->merge($userBusinesses)->unique('id');

        return view('feed.create', compact('user', 'postableBusinesses', 'selectedBusiness'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'type'             => 'required|in:text,photo,video,link,announcement,offer',
            'title'            => 'nullable|string|max:255',
            'content'          => 'nullable|string|max:5000',
            'business_id'      => 'nullable|exists:businesses,id',
            'video_url'        => 'nullable|string|max:500',
            'link_url'         => 'nullable|url|max:500',
            'link_title'       => 'nullable|string|max:255',
            'link_description' => 'nullable|string|max:500',
            'media.*'          => 'nullable|image|max:5120',
            'video_file'       => 'nullable|file|mimes:mp4,webm,ogg|max:51200',
        ]);

        // Verify business ownership if posting as business
        if (!empty($validated['business_id'])) {
            $business = Business::findOrFail($validated['business_id']);
            $isOwner = $business->user_id === $user->id;
            $isManager = $user->businessMemberships()
                ->where('business_id', $business->id)
                ->whereIn('role', ['owner', 'manager'])
                ->exists();

            if (!$isOwner && !$isManager) {
                abort(403, 'You are not authorized to post for this business.');
            }
        }

        // Handle media uploads
        $mediaPaths = [];
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('feed_media', 'public');
                $mediaPaths[] = $path;
            }
        }

        // Handle video file upload
        $videoUrl = $validated['video_url'] ?? null;
        if ($request->hasFile('video_file')) {
            $videoUrl = $request->file('video_file')->store('feed_media/videos', 'public');
        }

        $post = FeedPost::create([
            'user_id'          => $user->id,
            'business_id'      => $validated['business_id'] ?? null,
            'type'             => $validated['type'],
            'title'            => $validated['title'] ?? null,
            'content'          => $validated['content'] ?? null,
            'media'            => !empty($mediaPaths) ? $mediaPaths : null,
            'video_url'        => $videoUrl,
            'link_url'         => $validated['link_url'] ?? null,
            'link_title'       => $validated['link_title'] ?? null,
            'link_description' => $validated['link_description'] ?? null,
            'is_published'     => true,
            'published_at'     => now(),
        ]);

        return redirect()->route('feed.index')->with('success', 'Post created successfully!');
    }

    public function edit(FeedPost $post)
    {
        $user = auth()->user();
        $this->authorizePostAccess($post, $user);

        $userBusinesses = $user->businessMemberships()
            ->with('business')
            ->whereIn('role', ['owner', 'manager'])
            ->get()
            ->pluck('business');

        $ownedBusinesses = $user->ownedBusinesses()->get();
        $postableBusinesses = $ownedBusinesses->merge($userBusinesses)->unique('id');

        return view('feed.edit', compact('post', 'user', 'postableBusinesses'));
    }

    public function update(Request $request, FeedPost $post)
    {
        $user = auth()->user();
        $this->authorizePostAccess($post, $user);

        $validated = $request->validate([
            'title'            => 'nullable|string|max:255',
            'content'          => 'nullable|string|max:5000',
            'video_url'        => 'nullable|string|max:500',
            'link_url'         => 'nullable|url|max:500',
            'link_title'       => 'nullable|string|max:255',
            'link_description' => 'nullable|string|max:500',
            'media.*'          => 'nullable|image|max:5120',
        ]);

        // Handle new media uploads
        $mediaPaths = $post->media ?? [];
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('feed_media', 'public');
                $mediaPaths[] = $path;
            }
        }

        $post->update([
            'title'            => $validated['title'] ?? $post->title,
            'content'          => $validated['content'] ?? $post->content,
            'media'            => !empty($mediaPaths) ? $mediaPaths : $post->media,
            'video_url'        => $validated['video_url'] ?? $post->video_url,
            'link_url'         => $validated['link_url'] ?? $post->link_url,
            'link_title'       => $validated['link_title'] ?? $post->link_title,
            'link_description' => $validated['link_description'] ?? $post->link_description,
        ]);

        return redirect()->route('feed.show', $post->id)->with('success', 'Post updated successfully!');
    }

    public function destroy(FeedPost $post)
    {
        $user = auth()->user();
        $this->authorizePostAccess($post, $user);

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

        return redirect()->route('feed.index')->with('success', 'Post deleted successfully.');
    }

    protected function authorizePostAccess(FeedPost $post, $user): void
    {
        $isAuthor = $post->user_id === $user->id;
        $isBusinessOwner = $post->business_id &&
            Business::where('id', $post->business_id)->where('user_id', $user->id)->exists();

        if (!$isAuthor && !$isBusinessOwner) {
            abort(403, 'You are not authorized to modify this post.');
        }
    }
}
