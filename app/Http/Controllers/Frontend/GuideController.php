<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use Illuminate\View\View;

class GuideController extends Controller
{
    public function index(): View
    {
        $featured = Guide::active()->featured()->orderBy('order')->get();
        $guides   = Guide::active()->orderBy('order')->paginate(12);

        return view('frontend.guides.index', compact('featured', 'guides'));
    }

    public function show(string $slug): View
    {
        $guide   = Guide::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $related = Guide::active()
            ->where('id', '!=', $guide->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('frontend.guides.show', compact('guide', 'related'));
    }
}
