<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(Request $request): View
    {
        $query = Activity::active();

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $activities = $query->get();

        return view('frontend.activities.index', compact('activities'));
    }

    public function show(string $slug): View
    {
        $activity = Activity::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $relatedActivities = Activity::where('is_active', true)
            ->where('id', '!=', $activity->id)
            ->when($activity->category, fn ($q) => $q->where('category', $activity->category))
            ->orderBy('order')
            ->limit(3)
            ->get();

        return view('frontend.activities.show', compact('activity', 'relatedActivities'));
    }
}
