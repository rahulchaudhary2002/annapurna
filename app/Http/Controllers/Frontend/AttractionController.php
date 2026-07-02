<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Attraction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttractionController extends Controller
{
    public function index(Request $request): View
    {
        $query = Attraction::active();

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        $attractions = $query->get();

        return view('frontend.attractions.index', compact('attractions'));
    }

    public function show(string $slug): View
    {
        $attraction = Attraction::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $relatedAttractions = Attraction::where('is_active', true)
            ->where('id', '!=', $attraction->id)
            ->when($attraction->type, fn ($q) => $q->where('type', $attraction->type))
            ->orderBy('order')
            ->limit(3)
            ->get();

        return view('frontend.attractions.show', compact('attraction', 'relatedAttractions'));
    }
}
