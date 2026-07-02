<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BusinessPostController extends Controller
{
    protected function authorizeMember(Business $business): void
    {
        $userId = auth()->id();
        $isMember = $business->members()->where('user_id', $userId)->exists();
        abort_if(!$isMember && $business->user_id !== $userId, 403);
    }

    public function index(Business $business)
    {
        $this->authorizeMember($business);

        $posts = $business->businessPosts()->latest()->paginate(15);

        return view('dashboard.businesses.posts.index', compact('business', 'posts'));
    }

    public function create(Business $business)
    {
        $this->authorizeMember($business);

        return view('dashboard.businesses.posts.create', compact('business'));
    }

    public function store(Request $request, Business $business)
    {
        $this->authorizeMember($business);

        $request->validate([
            'type'    => ['required', 'in:text,photo,link,video'],
            'title'   => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'media'   => ['nullable', 'image', 'max:4096'],
            'link'    => ['nullable', 'url', 'max:500'],
        ]);

        $data = $request->only('type', 'title', 'content', 'link');
        $data['business_id'] = $business->id;
        $data['user_id'] = auth()->id();
        $data['is_published'] = true;
        $data['published_at'] = now();

        if ($request->hasFile('media')) {
            $path = $request->file('media')->store('business-posts', 'public');
            $data['media'] = [$path];
        }

        BusinessPost::create($data);

        return redirect()->route('dashboard.businesses.posts.index', $business)
            ->with('success', 'Post created successfully!');
    }

    public function destroy(Business $business, BusinessPost $post)
    {
        $this->authorizeMember($business);

        if ($post->media) {
            foreach ($post->media as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $post->delete();

        return back()->with('success', 'Post deleted!');
    }
}
