<?php

namespace App\Http\Controllers\GGF;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use App\Models\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        $page     = Page::where('slug', 'ggf-about')->published()->first();
        $counters = Counter::active()->where('order', '>=', 100)->get();

        return view('ggf.about', compact('page', 'counters'));
    }

    public function history(): View
    {
        $page = Page::where('slug', 'ggf-history')->published()->first();

        return view('ggf.history', compact('page'));
    }

    public function show(string $slug): View
    {
        $page = Page::where('slug', 'ggf-' . $slug)->published()->firstOrFail();

        return view('ggf.page', compact('page'));
    }
}
