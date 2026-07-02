<?php

namespace App\Http\Controllers\GGF;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(): View
    {
        $categories = Category::where('type', 'post')->where('is_active', true)->orderBy('order')->get();
        $postsByCategory = [];

        foreach ($categories as $cat) {
            $postsByCategory[$cat->id] = Post::published()
                ->where('category_id', $cat->id)
                ->latest('published_at')
                ->limit(4)
                ->get();
        }

        $allPosts = Post::published()->latest('published_at')->limit(8)->get();

        return view('ggf.programs', compact('categories', 'postsByCategory', 'allPosts'));
    }
}
