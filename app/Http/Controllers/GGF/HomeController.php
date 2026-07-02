<?php

namespace App\Http\Controllers\GGF;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use App\Models\Project;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $sliders      = \App\Models\Slider::where('is_active', true)->where('order', '>=', 100)->orderBy('order')->get();
        $services     = Service::active()->where('order', '>=', 100)->limit(4)->get();
        $projects     = Project::active()->featured()->with('category')->where('order', '>=', 100)->limit(3)->get();
        $teamMembers  = TeamMember::active()->featured()->where('order', '>=', 100)->limit(3)->get();
        $testimonials = Testimonial::active()->where('order', '>=', 100)->get();
        $counters     = Counter::active()->where('order', '>=', 100)->get();

        return view('ggf.home', compact(
            'sliders', 'services', 'projects', 'teamMembers', 'testimonials', 'counters'
        ));
    }
}
