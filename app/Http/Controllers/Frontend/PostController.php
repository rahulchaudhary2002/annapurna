<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogView;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostReport;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $query = Post::published()->with('category', 'author');

        $blogType = $request->input('type');
        if (in_array($blogType, ['official', 'guest', 'business'])) {
            $query->where('blog_type', $blogType);
        }
        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }
        if ($request->filled('tag')) {
            $query->whereHas('tags', fn ($q) => $q->where('slug', $request->tag));
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn ($q) => $q->where('title', 'like', "%{$search}%")
                ->orWhere('excerpt', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%"));
        }

        $posts = $query->latest('published_at')->paginate(9);
        $categories = Category::ofType('post')->active()->withCount('posts')->get();
        $tags = Tag::ofType('post')->get();
        $featuredPosts = Post::published()->featured()->latest('published_at')->limit(3)->get();

        return view('frontend.blog.index', compact('posts', 'categories', 'tags', 'featuredPosts'));
    }

    public function show(string $slug): View
    {
        $post = Post::where('slug', $slug)->published()->with('category', 'tags', 'author')->firstOrFail();
        $post->incrementViews();

        // Track blog view — deduplicated per post + IP + day
        BlogView::insertOrIgnore([
            'post_id'    => $post->id,
            'user_id'    => auth()->id(),
            'ip_address' => request()->ip(),
            'viewed_on'  => Carbon::today()->toDateString(),
            'created_at' => Carbon::now(),
        ]);

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->when($post->category_id, fn ($q) => $q->where('category_id', $post->category_id))
            ->latest('published_at')
            ->limit(3)
            ->get();

        $prevPost = Post::published()->where('id', '<', $post->id)->latest('id')->first();
        $nextPost = Post::published()->where('id', '>', $post->id)->oldest('id')->first();

        return view('frontend.blog.show', compact('post', 'relatedPosts', 'prevPost', 'nextPost'));
    }

    public function report(Request $request, string $slug): RedirectResponse
    {
        $post = Post::where('slug', $slug)->published()->firstOrFail();

        $validated = $request->validate([
            'reason'  => ['required', 'in:spam,inappropriate,misleading,copyright,other'],
            'details' => ['nullable', 'string', 'max:500'],
        ]);

        PostReport::create([
            'post_id'    => $post->id,
            'user_id'    => auth()->id(),
            'reason'     => $validated['reason'],
            'details'    => $validated['details'] ?? null,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Thank you — your report has been submitted.');
    }
}
