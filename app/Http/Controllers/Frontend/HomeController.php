<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Counter;
use App\Models\Destination;
use App\Models\Faq;
use App\Models\Package;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\TrekRoute;
use App\Models\ContactSubmission;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function about(): View
    {
        $popularTreks = TrekRoute::active()->featured()->limit(5)->get();
        $activeTreks  = TrekRoute::active()->get();
        $counters     = Counter::active()->get();
        $testimonials = Testimonial::active()->get();
        $partners     = Partner::active()->get();

        return view('frontend.about', compact(
            'popularTreks', 'activeTreks', 'counters', 'testimonials', 'partners'
        ));
    }

    public function index(): View
    {
        $sliders        = Slider::active()->get();
        $popularTreks   = TrekRoute::active()->featured()->limit(5)->get();
        $activeTreks    = TrekRoute::active()->get();
        $hotels         = Business::active()->ofType('hotel')->featured()->limit(4)->get();
        $travelAgencies = Business::active()->ofType('travel_agency')->featured()->limit(6)->get();
        $destinations   = Destination::active()->featured()->limit(6)->get();
        $testimonials   = Testimonial::active()->get();
        $posts          = Post::published()->with('category')->latest('published_at')->limit(3)->get();
        $counters       = Counter::active()->get();
        $partners       = Partner::active()->get();
        $faqs              = Faq::active()->featured()->limit(5)->get();
        $sponsoredPackages = Package::active()->sponsored()->with('business')->limit(4)->get();

        // Live DB counts for the stats bar
        $statTrekCount     = TrekRoute::active()->count();
        $statAgencyCount   = Business::active()->ofType('travel_agency')->count();
        $statHotelCount    = Business::active()->ofType('hotel')->count();
        $statInquiryCount  = ContactSubmission::count();

        return view('frontend.home', compact(
            'sliders', 'popularTreks', 'activeTreks', 'hotels', 'travelAgencies',
            'destinations', 'testimonials', 'posts', 'counters', 'partners', 'faqs',
            'sponsoredPackages',
            'statTrekCount', 'statAgencyCount', 'statHotelCount', 'statInquiryCount'
        ));
    }
}
