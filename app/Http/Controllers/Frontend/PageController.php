<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\View\View;

class PageController extends Controller
{
    public function show(string $slug): View
    {
        $page = Page::where('slug', $slug)->published()->firstOrFail();

        // Provide contextual data based on template
        $data = ['page' => $page];

        match ($page->template) {
            'about' => $data = array_merge($data, [
                'teamMembers'  => TeamMember::active()->get(),
                'counters'     => Counter::active()->get(),
                'partners'     => Partner::active()->get(),
                'testimonials' => Testimonial::active()->featured()->get(),
            ]),
            'annapurna-region' => $data = array_merge($data, [
                'destinations' => \App\Models\Destination::where('is_active', true)->orderBy('order')->limit(6)->get(),
                'trekRoutes'   => \App\Models\TrekRoute::where('is_active', true)->orderBy('order')->limit(4)->get(),
                'activities'   => \App\Models\Activity::active()->limit(4)->get(),
                'attractions'  => \App\Models\Attraction::active()->featured()->limit(6)->get(),
            ]),
            'services' => $data = array_merge($data, [
                'services' => Service::active()->with('category')->get(),
            ]),
            'projects' => $data = array_merge($data, [
                'projects' => Project::active()->with('category')->get(),
            ]),
            'team' => $data = array_merge($data, [
                'teamMembers' => TeamMember::active()->get(),
            ]),
            'pricing' => $data = array_merge($data, [
                'plans' => \App\Models\PricingPlan::active()->get(),
            ]),
            default => null,
        };

        return view("frontend.page", $data);
    }
}
