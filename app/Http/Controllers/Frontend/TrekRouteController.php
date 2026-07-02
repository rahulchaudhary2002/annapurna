<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TrekRoute;
use Illuminate\View\View;

class TrekRouteController extends Controller
{
    public function index(): View
    {
        $search = request('search');
        $trekRoutes = TrekRoute::active()
            ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('excerpt', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%"))
            ->paginate(12)
            ->withQueryString();

        return view('frontend.trek-routes.index', compact('trekRoutes', 'search'));
    }

    public function show(string $slug): View
    {
        $trekRoute = TrekRoute::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedTreks = TrekRoute::active()->where('id', '!=', $trekRoute->id)->limit(3)->get();
        return view('frontend.trek-routes.show', compact('trekRoute', 'relatedTreks'));
    }
}
