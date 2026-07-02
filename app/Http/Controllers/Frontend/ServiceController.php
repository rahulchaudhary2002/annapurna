<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::active()->with('category')->get();
        $testimonials = Testimonial::active()->featured()->limit(4)->get();

        return view('frontend.services.index', compact('services', 'testimonials'));
    }

    public function show(string $slug): View
    {
        $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $otherServices = Service::active()->where('id', '!=', $service->id)->limit(5)->get();

        return view('frontend.services.show', compact('service', 'otherServices'));
    }
}
